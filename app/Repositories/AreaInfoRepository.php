<?php
namespace App\Repositories;

use Illuminate\Foundation\Application;

class AreaInfoRepository extends BaseRepository
{
    protected $model;

    /**
     * InquiryRepository constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->makeModel();
    }

    /**
     * @return mixed
     */
    public function makeModel()
    {
        $model = $this->app->make('App\Models\AreaInfo');

        return $this->model = $model;
    }

    /**
     * @param $highway_id
     * @param $direction_type
     * @return mixed
     */
    public function getByHighwayIdAndDirectionType($highway_id, $direction_type)
    {
        return $this->model->where('highway_id', $highway_id)->where('direction_type', $direction_type)->get();
    }

    /**
     * @param $area_info_id
     * @return mixed
     */
    public function getById($area_info_id)
    {
        return $this->model->find($area_info_id);
    }

    /**
     * @param $id
     * @param $nearest_station_id
     * @return mixed
     */
    public function updateByIdAndNearestStationId($id, $nearest_station_id)
    {
        return $this->model->where('id', $id)->update(['nearest_station_id' => $nearest_station_id]);
    }
}