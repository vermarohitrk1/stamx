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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('call/support','TwilioController@index');
Route::any('support/hangups/{user_id}', 'TwilioController@hangups');
Route::any('support/gethercall/{user_id}', 'TwilioController@getherCall');
Route::any('support/getherInput/{user_id}', 'TwilioController@getherInput');
Route::any('support/transcribecallback/{user_id}', 'TwilioController@transcribeCallback');
Route::any('support/hanguprecord/{user_id}', 'TwilioController@hangupRecord');
Route::any('support/voiceRecord/{user_id}/{dept_id}', 'TwilioController@voiceRecord');
Route::any('support/hangup/{user_id}/{dept_id}', 'TwilioController@hangup');
Route::prefix('appuser')->group(function(){
    Route::post('register','Api\ApiController@register');
    Route::post('login','Api\ApiController@login');
    Route::post('forget_password', 'Api\ApiController@forgot');
    Route::post('password/reset', 'Api\ApiController@reset');
    
    
    Route::group(['middleware' => 'auth:api'], function()
    {
        /**User Routes */
        Route::post('logout','Api\ApiController@logout');
        Route::get('profile','Api\UserController@profile');
        Route::post('profile/update','Api\UserController@profile_update');
        /**Ueser Route End */

        /** CMS Routes */
        Route::get('pages/','Api\PageController@get');
        // Route::get('page/create/','Api\PageController@create');
        Route::post('page/store','Api\PageController@store');
        Route::post('page/update','Api\PageController@update');
        Route::post('page/delete','Api\PageController@destroy');
        /**CMS Route End */
    });

}); 
