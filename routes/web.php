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
Route::get('', 'AdminAuth\LoginController@showLoginForm');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'franchise'], function () {
  Route::get('/login', 'FranchiseAuth\LoginController@showLoginForm');
  Route::post('/login', 'FranchiseAuth\LoginController@login');
  Route::post('/logout', 'FranchiseAuth\LoginController@logout');

  Route::get('/register', 'FranchiseAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'FranchiseAuth\RegisterController@register');

  Route::post('/password/email', 'FranchiseAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'FranchiseAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'FranchiseAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'FranchiseAuth\ResetPasswordController@showResetForm');
});

//Admission Form
Route::get('/admissionform', 'Frontend\AdmissionformController@index');
Route::post('/admissionform/send','Frontend\AdmissionformController@send');
Route::get('/admissionform/admissionthankyou','Frontend\AdmissionformController@admissionthankyou');
Route::get('/admissionform/pdfdownload/{name}','Frontend\AdmissionformController@pdfdownload');

//Employment Form
Route::get('/employmentstart', 'Frontend\EmploymentformController@employmentstart');
Route::get('/employmentform', 'Frontend\EmploymentformController@index');
Route::post('/employmentform/send', 'Frontend\EmploymentformController@send');
Route::get('/employmentform/employmentthankyou','Frontend\EmploymentformController@employmentthankyou');
Route::get('/employmentform/pdfdownload/{name}','Frontend\EmploymentformController@pdfdownload');
Route::post('/emailexist','Frontend\EmploymentformController@EmailExist');

Route::get('refresh-csrf', function(){
    return csrf_token();
});

//Admin
Route::get('/admin', function(){
	if(Auth::check('admin')){
		return redirect('admin/dashboard');
	}else{
		return redirect('admin/login');
	}
});

//Franchise
Route::get('/franchise', function(){
	if(Auth::check('franchise')){
		return redirect('franchise/dashboard');
	}else{
		return redirect('franchise/login');
	}
});

//Femployee
Route::get('/femployee', function(){
	if(Auth::check('femployee')){
		return redirect('femployee/dashboard');
	}else{
		return redirect('femployee/login');
	}
});

Route::group(['prefix' => 'femployee'], function () {
  Route::get('/login', 'FemployeeAuth\LoginController@showLoginForm');
  Route::post('/login', 'FemployeeAuth\LoginController@login');
  Route::post('/logout', 'FemployeeAuth\LoginController@logout');

  Route::get('/register', 'FemployeeAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'FemployeeAuth\RegisterController@register');

  Route::post('/password/email', 'FemployeeAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'FemployeeAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'FemployeeAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'FemployeeAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'parent'], function () {
  Route::get('/login', 'ParentAuth\LoginController@showLoginForm');
  Route::post('/login', 'ParentAuth\LoginController@login');
  Route::post('/logout', 'ParentAuth\LoginController@logout');

  Route::get('/register', 'ParentAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'ParentAuth\RegisterController@register');

  Route::post('/password/email', 'ParentAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'ParentAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'ParentAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'ParentAuth\ResetPasswordController@showResetForm');
});

Route::get('/crones', 'CronesController@FranchiseExpiration');
Route::get('/franchisependingtasks', 'CronesController@taskPendingFranchise');
Route::get('/franchiseexipirationemployee', 'CronesController@FranchiseEmployeeExpiration');
Route::get('/testcron', 'CronesController@testPayment');

Route::get('/productimage/{img}',function($img){
    //return '/storage/products_images/jWrzFlCyb3rsK6OoMhGYmqzxRqcvseHKQGUKtL2i.png';
    return \Image::make(public_path('storage/products_images/'.$img))->fit(50, 50)->response(pathinfo($img,PATHINFO_EXTENSION));
});