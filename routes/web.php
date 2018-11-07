<?php

Route::get('/', 'Controller@showIndex')->name('app');

Route::get('/get-area-info/{highway_id?}', 'AreaInfoController@getAreaInfo');
Route::get('/get-station-info/{area_info_id?}', 'AreaInfoController@getAreaDetail');