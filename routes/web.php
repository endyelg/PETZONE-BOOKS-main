<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderProductController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\productController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MyPanelController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PaymentController as ControllersPaymentController;
use App\Http\Controllers\Shop\BasketController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\MainController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryChartController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\ProductStockController;


/** Book shop routes **/
Route::prefix('')->group(function(){
    /* For main ones */
    Route::get('' , [MainController::class , 'home'])->name('shop.home');
    /* For products */
    Route::prefix('/products')->group(function(){
        Route::get('' , [ShopProductController::class , 'index'])->name('shop.products.index');
        Route::get('/{product}/show' , [ShopProductController::class , 'show'])->name('shop.products.show');
    });
    /* For basket */
    Route::prefix('/basket')->group(function(){
        // checked restfull(methods!!!!)
        Route::get('' , [BasketController::class , 'index'])->name('shop.basket.index');
        Route::get('/{product}/add' , [BasketController::class , 'add'])->name('shop.basket.add');
        Route::get('/{product}/remove' , [BasketController::class , 'remove'])->name('shop.basket.remove');
        Route::get('/clear' , [BasketController::class , 'clear'])->name('shop.basket.clear');
        Route::put('/update/{product}/quantity' , [BasketController::class , 'updateQuantity'])->name('shop.basket.update.quantity');
    });
    /* For checkout */
    Route::prefix('/checkout')->group(function(){
        Route::get('/checkout', [CheckoutController::class, 'checkoutForm'])->name('shop.checkout.index');
        Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('shop.checkout.process');
    });
});

/** Payment routes **/
Route::prefix('/payment')->group(function(){
    Route::post('/pay' , [ControllersPaymentController::class , 'pay'])->name('payment.pay');
    Route::get('/{gateway}/callback' , [ControllersPaymentController::class , 'callback'])->name('payment.callback');
});



