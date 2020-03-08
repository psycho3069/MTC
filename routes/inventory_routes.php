<?php 

//------INVENTORY START-------//

//INVENTORY-SUPPLIER
Route::get('/inventory/inventory_supplier/inventory_suppliers', 'InventoryController@inventory_supplier')->name('Suppliers');
Route::get('/inventory/inventory_supplier/add_inventory_supplier', 'InventoryController@add_inventory_supplier')->name('Add Supplier');
Route::post('/save_inventory_supplier','InventoryController@save_inventory_supplier');
Route::get('/edit_inventory_supplier/{id}','InventoryController@edit_inventory_supplier')->name('Edit Supplier');
Route::post('/update_inventory_supplier/{id}','InventoryController@update_inventory_supplier');
Route::get('/delete_inventory_supplier/{id}','InventoryController@delete_inventory_supplier');


//INVENTORY-RECEIVER
Route::get('/inventory/inventory_receiver/inventory_receivers', 'InventoryController@inventory_receiver')->name('Receivers');
Route::get('/inventory/inventory_receiver/add_inventory_receiver', 'InventoryController@add_inventory_receiver')->name('Add Receiver');
Route::post('/save_inventory_receiver','InventoryController@save_inventory_receiver');
Route::get('/edit_inventory_receiver/{id}','InventoryController@edit_inventory_receiver')->name('Edit Receiver');
Route::post('/update_inventory_receiver/{id}','InventoryController@update_inventory_receiver');
Route::get('/delete_inventory_receiver/{id}','InventoryController@delete_inventory_receiver');


//INVENTORY-CATEGORY
Route::get('/inventory/inventory_category/inventory_categories', 'InventoryController@inventory_category')->name('Inventory Categories');
Route::get('/inventory/inventory_category/add_inventory_category', 'InventoryController@add_inventory_category')->name('Add Inventory Category');
Route::post('/save_inventory_category','InventoryController@save_inventory_category');
Route::get('/edit_inventory_category/{id}','InventoryController@edit_inventory_category')->name('Edit Inventory Category');
Route::post('/update_inventory_category/{id}','InventoryController@update_inventory_category');
Route::get('/delete_inventory_category/{id}','InventoryController@delete_inventory_category');


//INVENTORY-ITEM
Route::get('/inventory/inventory_item/inventory_items', 'InventoryController@inventory_item')->name('Inventories');
Route::get('/inventory/inventory_item/add_inventory_item', 'InventoryController@add_inventory_item')->name('Add Inventory');
Route::post('/save_inventory_item','InventoryController@save_inventory_item');
Route::get('/edit_inventory_item/{id}','InventoryController@edit_inventory_item')->name('Edit Inventory');
Route::post('/update_inventory_item/{id}','InventoryController@update_inventory_item');
Route::get('/delete_inventory_item/{id}','InventoryController@delete_inventory_item');


//------INVENTORY END-------//