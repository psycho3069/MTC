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

use App\Http\Controllers\Reports\BalanceSheetController;
use App\Http\Controllers\Reports\CashBookReportController;
use App\Http\Controllers\Reports\DailyTransactionController;
use App\Http\Controllers\Reports\IncomeStatementController;
use App\Http\Controllers\Reports\LedgerReportController;
use App\Http\Controllers\Reports\ReceiptPaymentController;
use App\Http\Controllers\Reports\StockReportController;
use App\Http\Controllers\SoftwareConfigurationController;
use App\TransactionHead;
use Illuminate\Support\Facades\Route;

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
//include('checkout_routes.php');



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


    return redirect('process');
});


Route::get('reserve', ['as' => 'reserve.create' , 'uses' => 'ResidualController@reserve']);
Route::post('reserve', ['as' => 'reserve.store' , 'uses' => 'ResidualController@reserveStore']);


Route::group(['middleware' => 'auth'], function (){
    Route::get('general/configuration/ledger/{type}', ['as' => 'configure.ledger', 'uses' => 'ResidualController@ledger']);
    Route::post('general/configuration/ledger', ['as' => 'update.ledger', 'uses' => 'ResidualController@updateLedger' ]);

    Route::get('software/configuration/hotel', [SoftwareConfigurationController::class, 'hotelConfiguration'])
        ->name('configuration.accounts');
    Route::post('software/configuration/hotel', [SoftwareConfigurationController::class, 'updateHotelConfiguration'])
        ->name('configuration.accounts');

    Route::get('software/configuration/software-date', [SoftwareConfigurationController::class, 'softwareDate'])
        ->name('configuration.software.date');
    Route::post('software/configuration/software-date', [SoftwareConfigurationController::class, 'updateSoftwareDate'])
        ->name('configuration.software.date');



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




    Route::resource('accounts/balance', 'BalanceController');
    Route::resource('accounts', 'AccountController');

    Route::any('stock-index-table/{mis_head_id}', 'StockController@getIndexTable')->name('table.stock.index');
    Route::any('stock-balance-table/{mis_head_id}', 'StockController@tableSearch')->name('table.stock.balance');

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
    Route::get('reports/test', ['as' => 'report.test', 'uses' => 'ReportController@test']);
    Route::get('reports/cash', ['as' => 'report.cash', 'uses' => 'ReportController@cash']);



    Route::any('reports/income-statement', [IncomeStatementController::class, 'incomeStatement'])
        ->name('reports.income.statement');

    Route::get('reports/ledger/{thead_id?}', [LedgerReportController::class, 'ledger'])
        ->name('report.ledger');
    Route::post('reports/ledger/{thead_id?}', [LedgerReportController::class, 'showLedger'])
        ->name('report.show.ledger');

    Route::get('reports/daily', [DailyTransactionController::class, 'daily'])
        ->name('report.daily');
    Route::post('reports/daily', [DailyTransactionController::class, 'showDaily'])
        ->name('report.show.daily');

    Route::get('reports/cash-book', [CashBookReportController::class, 'cashBook'])
        ->name('report.cash-book');
    Route::get('reports/bank-book', [CashBookReportController::class, 'bankBook'])
        ->name('report.bank-book');
    Route::get('reports/cash-bank-book', [CashBookReportController::class, 'cashBankBook'])
        ->name('report.cash-bank-book');

    Route::any('reports/receipt_payment', [ReceiptPaymentController::class, 'receiptPayment'])
        ->name('report.receipt_payment');

    Route::get('reports/stock/{id}', [StockReportController::class, 'stock'])
        ->name('report.stock');
    Route::post('reports/stock', [StockReportController::class, 'showStock'])
        ->name('report.show.stock');

    Route::get('reports/balance', [BalanceSheetController::class, 'balance'])
        ->name('report.balance');






});

//include('inventory_routes.php');