/** Routes that has admin prefix **/
Route::prefix('/admin')->group(function(){
    /* For categories */
    Route::prefix('/categories')->group(function(){
        Route::get('' , [CategoryController::class , 'index'])->name('admin.categories.index');
        Route::post('' , [CategoryController::class , 'storage'])->name('admin.categories.storage');
        Route::delete('/{category}/remove' , [CategoryController::class , 'destroy'])->name('admin.categories.destroy');
        Route::get('/{category}/edit' , [CategoryController::class , 'edit'])->name('admin.categories.edit');
        Route::put('/{category}/update' , [CategoryController::class , 'update'])->name('admin.categories.update');
    });
    /* For products */
    Route::prefix('/products')->group(function(){
        Route::get('' , [productController::class , 'all'])->name('admin.products.all');
        Route::get('/create' , [productController::class , 'create'])->name('admin.products.create');
        Route::post('' , [productController::class , 'store'])->name('admin.products.store');
        Route::delete('/{product}/remove' , [productController::class , 'destroy'])->name('admin.products.destroy');
        Route::get('/{product}/edit' , [productController::class , 'edit'])->name('admin.products.edit');
        Route::put('/{product}/update' , [productController::class , 'update'])->name('admin.products.update');
        Route::get('{product}/download/demo' , [productController::class , 'downloadDemo'])->name('admin.products.download.demo');
    });
    /* For users */
    Route::prefix('/users')->group(function(){
        Route::get('' , [UserController::class , 'all'])->name('admin.users.all');
        Route::get('/create' , [UserController::class , 'create'])->name('admin.users.create');
        Route::post('' , [UserController::class , 'store'])->name('admin.users.store');
        Route::delete('/{user}/remove' , [UserController::class , 'destroy'])->name('admin.users.destroy');
        Route::get('/{user}/edit' , [UserController::class , 'edit'])->name('admin.users.edit');
        Route::put('/{user}/update' , [UserController::class , 'update'])->name('admin.users.update');
    });
    Route::prefix('/suppliers')->group(function(){
        Route::get('' , [SupplierController::class , 'all'])->name('admin.suppliers.all');
        Route::get('/create' , [SupplierController::class , 'create'])->name('admin.suppliers.create');
        Route::post('' , [SupplierController::class , 'store'])->name('admin.suppliers.store');
        Route::delete('/{supplier}/remove' , [SupplierController::class , 'destroy'])->name('admin.suppliers.destroy');
        Route::get('/{supplier}/edit' , [SupplierController::class , 'edit'])->name('admin.suppliers.edit');
        Route::put('/{supplier}/update' , [SupplierController::class , 'update'])->name('admin.suppliers.update');
});
    /* For expenses */
    Route::prefix('/expenses')->group(function(){
        Route::get('' , [ExpensesController::class , 'all'])->name('admin.expenses.all');
        Route::get('/create' , [ExpensesController::class , 'create'])->name('admin.expenses.create');
        Route::post('' , [ExpensesController::class , 'store'])->name('admin.expenses.store');
        Route::delete('/{expense}/remove' , [ExpensesController::class , 'destroy'])->name('admin.expenses.destroy');
        Route::get('/{expense}/edit' , [ExpensesController::class , 'edit'])->name('admin.expenses.edit');
        Route::put('/{expense}/update' , [ExpensesController::class , 'update'])->name('admin.expenses.update');
});

    /* For orders */
    Route::prefix('/orders')->group(function(){
        Route::get('' , [OrderController::class , 'index'])->name('admin.orders.index');
    });
    // For Orders
Route::prefix('admin/orders')->group(function () {
    Route::get('', [OrderController::class, 'all'])->name('admin.orders.all');
    Route::get('/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::delete('/{order}/remove', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/{order}/update', [OrderController::class, 'update'])->name('admin.orders.update');
});

Route::prefix('admin')->group(function () {
    Route::get('order-products', [OrderProductController::class, 'index'])->name('admin.order_product.index');
    Route::get('order-products/{order}/{product}/edit', [OrderProductController::class, 'edit'])->name('admin.orderProduct.edit');
    Route::delete('order-products/{order}/{product}', [OrderProductController::class, 'destroy'])->name('admin.orderProduct.destroy');
});

Route::prefix('admin')->group(function () {
Route::get('/product_stock', [ProductStockController::class, 'index'])->name('admin.product_stock.index');
});
    /* For payments */
    Route::prefix('/payments')->group(function(){
        Route::get('' , [PaymentController::class , 'index'])->name('admin.payments.index');
    });
});

/** Authentication routes **/
Auth::routes();
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/my-panel', [MyPanelController::class, 'index'])->name('my-panel');
    Route::post('/update-user', [MyPanelController::class, 'updateUser'])->name('update-user');

});

Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('my-orders');

Route::get('/products', [ShopProductController::class, 'index'])->name('shop.products.index');

Route::get('admin/categories/data', [CategoryController::class, 'getData'])->name('admin.categories.data');
// Route::view('/charts', 'admin.charts.bar');

Route::view('/admin/charts/bar', 'admin.charts.bar')->name('admin.charts.bar');
Route::view('/admin/charts/line', 'admin.charts.line')->name('admin.charts.line');
Route::view('/admin/charts/pie', 'admin.charts.pie')->name('admin.charts.pie');


//expenses import csv
Route::resource('expenses', ExpensesController::class);
// Route::get('export-csv', [ExpensesController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [ExpensesController::class, 'importCSV'])->name('import');


//suppliers import csv
Route::resource('suppliers', SupplierController::class);
// Route::get('export-csv', [ExpensesController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [SupplierController::class, 'importCSV'])->name('import');


//categories import csv
Route::resource('categories', CategoryController::class);
// Route::get('export-csv', [ExpensesController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [CategoryController::class, 'importCSV'])->name('import');


//users import csv
Route::resource('users', UserController::class);
// Route::get('export-csv', [ExpensesController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [UserController::class, 'importCSV'])->name('import');


//product import csv
Route::resource('products', productController::class);
// Route::get('export-csv', [ExpensesController::class, 'exportCSV'])->name('export');
Route::post('import-csv', [productController::class, 'importCSV'])->name('import');