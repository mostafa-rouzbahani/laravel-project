<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('advertisement', 'AdvertisementController');
Route::post('advertisement.datatable','AdvertisementController@advertisement_data')->name('advertisement.datatable');

Route::resource('transactions', 'TransactionController');
Route::post('transactions.b_table','TransactionController@b_datatable_data')->name('transactions.b_table');
Route::post('transactions.s_table','TransactionController@s_datatable_data')->name('transactions.s_table');
Route::post('transactions.f_table','TransactionController@f_datatable_data')->name('transactions.f_table');
Route::patch('transactions/{transaction}/cancel','TransactionController@cancel')->name('transactions.cancel');

Route::get('admin', 'AdminController@index')->name('admin');
Route::get('admin/transactions', 'AdminController@transactions')->name('admin.transactions');
Route::get('admin/{transaction}/transactionShow','AdminController@transactionShow')->name('admin.transactionShow');
Route::post('admin.verify_table','AdminController@verify_data')->name('admin.verify_table');
Route::post('admin.active_table','AdminController@active_data')->name('admin.active_table');
Route::post('admin.finish_table','AdminController@finish_data')->name('admin.finish_table');
Route::get('admin/rates', 'AdminController@rates')->name('admin.rates');
Route::post('admin/rates', 'AdminController@rateChange')->name('admin.rateChange');
Route::get('admin/tickets', 'AdminController@tickets')->name('admin.tickets');
Route::get('admin/{ticket}/ticketShow', 'AdminController@ticketShow')->name('admin.ticketShow');
Route::patch('admin/{ticket}/ticketShow', 'AdminController@ticketUpdate')->name('admin.ticketUpdate');
Route::patch('admin/{ticket}/ticketClose', 'AdminController@ticketClose')->name('admin.ticketClose');
Route::post('admin.active_tickets_table','AdminController@active_tickets_data')->name('admin.active_tickets_table');
Route::post('admin.finish_tickets_table','AdminController@finish_tickets_data')->name('admin.finish_tickets_table');
Route::get('admin/options', 'AdminController@options')->name('admin.options');
Route::patch('admin/options', 'AdminController@optionChange')->name('admin.optionChange');



Route::resource('tickets', 'TicketController');
Route::post('tickets.datatable','TicketController@ticket_data')->name('tickets.datatable');

//Route::get('command', function () {
//
//    /* php artisan migrate */
//    \Artisan::call('migrate');
//    dd("Done");
//});



