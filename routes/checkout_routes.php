<?php


//Reyajul

Route::get('/guest-list', 'CheckoutController@guestList');
Route::get('/checkout/{id}', 'CheckoutController@checkout');
Route::get('/checkout-room/{id}', 'CheckoutController@checkoutRoom');
Route::get('/checkout-venue/{id}', 'CheckoutController@checkoutVenue');
Route::get('/live_search/action', 'CheckoutController@action')->name('live_search.action');
Route::get('/live_search/actionVenue', 'CheckoutController@actionVenue')->name('live_search.actionVenue');

Route::get('entry-register-list/',['as' => 'checkoutList', 'uses' => 'CheckoutController@checkoutList']);
Route::get('bill-details/{id}',['as' => 'bill_datails', 'uses' => 'CheckoutController@billDetails']);
Route::get('checkouts/',['as' => 'checkout', 'uses' => 'CheckoutController@viewBill']);
Route::post('/checkout-store/',['as' => 'store_checkout', 'uses' => 'CheckoutController@storeChceckout']);

Route::get('generate-pdf/{id}','CheckoutController@generatePDF');