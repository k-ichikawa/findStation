<?php

namespace App\Services;

use App\Models\AreaInfo;
use App\Repositories\NearestStationRepository;

class MapService
{
    protected $nearestStationRepository;

    public function __construct(NearestStationRepository $nearestStationRepository)
    {
        $this->nearestStationRepository = $nearestStationRepository;
    }

    /**
     * @param $area_info
     * @param $nearest_station
     * @return array
     */
    public function fetchDistanceInfo($area_info, $nearest_station)
    {
        $units          = 'metric';
        $language       = 'ja';
        $mode           = 'walking';
        $origins        = $area_info->latitude . ',' . $area_info->longitude;
        $destinations   = $nearest_station->latitude . ',' . $nearest_station->longitude;
        $api_key        = 'AIzaSyB_o0aczicYNHiWJwl--4epuZOSQQKuuAU';

        $google_map_api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json';

        $google_map_api_url
            = $google_map_api_url .
            '?units='           . $units .
            '&language='        . $language .
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

        return [
            'station_name'  => $nearest_station->station_name,
            'distance'      => $result['rows'][0]['elements'][0]['distance']['text'],
            'time_required' => $result['rows'][0]['elements'][0]['duration']['text'],
            'is_anytime'    => $area_info->anytime_flg == AreaInfo::$ANYTIME_OPEN,
            'open_time'     => $area_info->open_time,
            'close_time'    => $area_info->close_time
        ];
    }
}