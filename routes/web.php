<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/user/personal-page/{id}', 'UserController@personalPage')->name('personal.page');
Route::get('/user/detail-info/{id}', 'UserController@displayInfo')->name('detail.info');
Route::post('/post/create', 'PostController@create')->name('post.create');
Route::get('/post/map/get_info', 'PostController@getMapInfo')->name('post.map.info');

Route::post('/comment/send', 'CommentController@sendMessage')->name('comment.send');
Route::get('comment/get', 'CommentController@getCommentInPost')->name('comment.get');

Route::post('/user/change_avatar', 'UserController@changeAvatar')->name('user.change_avatar');


Route::get('storage/post/{postId}/{filename}', 'FileStorageController@getPostImage')->name('file.post_image');
