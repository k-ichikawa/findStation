<?php

namespace App\Http\Controllers;

use App\Models\AreaInfo;
use App\Repositories\AreaInfoRepository;
use App\Repositories\NearestStationRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class AreaInfoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $areaInfoRepository;
    protected $nearestStationRepository;

    public function __construct(
        AreaInfoRepository $areaInfoRepository,
        NearestStationRepository $nearestStationRepository
    ){
        $this->areaInfoRepository       = $areaInfoRepository;
        $this->nearestStationRepository = $nearestStationRepository;
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getAreaInfo(Request $request)
    {
        $highway_id     = $request->get('highway_id');

        $up_area_info   = $this->areaInfoRepository->getByHighwayIdAndDirectionType($highway_id, AreaInfo::$DIRECTION_TYPE_UP);
        $down_area_info = $this->areaInfoRepository->getByHighwayIdAndDirectionType($highway_id, AreaInfo::$DIRECTION_TYPE_DOWN);

        return json_encode([
            'up_area_info'      => $up_area_info,
            'down_area_info'    => $down_area_info
        ]);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getAreaDetail(Request $request)
    {
        $area_info_id = $request->get('area_info_id');

        $area_info = $this->areaInfoRepository->getById($area_info_id);

        if (is_null($area_info->nearest_station_id)) {
            $area_latitude  = $area_info->latitude;
            $area_longitude = $area_info->longitude;

            $url = 'http://express.heartrails.com/api/json?method=getStations';
            $url = $url . '&x=' . $area_longitude . '&y=' . $area_latitude;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($ch);
            curl_close($ch);

            $json = mb_convert_encoding($res, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            $station = json_decode($json, true);

            $station_name       = $station['response']['station'][0]['name'];
            $station_latitude   = $station['response']['station'][0]['y'];
            $station_longitude  = $station['response']['station'][0]['x'];

            $input = [
                'station_name'  => $station_name,
                'latitude'      => substr((string)$station_latitude, 0, 7),
                'longitude'     => substr((string)$station_longitude, 0, 8),
            ];

            DB::beginTransaction();

            try {
                $nearest_station = $this->nearestStationRepository->create($input);
                $this->areaInfoRepository->updateByIdAndNearestStationId($area_info_id, $nearest_station->id);

                DB::commit();

                $area_info = $this->areaInfoRepository->getById($area_info_id);
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        $nearest_station = $this->nearestStationRepository->getById($area_info->nearest_station_id);

        $units          = 'metric';
        $mode           = 'walking';
        $origins        = $area_info->latitude . ',' . $area_info->longitude;
        $destinations   = $nearest_station->latitude . ',' . $nearest_station->longitude;
        $api_key        = 'AIzaSyB_o0aczicYNHiWJwl--4epuZOSQQKuuAU';

        $google_map_api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json';

        $google_map_api_url
            = $google_map_api_url .
            '?units='           . $units .
            '&mode='            . $mode .
            '&origins='         . $origins .
            '&destinations='    . $destinations .
            '&key='             . $api_key;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $google_map_api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        curl_close($ch);

        $json = mb_convert_encoding($res, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $result = json_decode($json, true);

        return json_encode([
            'result'        => true,
            'station_name'  => $nearest_station->station_name,
            'distance'      => $result['rows'][0]['elements'][0]['distance']['text'],
            'time_required' => $result['rows'][0]['elements'][0]['duration']['text'],
            'is_anytime'    => $area_info->anytime_flg == AreaInfo::$ANYTIME_OPEN,
            'open_time'     => $area_info->open_time,
            'close_time'    => $area_info->close_time
        ]);
    }
}
