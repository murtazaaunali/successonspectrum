<?php

Route::get('/dashboard', '\App\Http\Controllers\Franchise\DashboardController@index')->name('home');
Route::get('/logoutimpersonate', '\App\Http\Controllers\Franchise\DashboardController@LogoutImpersonate')->name('LogoutImpersonate');
//Staff routes
/*Route::get('/staff', '\App\Http\Controllers\Franchise\UserController@userListing')->name('staff');
Route::get('/adduser', '\App\Http\Controllers\Franchise\UserController@add');
Route::post('/store_user', '\App\Http\Controllers\Franchise\UserController@store_user')->name('store_user');
Route::get('/edit_user/{user_id}', '\App\Http\Controllers\Franchise\UserController@index');
Route::post('/store_profile/{user_id}', '\App\Http\Controllers\Franchise\UserController@store_profile');
Route::get('/userdelete/{user_id}', '\App\Http\Controllers\Franchise\UserController@userDelete');*/
Route::get('/staff', '\App\Http\Controllers\Franchise\UserController@index')->name('staff');
Route::get('/adduser', '\App\Http\Controllers\Franchise\UserController@add');
Route::post('/store_user', '\App\Http\Controllers\Franchise\UserController@store_user')->name('store_user');
Route::get('/edituser/{user_id}', '\App\Http\Controllers\Franchise\UserController@edit');
Route::post('/edit_user/{user_id}', '\App\Http\Controllers\Franchise\UserController@edit_user');
Route::get('/userdelete/{user_id}', '\App\Http\Controllers\Franchise\UserController@userDelete');
Route::get('/edit_profile', '\App\Http\Controllers\Franchise\UserController@edit_profile');
Route::post('/store_profile', '\App\Http\Controllers\Franchise\UserController@store_profile');

//Employees
Route::get('/employees', '\App\Http\Controllers\Franchise\EmployeesController@index')->name('employees');
Route::get('/addemployee', '\App\Http\Controllers\Franchise\EmployeesController@form');
Route::post('/employee/add', '\App\Http\Controllers\Franchise\EmployeesController@add');
Route::any('/employee/view/{id}', '\App\Http\Controllers\Franchise\EmployeesController@view');
Route::any('/employee/edit/{id}', '\App\Http\Controllers\Franchise\EmployeesController@edit');
Route::any('/employee/invite/{id}', '\App\Http\Controllers\Franchise\EmployeesController@inviteEmployee');
Route::any('/employee/editrelation/{employee_id}/{relation_id}', '\App\Http\Controllers\Franchise\EmployeesController@editRelation');
Route::any('/employee/addrelation/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@addRelation');
Route::any('/employee/editbenifits/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@editBenifits');
Route::any('/employee/addperformance/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@addperformance');
Route::any('/employee/performanceupdate/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@performanceupdate');
Route::any('/employee/performancedelete/{employee_id}/{performance_id}', '\App\Http\Controllers\Franchise\EmployeesController@performanceDelete');
Route::any('/employee/tripitenaryupdate/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@tripitenaryupdate');
Route::any('/employee/printreport/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@printReport');
Route::any('/employee/delete/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@deleteEmployee');
Route::any('/employee/getweeks', '\App\Http\Controllers\Franchise\EmployeesController@getWeeks');
Route::get('/employee/deletecontact/{employee_id}/{contact_id}', '\App\Http\Controllers\Franchise\EmployeesController@deletecontact');
Route::post('/employee/emailexist/', '\App\Http\Controllers\Franchise\EmployeesController@EmailExist');
Route::post('/employee/emailexistinvite/', '\App\Http\Controllers\Franchise\EmployeesController@EmailExistForInvite');
Route::any('/employee/addcertification/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@addCertification');
Route::any('/employee/editcertification/{employee_id}/{certification_id}', '\App\Http\Controllers\Franchise\EmployeesController@editCertification');
Route::any('/employee/deletecertification/{employee_id}/{certification_id}', '\App\Http\Controllers\Franchise\EmployeesController@deleteCertification');
Route::any('/employee/addcredential/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@addCredential');
Route::any('/employee/editcredential/{employee_id}/{credential_id}', '\App\Http\Controllers\Franchise\EmployeesController@editCredential');
Route::any('/employee/deletecredential/{employee_id}/{credential_id}', '\App\Http\Controllers\Franchise\EmployeesController@deleteCredential');

