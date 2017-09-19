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

Route::get('/', function () { return view('welcome'); });
Auth::routes();


/* ------ Admin Route -----------*/
Route::get('admin/home',					'AdminController@index');
Route::get('admin',							'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin',						'Admin\LoginController@login');
Route::post('admin-password/email',			'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::post('admin-password/reset',			'Admin\ResetPasswordController@reset');
Route::get('admin-password/reset',			'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::get('admin-password/reset/{token}',	'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
/* ------ End Admin Route -------*/


Route::get('/overview', function () { return view('Community.overview'); });
Route::get('/review', function () { return view('Community.review'); });
Route::get('/activity', function () {  return view('Community.activity');  });
Route::get('/contactPopUp', function () {  return view('Community.popUp');  });
Route::get('/uploadPhoto', function () {   return view('Community.uploadPhoto');  });

Route::get('/projects', function () {
    return view('Community.projects');
});

/* --- Socialite Authentication --- */
Route::get('login/{provider}', 							'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 				'Auth\LoginController@handleProviderCallback');

/*----- Public Profile Controller ---------*/
Route::get('profile/{token}',							'ProfileController@index');
Route::get('profile2/{token}',							'ProfileController@index2');
Route::post('api/get_user_data',						'ProfileController@get_user_profile');
Route::post('api/review/get_review_rate_bref',			'ProfileController@get_review_rate_bref');
Route::post('api/review/get_recieve_review',			'ProfileController@get_recieve_review');
Route::post('/projects',								'ProfileController@get_projects');
Route::post('/activity',								'ProfileController@get_activity');
Route::post('api/profile/add_contact_info', 			'ProfileController@add_contactInfo');

/*-----Desinger User Profile Controller  --------*/
Route::post('api/profile/update_profile_name', 			'User\ProfileController@updateName');
Route::post('api/profile/update_addition_info', 		'User\ProfileController@updateAdditionalInfo');
Route::post('api/feed/post', 							'User\ProfileController@post');

Route::get('/api/feed/getuserdata',                      'User\ProfileController@getUserData');
Route::post('/api/profile/update_avatar_image', 		'User\ProfileController@updateAvatar');
Route::post('/api/profile/update_cover_image', 			'User\ProfileController@updateCover');

/*------ End user Controller -----------*/
Route::post('api/user/change_name', 					'User\EndUserController@changeName');
Route::get('/home', 									'HomeController@index')->name('home');

/*---- All User Review Controller -------*/
Route::post('api/user/review/create_review_user', 		'User\AllUserController@create_review_user');
Route::post('api/user/review/create_review_project', 	'User\AllUserController@create_review_project');// not finish
Route::post('api/user/review/update_review', 			'User\AllUserController@update_review');
Route::post('api/user/review/check_exist_review',		'User\AllUserController@check_exist_review');
Route::get('api/user/review/get_reviewing_review',		'User\AllUserController@get_reviewing_review');
Route::post('/api/user/follow/follow_user',				'User\AllUserController@follow_user');

/* --- Select Role ----*/
Route::post('selectrole',[ 'as' => 'selectrole', 'uses' => 'Auth\LoginController@selectRole']);

/* --- User Profile Project Controller ---*/

Route::post('/project/create_project','UserProfileProjectController@createProject');
Route::post('/project/delete_project','UserProfileProjectController@deleteProject');
Route::post('/project/show_user_project','UserProfileProjectController@showUserProjects');
Route::post('/project/add_project_image','UserProfileProjectController@addProjectImage');
Route::post('/project/add_project_image2','UserProfileProjectController@addProjectImage2');
Route::post('/project/delete_project_image','UserProfileProjectController@deleteProjectImage');
Route::post('/project/update_project_info','UserProfileProjectController@updateProjectInfo');
Route::post('/project/update_project_image','UserProfileProjectController@updateProjectImage');
Route::post('/project/add_project_video','UserProfileProjectController@addProjectVideo');
Route::post('/project/delete_project_video','UserProfileProjectController@deleteProjectVideo');
Route::post('/project/update_project_video','UserProfileProjectController@updateProjectVideo');

/* ------ Feed Controller -----*/
Route::get('feed',										'FeedController@index')->name('feed');


/* --- Kevin Test Use ---*/
/* Test URL are like
http://velozdesign.app/test6?project_id=596bf07d9a892006430dcfc4&image_id=596bf745b80c1&title=abc&link=aaa.com
attribute: project_id, image_id, title, link
*/
Route::get('/test1','UserProfileProjectController@createProject');
Route::get('/test2','UserProfileProjectController@deleteProject');
Route::get('/test3','UserProfileProjectController@addProjectImage');
Route::get('/test4','UserProfileProjectController@deleteProjectImage');
Route::get('/test5','UserProfileProjectController@updateProjectInfo');
Route::get('/test6','UserProfileProjectController@updateProjectImage');
Route::get('/aws','AWS\AWSController@upload');
Route::get('/aws2','AWS\AWSController@upload2');
Route::get('/test7','UserProfileProjectController@createProject');
Route::get('/test8','UserProfileProjectController@showUserProjects');
Route::get('/test9', 		'User\ProfileController@updateAvatar');
Route::get('/test10', 			'User\ProfileController@updateCover');

Route::get('/project/create_project','UserProfileProjectController@createProject');
Route::get('/project/delete_project','UserProfileProjectController@deleteProject');
Route::get('/project/show_user_project','UserProfileProjectController@showUserProjects');
Route::get('/project/add_project_image','UserProfileProjectController@addProjectImage');
Route::get('/project/add_project_image2','UserProfileProjectController@addProjectImage2');
Route::get('/project/delete_project_image','UserProfileProjectController@deleteProjectImage');
Route::get('/project/update_project_info','UserProfileProjectController@updateProjectInfo');
Route::get('/project/update_project_image','UserProfileProjectController@updateProjectImage');
Route::get('/project/add_project_video','UserProfileProjectController@addProjectVideo');
Route::get('/project/delete_project_video','UserProfileProjectController@deleteProjectVideo');
Route::get('/project/update_project_video','UserProfileProjectController@updateProjectVideo');


Route::post('/uploadTest','AWS\AWSController@uploadToS3');
Route::post('/uploadFromUrl','AWS\AWSController@uploadToS3FromUrl');
Route::get('/test', 'UserProfileProjectController@index');
//Route::get('/uploadFromUrl','AWS\AWSController@uploadToS3FromUrl');
