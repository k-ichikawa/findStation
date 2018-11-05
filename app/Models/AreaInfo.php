<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaInfo extends Model
{
    use SoftDeletes;

    protected $table = 'area_info';

    protected $fillable = [
        'highway_id',
        'area_name',
        'area_kana_name',
        'latitude',
        'longitude',
        'nearest_station_id'
    ];
}
