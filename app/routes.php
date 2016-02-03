<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Register all the admin routes.
  |
 */

Route::group(['prefix' => 'admin'], function () {

    // Blog Management
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', ['as' => 'blogs', 'uses' => 'Controllers\Admin\BlogsController@getIndex']);
        Route::get('create', ['as' => 'create/blog', 'uses' => 'Controllers\Admin\BlogsController@getCreate']);
        Route::post('create', 'Controllers\Admin\BlogsController@postCreate');
        Route::get('{blogId}/edit', ['as' => 'update/blog', 'uses' => 'Controllers\Admin\BlogsController@getEdit']);
        Route::post('{blogId}/edit', 'Controllers\Admin\BlogsController@postEdit');
        Route::get('{blogId}/delete', ['as' => 'delete/blog', 'uses' => 'Controllers\Admin\BlogsController@getDelete']);
        Route::get('{blogId}/restore', ['as' => 'restore/blog', 'uses' => 'Controllers\Admin\BlogsController@getRestore']);
    });

    // User Management
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex']);
        Route::get('create', ['as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate']);
        Route::post('create', 'Controllers\Admin\UsersController@postCreate');
        Route::get('{userId}/edit', ['as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit']);
        Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
        Route::get('{userId}/delete', ['as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete']);
        Route::get('{userId}/restore', ['as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore']);
    });

    // Group Management
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', ['as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex']);
        Route::get('create', ['as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate']);
        Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
        Route::get('{groupId}/edit', ['as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit']);
        Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
        Route::get('{groupId}/delete', ['as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete']);
        Route::get('{groupId}/restore', ['as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore']);
    });

    // Dashboard
    Route::get('/', ['as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex']);
});

/*
  |--------------------------------------------------------------------------
  | Authentication and Authorization Routes
  |--------------------------------------------------------------------------
  |
  |
  |
 */

Route::group(['prefix' => 'auth'], function () {

    // Social Login

    Route::get('facebook-authentication', ['uses' => 'AuthController@getFacebookAuthentication', 'as' => 'facebook-login']);
    Route::get('linkedin-authentication', ['uses' => 'AuthController@getLinkedinAuthentication', 'as' => 'linkdin-login']);
    Route::get('twitter-authentication', ['uses' => 'AuthController@getTwitterAuthentication', 'as' => 'twitter-login']);

    Route::get('email-required-for-twitter-authentication', ['uses' => 'AuthController@getTwitterMail', 'as' => 'twitter-email']);
    Route::post('email-required-for-twitter-authentication', ['uses' => 'AuthController@postTwitterMail']);

    // Login
    Route::get('signin', ['as' => 'signin', 'uses' => 'AuthController@getSignin']);
    Route::post('signin', 'AuthController@postSignin');

    // Register
    Route::get('signup', ['as' => 'signup', 'uses' => 'AuthController@getSignup']);
    Route::post('signup', 'AuthController@postSignup');

    // Account Activation
    Route::get('activate/{activationCode}', ['as' => 'activate', 'uses' => 'AuthController@getActivate']);

    // Forgot Password
    Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword']);
    Route::post('forgot-password', 'AuthController@postForgotPassword');

    // Forgot Password Confirmation
    Route::get('forgot-password/{passwordResetCode}', ['as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm']);
    Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

    // Logout
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
});

/*
  |--------------------------------------------------------------------------
  | Account Routes
  |--------------------------------------------------------------------------
  |
  |
  |
 */

Route::group(['prefix' => 'account'], function () {

    // Account Dashboard
    Route::get('/', ['as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex']);

    // Profile
    Route::get('profile', ['as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex']);
    Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

    // Change Password
    Route::get('change-password', ['as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex']);
    Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

    // Change Email
    Route::get('change-email', ['as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex']);
    Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');
});

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('about-us', function () {
    //
    return View::make('frontend/about-us');
});

Route::get('contact-us', ['as' => 'contact-us', 'uses' => 'ContactUsController@getIndex']);
Route::post('contact-us', 'ContactUsController@postIndex');

Route::get('blog/{postSlug}', ['as' => 'view-post', 'uses' => 'BlogController@getView']);
Route::post('blog/{postSlug}', 'BlogController@postView');

Route::get('/', ['as' => 'home', 'uses' => 'BlogController@getIndex']);
