<?php
namespace App\Repositories;

use Illuminate\Foundation\Application;

class NearestStationRepository extends BaseRepository
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
        $model = $this->app->make('App\Models\NearestStation');

        return $this->model = $model;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }
}