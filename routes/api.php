<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'subreddits'], function () {
    Route::get('/', 'SubRedditController@index');
    Route::get('/{sub_reddit}', 'SubRedditController@show');
    Route::post('/', 'SubRedditController@store')->middleware('auth:api');
    Route::patch('/{sub_reddit}', 'SubRedditController@update')->middleware('auth:api');
    Route::delete('/{sub_reddit}', 'SubRedditController@destroy')->middleware('auth:api');

    Route::group(['prefix' => '/{sub_reddit}/posts'], function () {
        Route::get('/{post}', 'PostController@show');
        Route::post('/', 'PostController@store')->middleware('auth:api');
        Route::patch('/{post}', 'PostController@update')->middleware('auth:api');
        Route::delete('/{post}', 'PostController@destroy')->middleware('auth:api');

        Route::group(['prefix' => '/{post}'], function () {
            Route::post('/upvotes', 'PostUpvoteController@store')->middleware('auth:api');
            Route::post('/downvotes', 'PostDownvoteController@store')->middleware('auth:api');

            Route::group(['prefix' => '/comments'], function () {
                Route::get('/{comment}', 'CommentController@show');
                Route::post('/', 'CommentController@store')->middleware('auth:api');
                Route::patch('/{comment}', 'CommentController@update')->middleware('auth:api');
                Route::delete('/{comment}', 'CommentController@destroy')->middleware('auth:api');

                Route::group(['prefix' => '/{comment}'], function () {
                    Route::post('/upvotes', 'CommentUpvoteController@store')->middleware('auth:api');
                    Route::post('/downvotes', 'CommentDownvoteController@store')->middleware('auth:api');
                });
            });
        });
    });

});