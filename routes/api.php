<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Shop\MainController;
use App\Http\Controllers\InfinityScrollController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Shop\BasketController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API for showing products
Route::get('', [ShopProductController::class, 'index'])->name('api.products.index');
Route::get('/products/{product}', [ShopProductController::class, 'show'])->name('api.products.show');
Route::get('/categories', [ShopProductController::class, 'categories'])->name('api.products.categories');


//API routes for basket operations
Route::get('/basket/add/{product}', [BasketController::class, 'add'])->name('api.basket.add');
Route::delete('/basket/remove/{product}', [BasketController::class, 'remove'])->name('api.basket.remove');
Route::put('/basket/update/quantity/{product}', [BasketController::class, 'updateQuantity'])->name('api.basket.update.quantity'); // Add this route
Route::post('/basket/clear', [BasketController::class, 'clear'])->name('api.basket.clear'); // Add this route


// API for checkout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('api.checkout.process');
    Route::get('/checkout', [CheckoutController::class, 'checkoutForm'])->name('api.checkout.index'); // This should point to the view
    // Route::get('/checkout', [CheckoutController::class, 'checkoutView'])->name('checkout.view');
});


// API routes for admin products
Route::prefix('/admin/products')->group(function() {
    Route::get('/', [productController::class, 'all'])->name('api.admin.products.all');
    Route::post('/', [productController::class, 'store'])->name('api.admin.products.store');
    Route::get('/{product}', [productController::class, 'edit'])->name('api.admin.products.edit');
    Route::put('/{product}', [productController::class, 'update'])->name('api.admin.products.update');
    Route::delete('/{product}', [productController::class, 'destroy'])->name('api.admin.products.destroy');
    Route::post('/import', [productController::class, 'importCSV'])->name('api.admin.products.import');
});


// API routes for admin/categories
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('api.categories.data');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('api.categories.destroy');


// API routes for login and registration
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'attemptLogin'])->name('api.login');


/* For products */
// Route::prefix('/products')->group(function(){
//     Route::get('' , [ShopProductController::class , 'index'])->name('api.shop.products.index');
//     Route::get('/{product}/show' , [ShopProductController::class , 'show'])->name('api.shop.products.show');
// });


//API for charts
Route::prefix('/dashboard')->group(function(){
    Route::get('/pie-chart', [ChartController::class, 'pieChart'])->name('api.charts.pie');
    Route::get('/line-chart', [ChartController::class, 'lineChart'])->name('api.charts.line');
    Route::get('/bar-chart', [ChartController::class, 'barChart'])->name('api.charts.bar');
}); 