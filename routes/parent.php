<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('parent')->user();

    //dd($users);

    return view('parent.home');
})->name('home');*/

Route::get('/dashboard', '\App\Http\Controllers\Parent\DashboardController@index')->name('home');

//Profile
Route::get('/edit_profile', '\App\Http\Controllers\Parent\ClientController@editProfile');
Route::post('/store_profile', '\App\Http\Controllers\Parent\ClientController@storeProfile');

//Client
Route::any('/client/edit/{client_id}', '\App\Http\Controllers\Parent\ClientController@edit');
Route::get('/client/view', '\App\Http\Controllers\Parent\ClientController@index')->name('view');
Route::post('/client/emailexist/', '\App\Http\Controllers\Parent\ClientController@clientEmailExist');
Route::any('/client/viewarchives', '\App\Http\Controllers\Parent\ClientController@viewArchives');
Route::get('/client/viewagreement', '\App\Http\Controllers\Parent\ClientController@viewAgreement');
Route::get('/client/editagreement/{client_id}', '\App\Http\Controllers\Parent\ClientController@editAgreement');
Route::post('/client/updateagreement/{client_id}', '\App\Http\Controllers\Parent\ClientController@updateAgreement');
Route::any('/client/addinsurance', '\App\Http\Controllers\Parent\ClientController@addInsurance');
Route::post('/client/storeinsurance', '\App\Http\Controllers\Parent\ClientController@storeInsurance');
Route::any('/client/setinsurance/{id}', '\App\Http\Controllers\Parent\ClientController@setInsurance');
Route::any('/client/viewinsurance/{id?}', '\App\Http\Controllers\Parent\ClientController@viewInsurance');
Route::any('/client/editinsurance/{type}/{id}/{pid?}', '\App\Http\Controllers\Parent\ClientController@editInsurance');
Route::any('/client/viewinsurance/addauthorization/{pid}', '\App\Http\Controllers\Parent\ClientController@addAuthorization');
Route::any('/client/viewinsurance/storeauthorization/{pid}', '\App\Http\Controllers\Parent\ClientController@storeAuthorization');
Route::any('/client/viewinsurance/editauthorization/{aid}', '\App\Http\Controllers\Parent\ClientController@editAuthorization');
Route::any('/client/viewinsurance/archiveauthorization/{aid}', '\App\Http\Controllers\Parent\ClientController@archiveAuthorization');
Route::any('/client/viewinsurance/unarchiveauthorization/{aid}', '\App\Http\Controllers\Parent\ClientController@unarchiveAuthorization');
Route::any('/client/viewinsurance/trashauthorization/{aid}', '\App\Http\Controllers\Parent\ClientController@trashAuthorization');
Route::get('/client/uploadreport/{id}', '\App\Http\Controllers\Parent\ClientController@uploadreport');
Route::post('/client/storereport/{id}', '\App\Http\Controllers\Parent\ClientController@storereport');
Route::any('/client/viewmedicalinformation', '\App\Http\Controllers\Parent\ClientController@viewMedicalInformation');
Route::any('/client/editmedicalinformation/{id}', '\App\Http\Controllers\Parent\ClientController@editMedicalInformation');
Route::any('/client/uploadmedicaldocuments/{file}/{name}/{id}', '\App\Http\Controllers\Parent\ClientController@medicalInformationDocumentsUpload');
Route::any('/client/deletemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Parent\ClientController@medicalInformationDocumentsDelete');
Route::any('/client/archivemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Parent\ClientController@medicalInformationDocumentsArchive');
Route::any('/client/downloadmedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Parent\ClientController@medicalInformationDocumentsDownload');
Route::any('/client/activemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Parent\ClientController@medicalInformationDocumentsActive');

//Client Session Logs
Route::any('/client/sessionslogs/', '\App\Http\Controllers\Parent\ClientController@SessionsLogs');

