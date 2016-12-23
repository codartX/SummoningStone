<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
*/

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

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/home', 'HomeController@index');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function ($api) {
    $api->get('activities_list', 'PublicController@getActivitiesList');

    $api->group(['middleware' => 'oauth:activity_control'],function($api){
        $api->get('activity/{activity_id}','ActivityController@getActivity');
        $api->post('activity','ActivityController@createActivity');
        $api->delete('activity/{activity_id}','ActivityController@deleteActivity');
        $api->post('activity/{activity_id}','ActivityController@updateActivity');
        $api->post('activity/{activity_id}/apply','ActivityController@applyActivity');
        $api->post('activity/{activity_id}/quit','ActivityController@quitActivity');
        $api->post('activity/{activity_id}/join/{user_id}','ActivityController@joinActivity');
    });

    $api->group(['middleware' => 'oauth:comment_control'],function($api){
        $api->get('activity/{activity_id}/comments', 'CommentController@getComments');
        $api->post('activity/{activity_id}/comments', 'CommentController@createComment');
        $api->post('activity/{activity_id}/comments/{comment_id}', 'CommentController@updateComment');
        $api->delete('activity/{activity_id}/comments/{comment_id}','CommentController@deleteComment');
    });

    $api->group(['middleware' => 'oauth:message_control'],function($api){
        $api->get('messages', 'MessageController@getMessages');
        $api->post('messages', 'MessageController@createMessage');
        $api->post('messages/{message_id}', 'MessageController@openMessage');
        $api->delete('messages/{message_id}','MessageController@deleteMessage');
    });
});
