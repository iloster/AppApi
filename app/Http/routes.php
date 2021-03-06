<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
//http://localhost/AppApi/public/index.php/netease/type/main/page/0
Route::get('/netease/type/{type}/page/{page}',"NeteaseController@getNewsByType");
//http://localhost/AppApi/public/index.php/v2ex/node/qna/page/1
Route::get('/v2ex/node/{node}/page/{page}','V2exController@getNewsByNode');

Route::get('/v2ex/test','V2exController@test');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
