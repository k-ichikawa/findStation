<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Highway extends Model
{
    use SoftDeletes;

    protected $table = 'highway';

    protected $fillable = ['name', 'kane_name'];
}