//Employee Tripitinerary
Route::any('/employee/viewtripitinerary/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@viewTripitinerary');

//Employee Timepunches
Route::any('/employee/viewtimepunches/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@viewTimepunches');

//Employee Performancelog
Route::any('/employee/viewperformancelog/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@viewPerformancelog');

//Employees Task
Route::any('/employee/addtasklist/{id}', '\App\Http\Controllers\Franchise\EmployeesController@addtasklist');
Route::any('/employee/edittasklist/{id}', '\App\Http\Controllers\Franchise\EmployeesController@edittasklist');
Route::any('/employee/viewtasklist/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@viewTasklist');
Route::any('/employee/deletetask/{employee_id}/{task_id}', '\App\Http\Controllers\Franchise\EmployeesController@deletetask');
Route::any('/employee/addtimepunch/{employee_id}', '\App\Http\Controllers\Franchise\EmployeesController@addTimepunch');

//Trip Itinerary
Route::get('/trip_itinerary', '\App\Http\Controllers\Franchise\TripItineraryController@index')->name('trip_itinerary');
Route::get('trip_itinerary/edit', '\App\Http\Controllers\Franchise\TripItineraryController@edit');
Route::post('trip_itinerary/update', '\App\Http\Controllers\Franchise\TripItineraryController@update');
Route::post('trip_itinerary/add/', '\App\Http\Controllers\Franchise\TripItineraryController@add');

//Cargo hold
Route::get('/cargohold', '\App\Http\Controllers\Franchise\CargoholdController@index')->name('cargohold');
Route::get('/cargohold/uploaddocument', '\App\Http\Controllers\Franchise\CargoholdController@uploadDocument');
Route::post('/cargohold/add-document', '\App\Http\Controllers\Franchise\CargoholdController@addDocument');
Route::post('/cargohold/edit-document/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@editDocument');
Route::get('/cargohold/edit', '\App\Http\Controllers\Franchise\CargoholdController@uploadDocument');
Route::get('/cargohold/viewpdf/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@cargoHoldView');
Route::get('/cargohold/downloadpdf/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@cargoHoldDownload');
Route::get('/cargohold/deletecargohold/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@deleteCargoHold');
Route::get('/cargohold/archivecargohold/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@archiveCargoHold');
Route::get('/cargohold/activecargohold/{cargo_id}', '\App\Http\Controllers\Franchise\CargoholdController@activeCargoHold');

//Catalog
Route::get('/catalog', '\App\Http\Controllers\Franchise\CatalogueController@index')->name('catalog');
Route::get('/catalog/viewproduct/{product_id}', '\App\Http\Controllers\Franchise\CatalogueController@viewProduct');
Route::get('/catalog/prothankyou', '\App\Http\Controllers\Franchise\CatalogueController@thankyou');

//cart 
Route::any('/addcart', '\App\Http\Controllers\Cart@index')->name('cart');
Route::get('/viewcart', '\App\Http\Controllers\Cart@viewCart');
Route::post('/updatecart', '\App\Http\Controllers\Cart@updateCart');
Route::post('/checkout', '\App\Http\Controllers\Cart@checkout');

//Messages
Route::get('/messages/{name?}/{id?}', '\App\Http\Controllers\Franchise\MessageController@index')->name('messages');
Route::get('/message_status/{name?}/{id?}', '\App\Http\Controllers\Franchise\MessageController@message_status')->name('message_status');
Route::post('/send_message', '\App\Http\Controllers\Franchise\MessageController@send_message')->name('send_message');

