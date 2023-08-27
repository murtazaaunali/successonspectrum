<?php
//Dashboard
Route::get('/dashboard', '\App\Http\Controllers\Admin\DashboardController@index')->name('home');
Route::get('/testemail', '\App\Http\Controllers\Admin\DashboardController@testemail');
Route::get('/add_user', '\App\Http\Controllers\Admin\UserController@add')->name('add_user');
Route::post('/store_user', '\App\Http\Controllers\Admin\UserController@store_user')->name('store_user');
Route::get('/edit_profile', '\App\Http\Controllers\Admin\UserController@index')->name('edit_profile');
Route::post('/edit_store_profile', '\App\Http\Controllers\Admin\UserController@store_profile')->name('store_profile');

//Franchises
Route::any('/franchises', '\App\Http\Controllers\Admin\FranchiseController@index')->name('franchises');
Route::get('/addfranchise', '\App\Http\Controllers\Admin\FranchiseController@form');
Route::post('/franchise/add', '\App\Http\Controllers\Admin\FranchiseController@add');
//Route::any('/franchise/view/{id}', '\App\Http\Controllers\Admin\FranchiseController@view');
Route::any('/franchise/edit/{id}', '\App\Http\Controllers\Admin\FranchiseController@edit');
Route::any('/franchise/view/{id}', '\App\Http\Controllers\Admin\FranchiseController@view');
Route::any('/franchise/delete/{id}', '\App\Http\Controllers\Admin\FranchiseController@delete');
Route::post('/franchise/invite/{franchise_id}/{employee_id}', '\App\Http\Controllers\Admin\FranchiseController@inviteEmployee');
Route::post('/franchise/emailexist/', '\App\Http\Controllers\Admin\FranchiseController@EmailExist');
Route::post('/franchise/emailexisteditfranchise/', '\App\Http\Controllers\Admin\FranchiseController@EmailExistForFranchise');
Route::post('/franchise/ownerexist/', '\App\Http\Controllers\Admin\FranchiseController@OwnerEmailExist');
Route::post('/franchise/updateinsurance/', '\App\Http\Controllers\Admin\FranchiseController@updateRequiredInsurance');
Route::post('/franchise/updateadvertisement/', '\App\Http\Controllers\Admin\FranchiseController@updateLocalAdvertisement');
Route::post('/franchise/updateaudit/', '\App\Http\Controllers\Admin\FranchiseController@updateAudit');
Route::post('/franchise/uploadlocaladvertisementsdocument/', '\App\Http\Controllers\Admin\FranchiseController@uploadLocalAdvertisementsDocument');

//Franchise payment
Route::any('/franchise/editpayment/{id}', '\App\Http\Controllers\Admin\FranchiseController@editpayment');
Route::any('/franchise/viewpayment/{id}', '\App\Http\Controllers\Admin\FranchiseController@viewPayment');
Route::post('/franchise/updaterecievedon/{id}', '\App\Http\Controllers\Admin\FranchiseController@updateRecievedOn');
Route::post('/franchise/updatepaymentfields/{id}', '\App\Http\Controllers\Admin\FranchiseController@updatePaymentFields');
Route::post('/franchise/updatepaymentdetails/{id}', '\App\Http\Controllers\Admin\FranchiseController@updatePaymentDetails');
Route::post('/franchise/updatepayments/{id}', '\App\Http\Controllers\Admin\FranchiseController@UpdatePayments');
Route::post('/franchise/paymentprintreport/{franchise_id}', '\App\Http\Controllers\Admin\FranchiseController@PaymentPrintReport');

//Franchise task 
Route::any('/franchise/addtasklist/{id}', '\App\Http\Controllers\Admin\FranchiseController@addtasklist');
Route::any('/franchise/viewtasklist/{id}', '\App\Http\Controllers\Admin\FranchiseController@viewTasklist');
Route::any('/franchise/edittasklist/{id}', '\App\Http\Controllers\Admin\FranchiseController@edittasklist');
Route::get('/franchise/deletetask/{franchise_id}/{task_id}', '\App\Http\Controllers\Admin\FranchiseController@deletetask');


//Franchise add Owner routes
Route::any('/franchise/addowner/{id}', '\App\Http\Controllers\Admin\FranchiseController@addowner');
Route::any('/franchise/editowner/{franchise_id}/{owner_id}', '\App\Http\Controllers\Admin\FranchiseController@editowner');
Route::get('/franchise/deleteowner/{franchise_id}/{owner_id}', '\App\Http\Controllers\Admin\FranchiseController@deleteowner');


//Franchise edit Fees routes
Route::any('/franchise/editfee/{franchise_id}', '\App\Http\Controllers\Admin\FranchiseController@editfee');

