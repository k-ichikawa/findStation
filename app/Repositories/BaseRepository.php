<?php
namespace App\Repositories;

use Illuminate\Foundation\Application;

class BaseRepository
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}