//Notifications
Route::get('/notifications', '\App\Http\Controllers\Franchise\NotificationController@index')->name('notification_list');
Route::get('/notifications/archive', '\App\Http\Controllers\Franchise\NotificationController@archiveNotifications')->name('archive_notifications');
Route::get('/notifications/process_archive/{id}', '\App\Http\Controllers\Franchise\NotificationController@MoveToArchive')->name('process_archive');
Route::get('/notifications/remove_archive/{id}', '\App\Http\Controllers\Franchise\NotificationController@MoveFromArchive')->name('remove_archive');
Route::get('/notifications/add', '\App\Http\Controllers\Franchise\NotificationController@addNotification')->name('add_notification');
Route::post('/notifications/store_add', '\App\Http\Controllers\Franchise\NotificationController@addStore')->name('store_add');
Route::get('/notifications/edit/{id}', '\App\Http\Controllers\Franchise\NotificationController@editNotification')->name('edit_notification');
Route::post('/notifications/store_edit', '\App\Http\Controllers\Franchise\NotificationController@editStore')->name('store_edit');
Route::post('/notifications/read', '\App\Http\Controllers\Franchise\NotificationController@readNotifications')->name('notification_read');

//Clints Main Deck Notifications
Route::get('/mainnotifications', '\App\Http\Controllers\Franchise\NotificationController@MainNotifications')->name('notification_list_main');

