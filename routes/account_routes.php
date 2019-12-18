<?php 

//ACCOUNT
Route::get('/account/ledger_account/ledger_accounts', 'AccountController@ledger_account');
Route::get('/account/voucher/vouchers', 'AccountController@voucher');
Route::get('/account/voucher/debit_voucher_manual', 'AccountController@debit_manual');
Route::get('/account/voucher/credit_voucher_manual', 'AccountController@credit_manual');

//Reyajul
Route::get('/accounts', 'AccountsController@accounts');


// Route::get('/restaurant/menu_type/add_menu_type', 'RestaurantController@add_menu_type')->name('Add Menu Type');
// Route::post('/save_menu_type','RestaurantController@save_menu_type');
// Route::get('/edit_menu_type/{id}','RestaurantController@edit_menu_type')->name('Edit Menu Type');
// Route::post('/update_menu_type/{id}','RestaurantController@update_menu_type');
// Route::get('/delete_menu_type/{id}','RestaurantController@delete_menu_type');