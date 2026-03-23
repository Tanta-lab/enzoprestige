<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCatalogController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'ordersCount' => Order::count(),
        ]);
    })->name('home');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index','show']);});

Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');

Route::get('/products/{product}', [ProductCatalogController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
