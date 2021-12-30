<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:api', 'scope:view-user'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/posts', 'Api\PostsController@index')
    ->middleware(['auth:api', 'scope:view-posts']);



    Route::get('/oauth/clients',function(){
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'localhost/Projects/laravel-passport-oAuth2-example/server/public/api/oauth/clients',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
    });