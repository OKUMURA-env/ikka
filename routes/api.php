<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//開発中...
// ユーザー登録
Route::post('/register', [RegisterController::class, 'register']);
// ログイン
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    //ログアウト
    Route::post('/logout', LogoutController::class);

    //ログインユーザー取得
    Route::get('/user-get',[App\Http\Controllers\UserController::class,'userGet']);

    //Event crud
    Route::post('event/event-get',[App\Http\Controllers\EventController::class,'eventGet']);
    Route::resource('event',App\Http\Controllers\EventController::class)->only(['store','show','update','destroy']);

    //ファイルアップロード
    Route::post('upload-file', App\Http\Controllers\UploadFileController::class);

    //カテゴリー
    Route::resource('schedule-categories',App\Http\Controllers\ScheduleCategoryController::class)->only(['index','store','show','edit','update','destroy']);

    //ドライバー設定
    Route::resource('drivers',App\Http\Controllers\DriverController::class)->only(['index','store','show','edit','update','destroy']);

    //リアルタイム検索
    Route::get('search-event', App\Http\Controllers\SearchEventController::class);

});
    
