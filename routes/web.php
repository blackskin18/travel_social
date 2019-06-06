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

Route::get('/user/personal-page/{id}', 'UserController@showPersonalPage')->name('user.personal_page');
Route::get('/user/detail-info/{id}', 'UserController@displayInfo')->name('detail.info');
Route::post('/user/change_avatar', 'UserController@changeAvatar')->name('user.change_avatar');

Route::get('/user/{user_id}/list_friend', 'UserController@showListFriend')->name('user.list_friend');

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

//trip
Route::get('trip/follow_position/{tripId}', 'TripController@followPosition')->name('trip.follow_position');
Route::get('trip/create', 'TripController@create')->name('trip.create');
Route::get('trip/detail_info/{tripId}', 'TripController@show')->name('trip.show');
Route::get('trip/list', 'TripController@showList')->name('trip.list');
Route::post('trip/store', 'TripController@store')->name('trip.store');
Route::delete('trip/delete', 'TripController@delete')->name('trip.delete');
Route::get('trip/{trip_id}/edit', 'TripController@edit')->name('trip.edit');
Route::put('trip/{trip_id}', 'TripController@update')->name('trip.update');
//invitation
Route::post('trip/invitation/add', 'MemberTripController@inviteFriend')->name('invitation.add');
Route::post('trip/invitation/accept', 'MemberTripController@acceptInvitation')->name('invitation.accept');
Route::delete('trip/invitation/reject_or_delete', 'MemberTripController@rejectOrDeleteInvitation')->name('invitation.decline_or_cancel');
//join request
Route::post('trip/join-request/create', 'MemberTripController@createJoinRequest')->name('join_request.create');
Route::post('trip/join-request/accept', 'MemberTripController@acceptJoinRequest')->name('join_request.accept');
Route::delete('trip/join-request/reject_or_cancel', 'MemberTripController@rejectJoinRequest')->name('join_request.reject_or_cancel');
//member
Route::delete('trip/leave', 'MemberTripController@leave')->name('trip.leave');
//friend
Route::post('friends/send-request', 'FriendController@sendRequest')->name('friend.send_request');
Route::post('friends/cancel-request', 'FriendController@cancelRequest')->name('friend.cancel_request');
Route::post('friends/accept-request', 'FriendController@acceptRequest')->name('friend.accept_request');
//notification
Route::get('notification/get-all', 'NotificationController@getAll')->name('notification.get_all');
Route::get('notification/seen_all_friend_notification', 'NotificationController@seenAllFriendNotify')->name('notification.friend.seen_all');
Route::get('notification/seen_all_member_notification', 'NotificationController@seenAllMemberNotify')->name('notification.member.seen_all');
Route::get('notification/seen_all_other_notification', 'NotificationController@seenAllOtherNotify')->name('notification.member.seen_all');

Route::get('test_firebase', 'CommentController@testFirebase');
Route::get('comment/post', 'CommentController@storePostComment');
Route::get('comment/post/edit', 'CommentController@editPostComment');
Route::get('comment/post/remove', 'CommentController@removePostComment');

Route::get('comment/trip', 'CommentController@storeTripComment');
Route::get('comment/trip/edit', 'CommentController@editTripComment');
Route::get('comment/trip/remove', 'CommentController@removeTripComment');


Route::get('search/friend', 'SearchController@searchFriend');
Route::get('search/post', 'SearchController@searchPost');
