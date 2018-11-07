<?php

namespace App\Http\Controllers;

use App\Services\AreaService;
use App\Services\MapService;
use App\Services\StationService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class AreaInfoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $mapService;
    protected $areaService;
    protected $stationService;

    public function __construct(
        MapService $mapService,
        AreaService $areaService,
        StationService $stationService
    ){
        $this->mapService       = $mapService;
        $this->areaService      = $areaService;
        $this->stationService   = $stationService;
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getAreaInfo(Request $request)
    {
        $highway_id = $request->get('highway_id');

        list($up_area_info, $down_area_info) = $this->areaService->getAreaInfoByHighwayIdAndDirectionType($highway_id);

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
        $area_info_id   = $request->get('area_info_id');
        $area_info      = $this->areaService->getAreaInfoById($area_info_id);

        if (is_null($area_info->nearest_station_id)) {
            $input = $this->stationService->fetchNearestStationInfo($area_info);

            DB::beginTransaction();
            try {
                $nearest_station = $this->stationService->createNearestStation($input);
                $this->areaService->updateAreaInfoByIdAndNearestStationId($area_info_id, $nearest_station->id);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }

            $area_info = $this->areaService->getAreaInfoById($area_info_id);
        }

        $nearest_station    = $this->stationService->getNearestStationById($area_info->nearest_station_id);
        $result             = $this->mapService->fetchDistanceInfo($area_info, $nearest_station);

        return json_encode($result);
    }
}
