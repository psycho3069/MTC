<?php 

//------RESTAURANT START-------//

//SUPPLIER
Route::get('/restaurant/supplier/suppliers', 'RestaurantController@supplier')->name('Suppliers');
Route::get('/restaurant/supplier/add_supplier', 'RestaurantController@add_supplier')->name('Add Supplier');
Route::post('/save_supplier','RestaurantController@save_supplier');
Route::get('/edit_supplier/{id}','RestaurantController@edit_supplier')->name('Edit Supplier');
Route::post('/update_supplier/{id}','RestaurantController@update_supplier');
Route::get('/delete_supplier/{id}','RestaurantController@delete_supplier');


//RECEIVER
Route::get('/restaurant/receiver/receivers', 'RestaurantController@receiver')->name('Receivers');
Route::get('/restaurant/receiver/add_receiver', 'RestaurantController@add_receiver')->name('Add Receiver');
Route::post('/save_receiver','RestaurantController@save_receiver');
Route::get('/edit_receiver/{id}','RestaurantController@edit_receiver')->name('Edit Receiver');
Route::post('/update_receiver/{id}','RestaurantController@update_receiver');
Route::get('/delete_receiver/{id}','RestaurantController@delete_receiver');


//GROCERY-CATEGORY
Route::get('/restaurant/grocery_category/grocery_categories', 'RestaurantController@grocery_category')->name('Grocery Categories');
Route::get('/restaurant/grocery_category/add_grocery_category', 'RestaurantController@add_grocery_category')->name('Add Grocery Category');
Route::post('/save_grocery_category','RestaurantController@save_grocery_category');
Route::get('/edit_grocery_category/{id}','RestaurantController@edit_grocery_category')->name('Edit Grocery Category');
Route::post('/update_grocery_category/{id}','RestaurantController@update_grocery_category');
Route::get('/delete_grocery_category/{id}','RestaurantController@delete_grocery_category');


//GROCERY
Route::get('/restaurant/grocery/groceries', 'RestaurantController@grocery')->name('Groceries');
Route::get('/restaurant/grocery/add_grocery', 'RestaurantController@add_grocery')->name('Add Grocery');
Route::post('/save_grocery','RestaurantController@save_grocery');
Route::get('/edit_grocery/{id}','RestaurantController@edit_grocery')->name('Edit Grocery');
Route::post('/update_grocery/{id}','RestaurantController@update_grocery');
Route::get('/delete_grocery/{id}','RestaurantController@delete_grocery');


//MEAL-ITEM
Route::get('/restaurant/meal_item/meal_items', 'RestaurantController@meal_item')->name('Meal Items');
Route::get('/restaurant/meal_item/add_meal_item', 'RestaurantController@add_meal_item')->name('Add Meal Iten');
Route::post('/save_meal_item','RestaurantController@save_meal_item');
Route::get('/edit_meal_item/{id}','RestaurantController@edit_meal_item')->name('Edit Meal Item');
Route::post('/update_meal_item/{id}','RestaurantController@update_meal_item');
Route::get('/delete_meal_item/{id}','RestaurantController@delete_meal_item');


//MEAL-ITEM-TYPE
Route::get('/restaurant/meal_item_type/meal_item_types', 'RestaurantController@meal_item_type')->name('Meal Types');
Route::get('/restaurant/meal_item_type/add_meal_item_type', 'RestaurantController@add_meal_item_type')->name('Add Meal Type');
Route::post('/save_meal_item_type','RestaurantController@save_meal_item_type');
Route::get('/edit_meal_item_type/{id}','RestaurantController@edit_meal_item_type')->name('Edit Meal Type');
Route::post('/update_meal_item_type/{id}','RestaurantController@update_meal_item_type');
Route::get('/delete_meal_item_type/{id}','RestaurantController@delete_meal_item_type');


//MENU
Route::get('/restaurant/menu/menus', 'RestaurantController@menu')->name('Menus');
Route::get('/restaurant/menu/add_menu', 'RestaurantController@add_menu')->name('Add Menu');
Route::post('/save_menu','RestaurantController@save_menu');
Route::get('/edit_menu/{id}','RestaurantController@edit_menu')->name('Edit Menu');
Route::post('/update_menu/{id}','RestaurantController@update_menu');
Route::get('/delete_menu/{id}','RestaurantController@delete_menu');


Route::get('dynamic_dependent/fetch', 'RestaurantController@fetch')->name('dynamicdependent.fetch');

//MENU-TYPE
Route::get('/restaurant/menu_type/menu_types', 'RestaurantController@menu_type')->name('Menu Types');
Route::get('/restaurant/menu_type/add_menu_type', 'RestaurantController@add_menu_type')->name('Add Menu Type');
Route::post('/save_menu_type','RestaurantController@save_menu_type');
Route::get('/edit_menu_type/{id}','RestaurantController@edit_menu_type')->name('Edit Menu Type');
Route::post('/update_menu_type/{id}','RestaurantController@update_menu_type');
Route::get('/delete_menu_type/{id}','RestaurantController@delete_menu_type');


//PURCHASE
Route::get('/restaurant/purchase/purchases', 'RestaurantController@purchase')->name('Purchases');
Route::get('/restaurant/purchase/add_purchase', 'RestaurantController@add_purchase')->name('Add Purchase');
Route::post('/save_purchase','RestaurantController@save_purchase');
Route::get('/edit_purchase/{id}','RestaurantController@edit_purchase')->name('Edit Purchase');
Route::post('/update_purchase/{id}','RestaurantController@update_purchase');
Route::get('/delete_purchase/{id}','RestaurantController@delete_purchase');


//------RESTAURANT END-------//