<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NearestStation extends Model
{
    use SoftDeletes;

    protected $table = 'nearest_stations';

    protected $fillable = [
        'station_name',
        'latitude',
        'longitude'
    ];
}
