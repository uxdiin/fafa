<?php
use App\Http\Controllers\AdminController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\BasketController;

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

Route::get('users/index','UserController@index')->name('users.index');
Route::prefix('admin')->group(function(){
    Route::get('/','AdminController@dashboard')->name('admin.dashboard');
    Route::get('items/index', 'ItemController@index')->name('items.index');
    Route::post('items/save', 'ItemController@store')->name('items.save');
    Route::get('items-list','ItemController@apiIndex')->name('items.list');
    Route::post('items/edit','ItemController@update')->name('items.edit');
    Route::delete('items/delete','ItemController@destroy')->name('items.delete');

    Route::get('categories/index','CategoryController@index')->name('categories.index');
    Route::post('category/save','CategoryController@store')->name('category.save');
    Route::get('categories-list','CategoryController@apiIndex')->name('categories.list');
    Route::post('category/edit','CategoryController@update')->name('category.edit');
    Route::delete('category/delete','CategoryController@destroy')->name('category.delete');

    Route::get('/home','homeController@index')->name('home.index');
});
Route::prefix('users')->group(function(){
    Route::get('/home','homeController@index')->name('home.index');

    Route::get('/basket/item-list','BasketController@apiIndex')->name('basket.item-list');
    Route::get('/create-basket','BasketController@store')->name('basket.create');
    Route::post('/add-to-basket','BasketController@update')->name('basket.edit');
    Route::post('/add-total','BasketController@addTotal')->name('basket.addTotal');
    Route::post('/dec-total','BasketController@decTotal')->name('basket.decTotal');
    Route::get('/check-basket-item','BasketCOntroller@countBasketItem')->name('basket.countItem');

    Route::get('/checkout','CheckoutController@index')->name('users.checkout.index');
    Route::get('/checkout/total-price','CheckoutController@totalPrice')->name('users.checkout.total-price');
    Route::get('/checkout/total-balance','CheckoutController@totalBalance')->name('users.checkout.total-balance');
    Route::post('/checkout/make-order','CheckoutController@makeOrder')->name('user.checkout.make-order');
    Route::get('shippings/province-list','ShippingController@listProvince')->name('users.shippings.province-list');
    Route::post('shippings/city-list','ShippingController@listCity')->name('users.shippings.city-list');
    Route::post('shippings/price','ShippingController@price')->name('user.shippings.price');

});
Route::get('/unathorized', function () {
    return view('unauthorized');
})->name('unauthorized');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
