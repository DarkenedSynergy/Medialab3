<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('/', [HomeController::class, 'index']);;


//Admin dashboard
route::get('/home', [AdminController::class, 'index']);

route::get('/categorie_page', [AdminController::class, 'categorie_page']);

route::post('/add_category', [AdminController::class, 'add_category']);

route::get('/cat_delete/{id}', [AdminController::class, 'cat_delete']);

route::get('/cat_edit/{id}', [AdminController::class, 'cat_edit']);

route::post('/update_category/{id}', [AdminController::class, 'update_category']);

route::get('/add_product', [AdminController::class, 'add_product']);

route::get('/show_product', [AdminController::class, 'show_product']);

route::get('/product_delete/{id}', [AdminController::class, 'product_delete']);

route::get('/update_product/{id}', [AdminController::class, 'update_product']);

route::post('/store_product', [AdminController::class, 'store_product']);

route::post('/update_product/{id}', [AdminController::class, 'update_product1']);

route::get('/approved_product/{id}', [AdminController::class, 'approve_product']);

route::get('/rejected_product/{id}', [AdminController::class, 'rejected_product']);

route::get('/returned_product/{id}', [AdminController::class, 'returned_product']);

route::get('/show_user', [AdminController::class, 'show_user']);

route::get('/blacklist/{id}', [AdminController::class, 'blacklist']);

route::get('/unblacklist/{id}', [AdminController::class, 'unblacklist']);

route::get('/show_blacklist', [AdminController::class, 'show_blacklist']);

route::get('/add_item', [AdminController::class, 'add_item']);

Route::post('generate_serial', [AdminController::class, 'generateSerial'])->name('generate_serial');

route::get('/delete_item/{item_id}', [AdminController::class, 'delete_item']);

route::get('/search_product', [AdminController::class, 'search_product']);

route::get('/search_user', [AdminController::class, 'search_user']);

route::get('/search_blacklist', [AdminController::class, 'search_blacklist']);

route::get('/outgoing_products', [AdminController::class, 'showOutgoingProducts']);

route::get('/incoming_products', [AdminController::class, 'showIncomingProducts']);







//User page's
route::get('/borrow_product/{id}', [HomeController::class, 'borrow_product']);

route::get('/mainpage', [HomeController::class, 'mainpage']);

route::get('/home2', [HomeController::class, 'index']);

route::get('/search', [HomeController::class, 'search']);

route::get('/search2', [HomeController::class, 'search2']);

route::get('/details_product/{id}', [HomeController::class, 'details_product'])->middleware('auth', 'verified', 'blacklist');

route::get('/add_favorites/{id}', [HomeController::class, 'add_favorites'])->middleware('auth', 'verified', 'blacklist');

route::get('/show_favorites', [HomeController::class, 'show_favorites'])->middleware('auth', 'verified', 'blacklist');

route::get('/add_cart/{id}', [HomeController::class, 'add_cart'])->middleware('auth', 'verified', 'blacklist');

route::get('/favo_delete/{id}', [HomeController::class, 'favo_delete'])->middleware('auth', 'verified', 'blacklist');

route::get('/cart_delete/{id}', [HomeController::class, 'cart_delete'])->middleware('auth', 'verified', 'blacklist');

route::get('/show_cart', [HomeController::class, 'show_cart'])->middleware('auth', 'verified', 'blacklist');

route::get('/show_reservation', [HomeController::class, 'show_reservation'])->middleware('auth', 'verified', 'blacklist');

route::post('/reservation', [HomeController::class, 'reservation'])->middleware('auth', 'verified', 'blacklist');

route::get('/delete_cart/{id}', [HomeController::class, 'delete_cart'])->middleware('auth', 'verified', 'blacklist');

Route::post('/confirm_reservation', [HomeController::class, 'confirmReservation'])->name('confirm_reservation')->middleware('auth', 'verified', 'blacklist');
Route::get('/blacklistpage', [HomeController::class, 'blacklistview'])->name('blacklistview');

Route::post('/schade-melden/{id}', [HomeController::class, 'schadeMelden'])->name('schade.melden')->middleware('auth', 'verified', 'blacklist');

Route::get('/extend-reservation/{id}', [HomeController::class, 'extended'])->name('extend.reservation')->middleware('auth', 'verified', 'blacklist');






Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
Route::get('/', function () {
    Mail::to('dejaynyo@gmail.com')->send(new HelloMail());
});
*/
