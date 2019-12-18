<?php

//--------ADMIN - START---------//

//user
Route::get('/admin/user/user', 'AdminController@user')->name('User');
Route::get('/admin/user/adduser', 'AdminController@adduser')->name('Add User');
Route::post('/saveuser','AdminController@saveuser');
Route::get('/delete_user/{id}','AdminController@delete_user');
Route::get('/edit_user/{id}','AdminController@edit_user')->name('Edit User');
Route::post('/update_user/{id}','AdminController@update_user');

//user-role
Route::get('/admin/user_role/userrole', 'AdminController@userrole')->name('User Role');
Route::get('/admin/user_role/adduserrole', 'AdminController@addrole')->name('Add User Role');
Route::post('/saverole','AdminController@saverole');
Route::get('/delete_user_role/{id}','AdminController@delete_user_role');
Route::get('/edit_user_role/{id}','AdminController@edit_user_role')->name('Edit User Role');
Route::post('/update_user_role/{id}','AdminController@update_user_role');

//role-wise-permission
// Route::get('/admin/role_wise_permission/rolewisepermission', 'AdminController@role_wise_permission')->name('Role Wise Permission');
Route::get('/admin/role_wise_permission/role_wise_permission', ['uses'=>'RoleController@manageRole'])->name('Role Wise Permission');
// Route::get('role-tree-view',['uses'=>'RoleController@manageRole']);
Route::post('add-role',['as'=>'add.role','uses'=>'RoleController@addRole']);

//change-password
Route::get('/admin/change_password/changepassword', 'AdminController@change_password')->name('Change Password');
Route::post('/save_password/{id}', 'AdminController@save_password');

//--------ADMIN - END---------//