//Employees
Route::get('/employees', '\App\Http\Controllers\Admin\EmployeesController@index')->name('employees');
Route::get('/addemployee', '\App\Http\Controllers\Admin\EmployeesController@form');
Route::post('/employee/add', '\App\Http\Controllers\Admin\EmployeesController@add');
Route::any('/employee/view/{id}', '\App\Http\Controllers\Admin\EmployeesController@view');
Route::any('/employee/edit/{id}', '\App\Http\Controllers\Admin\EmployeesController@edit');
Route::any('/employee/invite/{id}', '\App\Http\Controllers\Admin\EmployeesController@inviteEmployee');
Route::any('/employee/editrelation/{employee_id}/{relation_id}', '\App\Http\Controllers\Admin\EmployeesController@editRelation');
Route::any('/employee/addrelation/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@addRelation');
Route::any('/employee/editbenifits/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@editBenifits');
Route::any('/employee/addperformance/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@addperformance');
Route::any('/employee/performanceupdate/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@performanceupdate');
Route::any('/employee/performancedelete/{employee_id}/{performance_id}', '\App\Http\Controllers\Admin\EmployeesController@performanceDelete');
Route::any('/employee/tripitenaryupdate/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@tripitenaryupdate');
Route::any('/employee/printreport/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@printReport');
Route::any('/employee/delete/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@deleteEmployee');
Route::any('/employee/getweeks', '\App\Http\Controllers\Admin\EmployeesController@getWeeks');
Route::get('/employee/deletecontact/{employee_id}/{contact_id}', '\App\Http\Controllers\Admin\EmployeesController@deletecontact');
Route::post('/employee/emailexist/', '\App\Http\Controllers\Admin\EmployeesController@EmailExist');
Route::post('/employee/updatereview', '\App\Http\Controllers\Admin\EmployeesController@updatereview');

//Employees Payroll
Route::any('/employees/payroll', '\App\Http\Controllers\Admin\PayrollController@index')->name('payroll');
Route::any('/employees/payroll/print/{id}', '\App\Http\Controllers\Admin\PayrollController@printEmployeePayroll')->name('payroll_print');

//Employee Tripitinerary
Route::any('/employee/viewtripitinerary/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@viewTripitinerary');

//Employee Timepunches
Route::any('/employee/viewtimepunches/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@viewTimepunches');

//Employee Performancelog
Route::any('/employee/viewperformancelog/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@viewPerformancelog');

//Employees Task
Route::any('/employee/addtasklist/{id}', '\App\Http\Controllers\Admin\EmployeesController@addtasklist');
Route::any('/employee/edittasklist/{id}', '\App\Http\Controllers\Admin\EmployeesController@edittasklist');
Route::any('/employee/viewtasklist/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@viewTasklist');
//Route::get('/employee/statustasklist/{id}', '\App\Http\Controllers\Admin\EmployeesController@statustasklist');
Route::any('/employee/deletetask/{employee_id}/{task_id}', '\App\Http\Controllers\Admin\EmployeesController@deletetask');
Route::any('/employee/addtimepunch/{employee_id}', '\App\Http\Controllers\Admin\EmployeesController@addTimepunch');
Route::any('/employee/changetimepunchstatus/{employee_id}/{timepunch_id}', '\App\Http\Controllers\Admin\EmployeesController@changeTimepunchStatus');

//Cargo hold
Route::get('/cargohold', '\App\Http\Controllers\Admin\CargoholdController@index')->name('cargohold');
Route::get('/cargohold/uploaddocument', '\App\Http\Controllers\Admin\CargoholdController@uploadDocument');
Route::post('/cargohold/add-document', '\App\Http\Controllers\Admin\CargoholdController@addDocument');
Route::post('/cargohold/edit-document/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@editDocument');
Route::get('/cargohold/edit', '\App\Http\Controllers\Admin\CargoholdController@uploadDocument');
Route::post('/cargohold/moveto', '\App\Http\Controllers\Admin\CargoholdController@moveToCargoHold');
Route::get('/cargohold/viewpdf/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@cargoHoldView');
Route::get('/cargohold/downloadpdf/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@cargoHoldDownload');
Route::get('/cargohold/deletecargohold/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@deleteCargoHold');
Route::get('/cargohold/archivecargohold/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@archiveCargoHold');
Route::get('/cargohold/activecargohold/{cargo_id}', '\App\Http\Controllers\Admin\CargoholdController@activeCargoHold');
Route::post('/cargohold/createfolder', '\App\Http\Controllers\Admin\CargoholdController@createCargoHoldFolder');
Route::get('/cargohold/removefolder/{folder_id}', '\App\Http\Controllers\Admin\CargoholdController@removeCargoHoldFolder');

