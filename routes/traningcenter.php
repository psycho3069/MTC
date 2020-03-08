<?php
//venue
Route::get('/training/venue', 'HomeController@venue')->name('venue');
Route::get('/training/addvenue', 'HomeController@addvenue')->name('addvenue');
Route::post('/savevenue','HomeController@savevenue');
Route::get('/delete_venue/{id}','HomeController@delete_venue');
Route::get('/edit_venue/{id}','HomeController@edit_venue')->name('edit_venue');
Route::post('/update_venue/{id}','HomeController@update_venue');
//venue reservation
Route::get('/training/venueRes', 'HomeController@venueRes')->name('venueRes');

Route::get('dynamic_dependent/fetch', 'HomeController@fetch')->name('dynamicdependent.fetch');

Route::get('/delete_venueres/{id}','HomeController@delete_venueres');
Route::get('/edit_venueres/{id}','HomeController@edit_venueres')->name('edit_venueres');
Route::post('/update_venueres/{id}','HomeController@update_venueres');
Route::get('/view_venueres/{id}','HomeController@view_venueres')->name('view_venueres');
 Route::get('pdf/{id}', 'HomeController@pdf');
//venue allocation
Route::get('/training/venueAlloc', 'HomeController@venueAlloc')->name('venueAlloc');

Route::get('/training/venue-booking-list', 'HomeController@venueBookingList');

Route::get('/edit_venue_book/{id}', 'HomeController@edit_venueBook');
Route::post('/update_venue_book/{id}', 'HomeController@updateVenueBook');
Route::get('/delete_venue_book/{id}', 'HomeController@delete_venueBooking');

Route::get('/training/makebook/{id}', 'HomeController@make_venueBook');
Route::get('/training/venue-billing-list/', 'HomeController@venuebillingList');
Route::get('/training/makebilling/{id}', 'HomeController@makebilling');
Route::post('/training/storemakebilling/', 'HomeController@storeBilling');
Route::get('/training/deletebilling/{id}', 'HomeController@delete_venueBilling');

//Route::get('venue_details/{id}/view', 'HomeController@viewVenues');