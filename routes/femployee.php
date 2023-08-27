<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('femployee')->user();

    //dd($users);

    return view('femployee.home');
})->name('home');*/


Route::get('/dashboard', '\App\Http\Controllers\Femployee\DashboardController@index')->name('home');

//Profile
Route::get('/edit_profile', '\App\Http\Controllers\Femployee\FemployeeController@editProfile');
Route::post('/store_profile', '\App\Http\Controllers\Femployee\FemployeeController@storeProfile');

//Employee
Route::any('/edit', '\App\Http\Controllers\Femployee\FemployeeController@edit');
Route::get('/view', '\App\Http\Controllers\Femployee\FemployeeController@index')->name('view');
Route::post('/emailexist/', '\App\Http\Controllers\Femployee\FemployeeController@EmailExist');
Route::any('/viewtasklist', '\App\Http\Controllers\Femployee\FemployeeController@viewTasklist');
Route::any('/editbenifits', '\App\Http\Controllers\Femployee\FemployeeController@editBenifits');
Route::any('/addrelation', '\App\Http\Controllers\Femployee\FemployeeController@addRelation');
Route::any('/editrelation/{relation_id}', '\App\Http\Controllers\Femployee\FemployeeController@editRelation');
Route::get('/deletecontact/{contact_id}', '\App\Http\Controllers\Femployee\FemployeeController@deletecontact');
Route::any('/addcertification', '\App\Http\Controllers\Femployee\FemployeeController@addCertification');
Route::any('/editcertification/{certification_id}', '\App\Http\Controllers\Femployee\FemployeeController@editCertification');
Route::any('/deletecertification/{certification_id}', '\App\Http\Controllers\Femployee\FemployeeController@deleteCertification');
Route::any('/addcredential', '\App\Http\Controllers\Femployee\FemployeeController@addCredential');
Route::any('/editcredential/{credential_id}', '\App\Http\Controllers\Femployee\FemployeeController@editCredential');
Route::any('/deletecredential/{credential_id}', '\App\Http\Controllers\Femployee\FemployeeController@deleteCredential');
Route::any('/invite', '\App\Http\Controllers\Femployee\FemployeeController@inviteEmployee');

//Performance
Route::get('/performance', '\App\Http\Controllers\Femployee\PerformanceController@index')->name('performance');

//Cargo Hold
Route::get('/cargohold', '\App\Http\Controllers\Femployee\CargoholdController@index')->name('cargohold');
Route::get('/cargohold/uploaddocument', '\App\Http\Controllers\Femployee\CargoholdController@uploadDocument');
Route::post('/cargohold/add-document', '\App\Http\Controllers\Femployee\CargoholdController@addDocument');
Route::post('/cargohold/edit-document/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@editDocument');
Route::get('/cargohold/edit', '\App\Http\Controllers\Femployee\CargoholdController@uploadDocument');
Route::get('/cargohold/viewpdf/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@cargoHoldView');
Route::get('/cargohold/downloadpdf/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@cargoHoldDownload');
Route::get('/cargohold/deletecargohold/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@deleteCargoHold');
Route::get('/cargohold/archivecargohold/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@archiveCargoHold');
Route::get('/cargohold/activecargohold/{cargo_id}', '\App\Http\Controllers\Femployee\CargoholdController@activeCargoHold');

//Message
Route::get('/messages', '\App\Http\Controllers\Femployee\MessageController@index')->name('messages');
Route::get('/messages/{name?}/{id?}', '\App\Http\Controllers\Femployee\MessageController@index')->name('messages');
Route::get('/message_status/{name?}/{id?}', '\App\Http\Controllers\Femployee\MessageController@message_status')->name('message_status');
Route::post('/send_message', '\App\Http\Controllers\Femployee\MessageController@send_message')->name('send_message');

//Trip Itinerary
Route::any('/trip_itinerary', '\App\Http\Controllers\Femployee\TripItineraryController@index')->name('trip_itinerary');
Route::get('/trip_itinerary/edit', '\App\Http\Controllers\Femployee\TripItineraryController@edit');
Route::post('/trip_itinerary/update', '\App\Http\Controllers\Femployee\TripItineraryController@update');
Route::post('/trip_itinerary/add/', '\App\Http\Controllers\Femployee\TripItineraryController@add');
Route::any('/viewtripitinerary/{employee_id}', '\App\Http\Controllers\Femployee\TripItineraryController@index');
Route::any('/tripitenaryupdate/{employee_id}', '\App\Http\Controllers\Femployee\TripItineraryController@tripitenaryupdate');

Route::any('/viewtimepunches/{employee_id}', '\App\Http\Controllers\Femployee\TripItineraryController@viewTimepunches');
Route::any('/trip_itinerary/getweeks', '\App\Http\Controllers\Femployee\TripItineraryController@getWeeks');
Route::any('/trip_itinerary/addtimepunch/{employee_id}', '\App\Http\Controllers\Femployee\TripItineraryController@addTimepunch');
Route::any('/trip_itinerary/printreport/{employee_id}', '\App\Http\Controllers\Femployee\TripItineraryController@printReport');

//Notifications
Route::get('/notifications', '\App\Http\Controllers\Femployee\NotificationController@index')->name('notifications');


