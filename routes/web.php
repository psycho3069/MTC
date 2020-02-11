<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\TransactionHead;

Route::get('/', function () {
    return view('mtchome');
});

Route::get('/', 'FrontendController@home');
Route::get('/hotel_management/room/room_viewer', 'FrontendController@room_viewer');

Route::get('/hotel_management/room/room_viewer/floor1', 'FrontendController@floor1');
Route::get('/hotel_management/room/room_viewer/floor2', 'FrontendController@floor2');
Route::get('/hotel_management/room/room_viewer/floor3', 'FrontendController@floor3');
Route::get('/hotel_management/room/room_viewer/floor4', 'FrontendController@floor4');

Route::get('room_viewer/{id}/view', 'FrontendController@viewFloor1');
Route::get('venue_details/{id}/view', 'FrontendController@viewVenues');

Route::get('/addbooking/{id}', 'FrontendController@add_booking')->name('Add Room Booking');
Route::post('/savebooking','FrontendController@save_booking');
Route::get('/addreservation/{id}', 'FrontendController@add_reservation')->name('Add Room Reservation');
Route::post('/savereservation','FrontendController@save_reservation');

Route::get('/training/add-booking/{id}', 'FrontendController@add_venueBook');
Route::post('/training/store_booking', 'FrontendController@storeVenueBook');

Route::get('/training/addvenueRes/{id}', 'FrontendController@addvenueRes')->name('addvenueRes');
Route::post('/savevenueRes','FrontendController@savevenueRes');

//Auth::routes();

