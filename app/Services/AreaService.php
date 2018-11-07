<?php

namespace App\Services;

use App\Models\AreaInfo;
use App\Repositories\AreaInfoRepository;

class AreaService
{
    protected $areaInfoRepository;

    public function __construct(AreaInfoRepository $areaInfoRepository)
    {
        $this->areaInfoRepository = $areaInfoRepository;
    }

    /**
     * @param $area_info_id
     * @param $nearest_station_id
     * @return mixed
     */
    public function updateAreaInfoByIdAndNearestStationId($area_info_id, $nearest_station_id)
    {
        return $this->areaInfoRepository->updateByIdAndNearestStationId($area_info_id, $nearest_station_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAreaInfoById($id)
    {
        return $this->areaInfoRepository->getById($id);
    }

    /**
     * @param $highway_id
     * @return array
     */
    public function getAreaInfoByHighwayIdAndDirectionType($highway_id)
    {
        $up_area_info   = $this->areaInfoRepository->getByHighwayIdAndDirectionType($highway_id, AreaInfo::$DIRECTION_TYPE_UP);
        $down_area_info = $this->areaInfoRepository->getByHighwayIdAndDirectionType($highway_id, AreaInfo::$DIRECTION_TYPE_DOWN);

        return [$up_area_info, $down_area_info];
    }
}