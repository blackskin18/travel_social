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
    return redirect('home');
    //return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/personal-page/{id}', 'UserController@showPersonalPage')->name('personal.page');
Route::get('/user/detail-info/{id}', 'UserController@displayInfo')->name('detail.info');
Route::post('/user/change_avatar', 'UserController@changeAvatar')->name('user.change_avatar');

Route::post('/user/edit/edit_name', 'UserController@updateName')->name('user.update.name');
Route::post('/user/edit/edit_nick_name', 'UserController@updateNickName')->name('user.update.nick_name');
Route::post('/user/edit/edit_phone', 'UserController@updatePhone')->name('user.update.phone');
Route::post('/user/edit/edit_gender', 'UserController@updateGender')->name('user.update.gender');
Route::post('/user/edit/edit_address', 'UserController@updateAddress')->name('user.update.address');
Route::post('/user/edit/edit_email', 'UserController@updateEmail')->name('user.update.email');
Route::post('/user/edit/edit_description', 'UserController@updateDescription')->name('user.update.description');

Route::post('/post/create', 'PostController@create')->name('post.create');
Route::get('/post/map/get_info', 'PostController@getMapInfo')->name('post.map.info');
Route::get('/post/detail/{id}', 'PostController@getDetailPost')->name('post.detail');
Route::delete('/post/delete/{id}', 'PostController@destroy')->name('post.destroy');
Route::get('post/edit/{id}', 'PostController@edit')->name('post.edit');
Route::post('post/update/{id}', 'PostController@update')->name('post.update');


Route::post('/comment/send', 'CommentController@sendMessage')->name('comment.send');
Route::get('/comment/get', 'CommentController@getCommentInPost')->name('comment.get');


Route::post('/like', 'LikeController@addLike')->name('like.add');


Route::get('storage/post/{postId}/{filename}', 'FileStorageController@getPostImage')->name('file.post_image');

// location base service
Route::get('follow_location', 'LocationServiceController@index')->name('location.service');

//trip
Route::get('trip/create', 'LocationServiceController@create')->name('trip.create');
Route::post('trip/store', 'LocationServiceController@store')->name('trip.store');