//Clients
Route::get('/clients', '\App\Http\Controllers\Franchise\ClientsController@index')->name('clients');
Route::any('/client/view/{id}', '\App\Http\Controllers\Franchise\ClientsController@view');
Route::any('/client/edit/{id}', '\App\Http\Controllers\Franchise\ClientsController@edit');
Route::any('/client/delete/{id}', '\App\Http\Controllers\Franchise\ClientsController@deleteClient');
Route::post('/client/emailexist/', '\App\Http\Controllers\Franchise\ClientsController@clientEmailExist');
Route::post('/client/invite/{id}', '\App\Http\Controllers\Franchise\ClientsController@inviteClient');
Route::any('/client/viewarchives/{id}', '\App\Http\Controllers\Franchise\ClientsController@viewArchives');
Route::get('/client/viewagreement/{id}', '\App\Http\Controllers\Franchise\ClientsController@viewAgreement');
Route::get('/client/editagreement/{client_id}', '\App\Http\Controllers\Franchise\ClientsController@editAgreement');
Route::post('/client/updateagreement/{client_id}', '\App\Http\Controllers\Franchise\ClientsController@updateAgreement');
Route::any('/client/addinsurance/{id}', '\App\Http\Controllers\Franchise\ClientsController@addInsurance');
Route::post('/client/storeinsurance/{id}', '\App\Http\Controllers\Franchise\ClientsController@storeInsurance');
Route::any('/client/setinsurance/{id}/{pid}', '\App\Http\Controllers\Franchise\ClientsController@setInsurance');
Route::any('/client/viewinsurance/{id}/{pid?}', '\App\Http\Controllers\Franchise\ClientsController@viewInsurance');
Route::any('/client/editinsurance/{type}/{id}/{pid?}', '\App\Http\Controllers\Franchise\ClientsController@editInsurance');
Route::any('/client/viewinsurance/addauthorization/{id}/{pid}', '\App\Http\Controllers\Franchise\ClientsController@addAuthorization');
Route::any('/client/viewinsurance/storeauthorization/{id}/{pid}', '\App\Http\Controllers\Franchise\ClientsController@storeAuthorization');
Route::any('/client/viewinsurance/editauthorization/{id}/{pid}/{aid}', '\App\Http\Controllers\Franchise\ClientsController@editAuthorization');
Route::any('/client/viewinsurance/archiveauthorization/{id}/{pid}/{aid}', '\App\Http\Controllers\Franchise\ClientsController@archiveAuthorization');
Route::any('/client/viewinsurance/unarchiveauthorization/{id}/{pid}/{aid}', '\App\Http\Controllers\Franchise\ClientsController@unarchiveAuthorization');
Route::any('/client/viewinsurance/trashauthorization/{id}/{pid}/{aid}', '\App\Http\Controllers\Franchise\ClientsController@trashAuthorization');
Route::any('/client/viewinsurance/uploadinsuranceidcard/{id}/{pid}', '\App\Http\Controllers\Franchise\ClientsController@uploadInsuranceIDCard');
Route::any('/client/viewinsurance/deleteinsuranceidcard/{id}/{pid}/{cid}', '\App\Http\Controllers\Franchise\ClientsController@deleteInsuranceIDCard');
Route::any('/client/viewinsurance/downloadinsuranceidcard/{id}/{pid}/{cid}', '\App\Http\Controllers\Franchise\ClientsController@downloadInsuranceIDCard');
//Route::any('/client/downloadidcard/{client_id}', '\App\Http\Controllers\Franchise\ClientsController@downloadidcard');
Route::get('/client/uploadreport/{id}', '\App\Http\Controllers\Franchise\ClientsController@uploadreport');
Route::post('/client/storereport/{id}', '\App\Http\Controllers\Franchise\ClientsController@storereport');
Route::any('/client/viewmedicalinformation/{id}', '\App\Http\Controllers\Franchise\ClientsController@viewMedicalInformation');
Route::any('/client/editmedicalinformation/{id}', '\App\Http\Controllers\Franchise\ClientsController@editMedicalInformation');
Route::any('/client/viewmedicalinformation/addabahistory/{id}', '\App\Http\Controllers\Franchise\ClientsController@addABAHistory');
Route::any('/client/viewmedicalinformation/editabahistory/{id}', '\App\Http\Controllers\Franchise\ClientsController@editABAHistory');
Route::any('/client/viewmedicalinformation/storeabahistory/{id}', '\App\Http\Controllers\Franchise\ClientsController@storeABAHistory');
Route::any('/client/viewmedicalinformation/deleteabahistory/{id}', '\App\Http\Controllers\Franchise\ClientsController@deleteABAHistory');
Route::any('/client/uploadmedicaldocuments/{file}/{name}/{id}', '\App\Http\Controllers\Franchise\ClientsController@medicalInformationDocumentsUpload');
Route::any('/client/deletemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Franchise\ClientsController@medicalInformationDocumentsDelete');
Route::any('/client/archivemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Franchise\ClientsController@medicalInformationDocumentsArchive');
Route::any('/client/downloadmedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Franchise\ClientsController@medicalInformationDocumentsDownload');
Route::any('/client/activemedicaldocuments/{client_id}/{doc_id}', '\App\Http\Controllers\Franchise\ClientsController@medicalInformationDocumentsActive');

//Client task list
Route::any('/client/addtasklist/{id}', '\App\Http\Controllers\Franchise\ClientsController@addtasklist');
Route::any('/client/edittasklist/{id}', '\App\Http\Controllers\Franchise\ClientsController@edittasklist');
Route::any('/client/viewtasklist/{client_id}', '\App\Http\Controllers\Franchise\ClientsController@viewTasklist');
Route::any('/client/deletetask/{client_id}/{task_id}', '\App\Http\Controllers\Franchise\ClientsController@deletetask');
Route::any('/client/addtimepunch/{client_id}', '\App\Http\Controllers\Franchise\ClientsController@addTimepunch');

//Client schedule
Route::any('/client/viewtripitinerary/{id}', '\App\Http\Controllers\Franchise\ClientsController@viewTripitinerary');
Route::any('/client/tripitenaryupdate/{id}', '\App\Http\Controllers\Franchise\ClientsController@tripitenaryupdate');
