<?php

namespace App\Services;

use App\Repositories\NearestStationRepository;

class StationService
{
    protected $nearestStationRepository;

    public function __construct(NearestStationRepository $nearestStationRepository)
    {
        $this->nearestStationRepository = $nearestStationRepository;
    }

    /**
     * @param $area_info
     * @return array
     */
    public function fetchNearestStationInfo($area_info)
    {
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

        return [
            'station_name'  => $station_name,
            'latitude'      => substr((string)$station_latitude, 0, 7),
            'longitude'     => substr((string)$station_longitude, 0, 8),
        ];
    }

    /**
     * @param $input
     * @return mixed
     */
    public function createNearestStation($input)
    {
        return $this->nearestStationRepository->create($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getNearestStationById($id)
    {
        return $this->nearestStationRepository->getById($id);
    }
}