//Client task list
Route::any('/client/viewtasklist', '\App\Http\Controllers\Parent\ClientController@viewTasklist');
Route::any('/client/addtasklist/{id}', '\App\Http\Controllers\Parent\ClientController@addtasklist');
Route::any('/client/edittasklist/{id}', '\App\Http\Controllers\Parent\ClientController@edittasklist');
Route::any('/client/addtimepunch/{client_id}', '\App\Http\Controllers\Parent\ClientController@addTimepunch');
Route::any('/client/deletetask/{client_id}/{task_id}', '\App\Http\Controllers\Parent\ClientController@deletetask');

//Insurance
//Route::get('/insurance', '\App\Http\Controllers\Parent\InsuranceController@index')->name('insurance');
Route::any('/insurance', '\App\Http\Controllers\Parent\ClientController@viewInsurance')->name('insurance');
Route::any('/insurance/edit/{type}/{id}', '\App\Http\Controllers\Parent\ClientController@editInsurance')->name('editinsurance');

//Cargo Hold
Route::get('/cargohold', '\App\Http\Controllers\Parent\CargoholdController@index')->name('cargohold');
Route::get('/cargohold/uploaddocument', '\App\Http\Controllers\Parent\CargoholdController@uploadDocument');
Route::post('/cargohold/add-document', '\App\Http\Controllers\Parent\CargoholdController@addDocument');
Route::post('/cargohold/edit-document/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@editDocument');
Route::get('/cargohold/edit', '\App\Http\Controllers\Parent\CargoholdController@uploadDocument');
Route::get('/cargohold/viewpdf/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@cargoHoldView');
Route::get('/cargohold/downloadpdf/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@cargoHoldDownload');
Route::get('/cargohold/deletecargohold/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@deleteCargoHold');
Route::get('/cargohold/archivecargohold/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@archiveCargoHold');
Route::get('/cargohold/activecargohold/{cargo_id}', '\App\Http\Controllers\Parent\CargoholdController@activeCargoHold');

//Message
Route::get('/messages', '\App\Http\Controllers\Parent\MessageController@index')->name('messages');
Route::get('/messages/{name?}/{id?}', '\App\Http\Controllers\Parent\MessageController@index')->name('messages');
Route::get('/message_status/{name?}/{id?}', '\App\Http\Controllers\Parent\MessageController@message_status')->name('message_status');
Route::post('/send_message', '\App\Http\Controllers\Parent\MessageController@send_message')->name('send_message');

//Trip Itinerary
Route::get('/trip_itinerary', '\App\Http\Controllers\Parent\TripItineraryController@index')->name('trip_itinerary');
Route::get('/trip_itinerary/edit', '\App\Http\Controllers\Parent\TripItineraryController@edit');
Route::post('/trip_itinerary/update', '\App\Http\Controllers\Parent\TripItineraryController@update');
Route::post('/trip_itinerary/add/', '\App\Http\Controllers\Parent\TripItineraryController@add');
Route::any('/viewtripitinerary/{employee_id}', '\App\Http\Controllers\Parent\TripItineraryController@index');
Route::any('/tripitenaryupdate/{employee_id}', '\App\Http\Controllers\Parent\TripItineraryController@tripitenaryupdate');

Route::any('/viewtimepunches/{employee_id}', '\App\Http\Controllers\Parent\TripItineraryController@viewTimepunches');
Route::any('/trip_itinerary/getweeks', '\App\Http\Controllers\Parent\TripItineraryController@getWeeks');
Route::any('/trip_itinerary/addtimepunch/{employee_id}', '\App\Http\Controllers\Parent\TripItineraryController@addTimepunch');
Route::any('/trip_itinerary/printreport/{employee_id}', '\App\Http\Controllers\Parent\TripItineraryController@printReport');

//Notifications
Route::get('/notifications', '\App\Http\Controllers\Parent\NotificationController@index')->name('notifications');