//Catalogue
Route::get('/catalogue', '\App\Http\Controllers\Admin\CatalogueController@index')->name('catalogue');
Route::get('/catalogue/addproduct', '\App\Http\Controllers\Admin\CatalogueController@productForm');
Route::get('/catalogue/editproduct/{product_id}', '\App\Http\Controllers\Admin\CatalogueController@productEditForm');
Route::post('/catalogue/saveproduct', '\App\Http\Controllers\Admin\CatalogueController@saveProduct');
Route::post('/catalogue/updateproduct', '\App\Http\Controllers\Admin\CatalogueController@updateProduct');
Route::post('/catalogue/storegallery', '\App\Http\Controllers\Admin\CatalogueController@storeGallery');
Route::post('/catalogue/storeimage', '\App\Http\Controllers\Admin\CatalogueController@storeImage');
Route::post('/catalogue/deleteimage', '\App\Http\Controllers\Admin\CatalogueController@deleteImage');
Route::get('/catalogue/orders', '\App\Http\Controllers\Admin\CatalogueController@getOrders')->name('orders_list');
Route::get('/catalogue/orders/view_order/{id}', '\App\Http\Controllers\Admin\CatalogueController@viewOrder')->name('view_order');
Route::get('/catalogue/orders/edit_order/{id}', '\App\Http\Controllers\Admin\CatalogueController@edit_order')->name('edit_order');
Route::post('/catalogue/orders/order_save', '\App\Http\Controllers\Admin\CatalogueController@order_save')->name('order_save');
Route::get('/catalogue/viewproduct/{product_id}', '\App\Http\Controllers\Admin\CatalogueController@viewProduct');
Route::get('/catalogue/deleteproduct/{product_id}', '\App\Http\Controllers\Admin\CatalogueController@deleteProduct');

//Messages
Route::get('/messages/{name?}/{id?}/{message_id?}', '\App\Http\Controllers\Admin\MessageController@index')->name('messages');
Route::get('/message_status/{name?}/{id?}', '\App\Http\Controllers\Admin\MessageController@message_status')->name('message_status');
Route::post('/send_message', '\App\Http\Controllers\Admin\MessageController@send_message')->name('send_message');

//Trip Itinerary
Route::get('/trip_itinerary', '\App\Http\Controllers\Admin\TripItineraryController@index')->name('trip_itinerary');
Route::get('trip_itinerary/view/{id}', '\App\Http\Controllers\Admin\TripItineraryController@view')->name('trip_itinerary_franchise');
Route::get('trip_itinerary/edit', '\App\Http\Controllers\Admin\TripItineraryController@edit');
Route::post('trip_itinerary/update', '\App\Http\Controllers\Admin\TripItineraryController@update');
Route::post('trip_itinerary/add/', '\App\Http\Controllers\Admin\TripItineraryController@add');

//Notifications
Route::get('/notifications', '\App\Http\Controllers\Admin\NotificationController@index')->name('notification_list');
Route::get('/notifications/archive', '\App\Http\Controllers\Admin\NotificationController@archiveNotifications')->name('archive_notifications');
Route::get('/notifications/process_archive/{id}', '\App\Http\Controllers\Admin\NotificationController@MoveToArchive')->name('process_archive');
Route::get('/notifications/remove_archive/{id}', '\App\Http\Controllers\Admin\NotificationController@MoveFromArchive')->name('remove_archive');
Route::get('/notifications/add', '\App\Http\Controllers\Admin\NotificationController@addNotification')->name('add_notification');
Route::post('/notifications/store_add', '\App\Http\Controllers\Admin\NotificationController@addStore')->name('store_add');
Route::get('/notifications/edit/{id}', '\App\Http\Controllers\Admin\NotificationController@editNotification')->name('edit_notification');
Route::post('/notifications/store_edit', '\App\Http\Controllers\Admin\NotificationController@editStore')->name('store_edit');
Route::post('/notifications/read', '\App\Http\Controllers\Admin\NotificationController@readNotifications')->name('notification_read');

//Settings
Route::get('/settings', '\App\Http\Controllers\Admin\SettingsController@index')->name('settings');
Route::any('/settings/edit', '\App\Http\Controllers\Admin\SettingsController@edit')->name('settings_edit');

//Logout
Route::post('logout', '\App\Http\Controllers\AdminAuth\LoginController@logout')->name('logout');

//Login as Franchise route
Route::get('/impersonate/{franchise_id}', '\App\Http\Controllers\Admin\FranchiseController@impersonate');