Auth::routes(['verify' => true, 'register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
//training center
include('traningcenter.php');


//maintenance
Route::get('/maintenance', ['as' => 'maintenance', 'uses' => 'AdminController@maintenance']);

include('admin_routes.php');
include('hotel_routes.php');
include('hr_routes.php');
include('restaurant_routes.php');
include('account_routes.php');
include('checkout_routes.php');



Route::get('insert', function (){

//    DB::table('m1_mis_heads')->insert([
//        ['name' => 'Hotel Receipt', 'voucher_type_id' => 10, 'credit_head_id' => 12, 'debit_head_id' => 353, ],
//        ['name' => 'Venue Receipt', 'voucher_type_id' => 10,  'credit_head_id' => 12, 'debit_head_id' => 353, ],
//        ['name' => 'Restaurant Receipt', 'voucher_type_id' => 10, 'credit_head_id' => 12, 'debit_head_id' => 353, ],
//        ['name' => 'Restaurant Payment', 'voucher_type_id' => 11, 'credit_head_id' => 12, 'debit_head_id' => 353, ],
//        ['name' => 'Inventory Payment', 'voucher_type_id' => 11, 'credit_head_id' => 12, 'debit_head_id' => 353, ],
//        ['name' => 'Discount', 'voucher_type_id' => 10, 'credit_head_id' => 353, 'debit_head_id' => 12, ],
//    ]);
//
//    DB::table('m3_mis_ledger_heads')->insert([
//        ['mis_head_id' => 1, 'name' => 'Room', 'credit_head_id' => 2, 'debit_head_id' => 2, 'code' => 1000, 'ledgerable_id' => 1, 'ledgerable_type' => 'App\\MISHead', ],
//        ['mis_head_id' => 2, 'name' => 'Venue', 'credit_head_id' => 2, 'debit_head_id' => 2, 'code' => 1100, 'ledgerable_id' => 2, 'ledgerable_type' => 'App\\MISHead', ],
//        ['mis_head_id' => 3, 'name' => 'Restaurant', 'credit_head_id' => 2, 'debit_head_id' => 2, 'code' => 1200, 'ledgerable_id' => 3, 'ledgerable_type' => 'App\\MISHead', ],
//        ['mis_head_id' => 6, 'name' => 'Discount', 'credit_head_id' => 2, 'debit_head_id' => 2, 'code' => 1300, 'ledgerable_id' => 6, 'ledgerable_type' => 'App\\MISHead', ],
//    ]);


//    return \App\MISHead::all();

    $theads = TransactionHead::all();

    foreach ($theads as $thead) {
        if ( $thead->currentBalance->isEmpty()){
            $thead->currentBalance()->create([
                'debit' => $thead->debit,
                'credit' => $thead->credit,
            ]);
        }
    }

    return redirect('process');
});


Route::get('reserve', ['as' => 'reserve.create' , 'uses' => 'ResidualController@reserve']);
Route::post('reserve', ['as' => 'reserve.store' , 'uses' => 'ResidualController@reserveStore']);


Route::group(['middleware' => 'auth'], function (){


//    Route
    Route::get('general/configuration/hotel', ['as' => 'configure.hotel', 'uses' => 'ResidualController@hotel']);
    Route::post('general/configuration/hotel', ['as' => 'update.hotel', 'uses' => 'ResidualController@updateHotel']);
    Route::get('general/configuration/ledger/{type}', ['as' => 'configure.ledger', 'uses' => 'ResidualController@ledger']);
    Route::post('general/configuration/ledger', ['as' => 'update.ledger', 'uses' => 'ResidualController@updateLedger' ]);



    Route::resource('ledgers', 'LedgerHeadController');
    Route::resource('units', 'UnitController');


    Route::post('add/supplier', ['as' => 'add.supplier', 'uses' => 'SupplierController@add']);


    Route::get('discount', ['as' => 'discount.index', 'uses' => 'ResidualController@discount']);

    Route::post('year', ['as' => 'process.year', 'uses' => 'ProcessController@year']);

    Route::get('visitor/{booking_id}', ['as' => 'visitor.list', 'uses' => 'BookingController@listVisitor']);
    Route::get('visitor/create/{booking_id}', ['as' => 'visitor.create', 'uses' => 'BookingController@addVisitor']);
    Route::post('visitor', ['as' => 'visitor.store', 'uses' => 'BookingController@storeVisitor']);
    Route::resource('supplier', 'SupplierController');


    Route::get('billing/export/{bill_id}', 'BillingController@export');
    Route::resource('billing', 'BillingController');
    Route::resource('booking', 'BookingController');

    Route::post('{bill_id}/payment/bill', ['as' => 'payment.bill', 'uses' => 'PaymentController@bill']);
    Route::post('{bill_id}/payment/checkout', ['as' => 'payment.checkout', 'uses' => 'PaymentController@checkout']);
    Route::resource('{bill_id}/payment', 'PaymentController');


    Route::post('sales/room', ['as' => 'sales.room', 'uses' => 'FoodSaleController@room']);
    Route::post('restaurant/menu', ['as' => 'food.menu', 'uses' => 'FoodSaleController@menu']);
    Route::resource('restaurant/sales', 'FoodSaleController');
    Route::resource('food/menu', 'FoodMenuController');




    Route::post('accounts/balance/check', ['as' => 'balance.check', 'uses' => 'BalanceController@check']);
    Route::resource('accounts/balance', 'BalanceController');
    Route::resource('accounts', 'AccountController');

    Route::post('stock/opening', ['as' => 'stock.balance', 'uses' => 'StockController@balance']);
    Route::get('stock/opening/{type_id}', ['as' => 'stock.opening', 'uses' => 'StockController@opening']);
    Route::get('stock/list/{type_id}', ['as' => 'stock.list', 'uses' => 'StockController@list']);
    Route::resource('stock', 'StockController');
    Route::resource('stocks/deliver', 'StockDeliverController');

    Route::post('purchase/item', ['as' => 'purchase.item', 'uses' => 'PurchaseController@item']);
    Route::resource('purchase','PurchaseController');



    Route::get('process/list', ['as' => 'process.list', 'uses' => 'ProcessController@list']);
    Route::post('process/list', ['as' => 'process.show.list', 'uses' => 'ProcessController@showList']);
    Route::resource('process', 'ProcessController');
    Route::post('vouchers/list', ['as' => 'vouchers.list', 'uses' => 'VoucherController@list'] );
    Route::resource('vouchers', 'VoucherController');

    Route::get('reports/income', ['as' => 'report.income', 'uses' => 'ReportController@income']);
    Route::get('reports/balance', ['as' => 'report.balance', 'uses' => 'ReportController@balance']);
    Route::get('reports/test', ['as' => 'report.test', 'uses' => 'ReportController@test']);
    Route::get('reports/cash', ['as' => 'report.cash', 'uses' => 'ReportController@cash']);
    Route::get('reports/ledger/{thead_id?}', ['as' => 'report.ledger', 'uses' => 'ReportController@ledger']);
    Route::post('reports/ledger', ['as' => 'report.show.ledger', 'uses' => 'ReportController@showLedger']);
    Route::get('reports/daily', ['as' => 'report.daily', 'uses' => 'ReportController@daily']);
    Route::post('reports/daily', ['as' => 'report.show.daily', 'uses' => 'ReportController@showDaily']);


    Route::get('reports/stock/{id}', ['as' => 'report.stock', 'uses' => 'ReportController@stock']);
//    Route::post('reports/stock/1', ['as' => 'report.show.stock', 'uses' => 'ReportController@showStock']);




//    Route::resource('receiver', 'ReceiverController');
//    Route::resource('staff', 'StaffController');
//    Route::resource('mis/accounts', 'MisAccountController', ['as' => 'mis']);
//    Route::post('purchase/item', ['as' => 'purchase.item', 'uses' => 'InventoryPurchaseController@item']);
//    Route::get('inventory/list', ['as' => 'inventory.list', 'uses' => 'MisInventoryController@list']);
//    Route::resource('mis/inventory', 'MisInventoryController', ['as' => 'mis']);



});

include('inventory_routes.php');
