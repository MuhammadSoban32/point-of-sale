<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Inventory_Controller;
use App\Http\Controllers\dashboard\Bill_Controller;
use App\Http\Controllers\dashboard\Booking_Controller;
use App\Http\Controllers\dashboard\Profile_Controller;
use App\Http\Controllers\dashboard\AuthController;



Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'guest'],function(){
  //ADMIN LOGIN
  Route::get('/login',[AuthController::class,'login_vew'])->name('login');
  Route::post('/login',[AuthController::class,'login']);  
});


Route::group(['middleware'=>'auth'],function(){
// ITEMS
Route::get('/',[Inventory_Controller::class,'index']);
Route::post('/add-item',[Inventory_Controller::class,'add_item']);
Route::get('/fetch-item',[Inventory_Controller::class,'fetch_items']);
Route::get('/delete-item',[Inventory_Controller::class,'delete_item']);
Route::get('/edit-items-modal',[Inventory_Controller::class,'edit_item_modal']);
Route::post('/edit-items',[Inventory_Controller::class,'edit_item']);

// BILL GENERATE
Route::get('/bills',[Bill_Controller::class,'bills']);
//   Route::get('/bills',[Bill_Controller::class,'index']);
//   Route::get('/fetch-products',[Products_SalesController::class,'fetch']);
  Route::get('/fetch_bills',[Bill_Controller::class,'fetch_bills'])->name('fetch.bills');
  Route::get('/delete_bills',[Bill_Controller::class,'delete_bills']);
  Route::get('/bills_create_page',[Bill_Controller::class,'bills_create_page']);
  Route::post('/bill_create',[Bill_Controller::class,'bill_create']);
  Route::get('/fetch_bills_items',[Bill_Controller::class,'fetch_bills_items']);
  Route::get('/bills-edit/{id}',[Bill_Controller::class,'bills_edit_page']);
  Route::post('/bills-edit',[Bill_Controller::class,'bills_edit']);
  Route::post('/search_by',[Bill_Controller::class,'search_by']);
  Route::post('/get_item_unit',[Bill_Controller::class,'get_item_unit']);
  
// BOOKING
Route::get('/booking',[Booking_Controller::class,'booking']);
// PROFILE
Route::get('/profile',[Profile_Controller::class,'profile']);
Route::post('/update_profile',[Profile_Controller::class,'update_profile']);
Route::post('/update_password',[Profile_Controller::class,'update_password']);
Route::get('/view_testing',[Profile_Controller::class,'view_testing']);

//ADMIN LOGOUT
Route::get('/logout',[AuthController::class,'logout']);
// Route::get('/logout',[AuthController::class,'logout']);
// Route::get('/logout',[AuthController::class,'logout']);

});