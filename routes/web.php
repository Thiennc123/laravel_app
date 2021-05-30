<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ProductController;
use app\Http\Controllers\SearchController;
use app\Http\Controllers\BillInfoController;


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

/*Route::get('/orderList', function () {
    return view('OrderViews.orderList');
})->middleware(['auth'])->name('orderList');*/

require __DIR__ . '/auth.php';

Route::get('login/google', [App\Http\Controllers\Auth\SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\SocialController::class, 'handleGoogleCallback']);

//Auth::routes();

/*add type */

Route::resource('/addTypes', TypeController::class);

Route::resource('/orderList', ProductController::class)->middleware(['auth'])->name('index', 'orderList');

Route::resource('/addProducts', ProductController::class)->middleware(['auth']);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/searchAjax', 'App\Http\Controllers\ProductController@searchAutoComplete')->name('searchProductAjax');

//Route::get("/showBillInfo", 'App\Http\Controllers\BillInfoController@index');

Route::get('/showBillStore', 'App\Http\Controllers\BillStoreController@index')->middleware(['auth'])->name('billStoreList');

Route::get('/addBillStore', 'App\Http\Controllers\BillStoreController@store')->middleware(['auth'])->name('addBillStore');

Route::get('/addBillInfo/{id}', 'App\Http\Controllers\BillInfoController@create')->middleware(['auth'])->name('addBillInfo');

Route::post('/searching/{id}', 'App\Http\Controllers\BillInfoController@store')->middleware(['auth'])->name('storeBillInfo1');

Route::post('/updateCountOfBillStore', 'App\Http\Controllers\BillInfoController@update')->middleware(['auth'])->name('updateCountOfBillInfo');

Route::post('/updateBillStore/{id}', 'App\Http\Controllers\BillStoreController@update')->middleware(['auth'])->name('updateBillStore');

Route::post('/removeBillStore/{id}', 'App\Http\Controllers\BillInfoController@destroy')->middleware(['auth'])->name('removeBillInfo');

Route::get('/editBillStore/{id}', 'App\Http\Controllers\BillInfoController@show')->middleware(['auth'])->name('editBillInfo');

Route::get('/deleteBillStore/{id}', 'App\Http\Controllers\BillStoreController@destroy')->middleware(['auth'])->name('deleteBillStore');

Route::get('/updateProductAfterSave/{id}', 'App\Http\Controllers\BillStoreController@updateProductAfterSave')->middleware(['auth'])->name('updateProductAfterSave');

Route::get('/printBillStore/{id}', 'App\Http\Controllers\BillStoreController@printOder')->middleware(['auth'])->name('printBillStore');
