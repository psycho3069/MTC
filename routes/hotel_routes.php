<?php

//------HOTEL-MANAGEMENT-START-------//

//BUILDING
Route::get('/hotel_management/building/building_list', 'HotelController@building')->name('Buildings');
Route::get('/hotel_management/building/addbuilding', 'HotelController@add_building')->name('Add Building');
Route::get('/hotel_management/building/building_type_list', 'HotelController@building_type')->name('Building Types');
Route::get('/hotel_management/building/addbuildingtype', 'HotelController@add_building_type')->name('Add Building Type');
Route::post('/savebuilding','HotelController@save_building');
Route::post('/savebuildingtype','HotelController@save_building_type');
Route::get('/editbuilding/{id}','HotelController@edit_building')->name('Edit Building');
Route::post('/updatebuilding/{id}','HotelController@update_building');
Route::get('/deletebuilding/{id}','HotelController@delete_building');
Route::get('/editbuildingtype/{id}','HotelController@edit_building_type')->name('Edit Building Type');
Route::post('/updatebuildingtype/{id}','HotelController@update_building_type');
Route::get('/deletebuildingtype/{id}','HotelController@delete_building_type');

//FLOOR
Route::get('/hotel_management/floor/floor_list', 'HotelController@floor')->name('Floors');
Route::get('/hotel_management/floor/addfloor', 'HotelController@add_floor')->name('Add Floor');
Route::get('/hotel_management/floor/floor_type_list', 'HotelController@floor_type')->name('Floor Types');
Route::get('/hotel_management/floor/addfloortype', 'HotelController@add_floor_type')->name('Add Floor Type');
Route::post('/savefloor','HotelController@save_floor');
Route::post('/savefloortype','HotelController@save_floor_type');
Route::get('/editfloortype/{id}','HotelController@edit_floor_type')->name('Edit Floor Type');
Route::post('/updatefloortype/{id}','HotelController@update_floor_type');
Route::get('/deletefloortype/{id}','HotelController@delete_floor_type');
Route::get('/editfloor/{id}','HotelController@edit_floor')->name('Edit Floor');
Route::post('/updatefloor/{id}','HotelController@update_floor');
Route::get('/deletefloor/{id}','HotelController@delete_floor');

//ROOM
Route::get('/hotel_management/room/room_viewer', 'FrontendController@room_viewer');

Route::get('/hotel_management/room/room_viewer/floor1', 'FrontendController@floor1');
Route::get('room_viewer/{id}/view', 'FrontendController@viewFloor1');

Route::get('/hotel_management/room/room_viewer/floor2', 'FrontendController@floor2');
Route::get('/hotel_management/room/room_viewer/floor3', 'FrontendController@floor3');
Route::get('/hotel_management/room/room_viewer/floor4', 'FrontendController@floor4');

Route::get('/hotel_management/room/room_category_list', 'HotelController@room_category')->name('Room Categories');
Route::get('/hotel_management/room/addroomcategory', 'HotelController@add_room_category')->name('Add Room Category');
Route::get('/hotel_management/room/room_list', 'HotelController@room')->name('Rooms');
Route::get('/hotel_management/room/addroom', 'HotelController@add_room')->name('Add Room');
Route::post('/saveroom','HotelController@save_room');
Route::post('/saveroomcategory','HotelController@save_room_category');
Route::get('/editroomcategory/{id}','HotelController@edit_room_category')->name('Edit Room Category');
Route::post('/updateroomcategory/{id}','HotelController@update_room_category');
Route::get('/deleteroomcategory/{id}','HotelController@delete_room_category');
Route::get('/editroom/{id}','HotelController@edit_room')->name('Edit Room');
Route::post('/updateroom/{id}','HotelController@update_room');
Route::get('/deleteroom/{id}','HotelController@delete_room');

//RESERVATION
Route::get('/hotel_management/reservation/room_reservation_list', 'HotelController@automaticallyDelete');
Route::get('/addreservation/{id}', 'FrontendController@add_reservation')->name('Add Room Reservation');
Route::post('/savereservation','FrontendController@save_reservation');
Route::get('/viewreservation/{id}','HotelController@view_reservation')->name('View Room Reservation');
Route::get('/editreservation/{id}','HotelController@edit_reservation')->name('Edit Room Reservation');
Route::post('/updatereservation/{id}','HotelController@update_reservation');
Route::get('/deletereservation/{id}','HotelController@delete_reservation');
Route::get('/makebooking/{id}','HotelController@make_booking');
Route::post('/savemakebooking','HotelController@save_make_booking');

//BOOKING
Route::get('/hotel_management/booking/booking_list', 'HotelController@room_booking')->name('Room Bookings');
Route::get('/addbooking/{id}', 'FrontendController@add_booking')->name('Add Room Booking');
Route::post('/savebooking','FrontendController@save_booking');
Route::get('/makebilling/{id}', 'HotelController@make_billing')->name('Make Room Bill');
Route::get('/viewbooking/{id}','HotelController@view_booking')->name('View Room Booking');
Route::get('/editbooking/{id}','HotelController@edit_booking')->name('Edit Room Booking');
Route::post('/updatebooking/{id}','HotelController@update_booking');
Route::get('/deletebooking/{id}','HotelController@delete_booking');

//BILLING
Route::get('/hotel_management/billing/billing_list', 'HotelController@room_billing')->name('Room Billings');
Route::post('/savebilling','HotelController@save_billing');
Route::get('/viewbilling/{id}','HotelController@view_billing')->name('View Room Billing');
Route::get('/deletebilling/{id}','HotelController@delete_billing');

// FOOD SALE
Route::get('/restaurant/sale/food-sale','HotelController@food_sale');
Route::get('/restaurant/sale/add-food-sale','HotelController@add_food_sale');
Route::post('/sale/store-food-sale','HotelController@store_food_sale');
Route::get('/restaurant/sale/edit-food-sale/{id}','HotelController@edit_food_sale');
Route::post('/update/sale/{id}','HotelController@update_food_sale');
Route::get('/deleteSale/{id}','HotelController@delete_food_sale');

Route::post('/autocomplete/fetch', 'HotelController@fetch')->name('autocomplete.fetch');


//------HOTEL-MANAGEMENT-END-------//