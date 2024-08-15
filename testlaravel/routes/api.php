<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BeautyFrontController; 
use App\Http\Controllers\BeautyBackController; 
use App\Http\Controllers\UploadController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload', [UploadController::class, 'upload']);

Route::get("/beauty_front2_get_schedule_fortime/{date}", function($date) {
    $result = DB::table("beauty_order")
                ->where("date", $date)
                ->get();
    return response()->json($result);
});

Route::post('/beauty_front2_insert_order', function (Request $request) {
    // 取得請求中的資料
    $data = $request->all();

    // 插入資料到 beauty_order 表
    DB::table('beauty_order')->insert([
        'uid'        => $data['uid'],
        'pid'        => $data['pid'],
        'planid'     => $data['planid'],
        'branch'     => $data['branch'],
        'date'       => $data['date'],
        'start_time' => $data['start_time'],
        'use_time'   => $data['use_time'],
        'end_time'   => $data['end_time'],
        'price'      => $data['price'],
    ]);

    return response()->json(['message' => 'Data inserted successfully']);
});

Route::get('/back_beauty_get_history_order_onepet/{pid}/{date}',  [BeautyBackController::class, 'get_beauty_history_order_onepet']);

Route::get('back_beauty_get_order_oneweek/{first_date}/{last_date}', [BeautyBackController::class, 'get_beauty_order_oneweek']);

Route::get('/front_beauty_plan_info', [BeautyFrontController::class, 'front_beauty_plan_info']);

Route::post('/front_beauty_plan_price_time', [BeautyFrontController::class, 'front_beauty_plan_price_time']);

Route::get('/front_beauty_pet_info/{uid}', [BeautyFrontController::class, 'front_beauty_pet_info']);

Route::get('/front2_beauty_select_beauty_plan_price_time/{pet_species}/{pet_weight}/{pet_fur}/{planid}', [BeautyFrontController::class, 'front2_beauty_select_beauty_plan_price_time']);