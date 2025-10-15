<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportVontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;

Route::middleware("guest")->group(function () {

    Route::get("/login",[LoginController::class, "index"])->name("login");

    Route::post("/login",[AuthController::class, "login"])->name("login");

    Route::get("/create-user",[AuthController::class, "showCreateForm"])->name("login");

    Route::post('/users', [AuthController::class, 'store'])->name('users.store');

    Route::get('/test', [ProductController::class, 'test']);
});

Route::middleware('auth')->group(function () {

    Route::get('/inventory/{page?}', [HomeController::class, 'index'])->name('inventory');

    Route::post('/create', [DataController::class, "store"])->name("store");

    Route::get("/",[HomeController::class, "index"])->name("inventory");

    Route::get("/inventory/product/add",[ProductController::class, "index"])->name("add_product");

    Route::post("/inventory/product/add",[ProductController::class, "store"])->name("product.store");

    Route::get("/inventory/product/{code}/edit",[ProductController::class, "edit"])->name("edit_product");

    Route::put("/inventory/product/{code}/update",[ProductController::class, "update"])->name("update_product");

    Route::post('/sale/invoice-preview', [InvoiceController::class, 'storeSession'])->name('invoice-preview');
    
    Route::get('/sale/invoice-preview', [InvoiceController::class, 'index']);


    Route::get("/sale/{page?}",[SaleController::class, "index"])->name("sale");

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');

    Route::get('/report', [ReportVontroller::class, 'index'])->name("report");

    Route::put('/profile/infomation', [AuthController::class, "update"])->name("update_user");

    Route::put("/profile/password", [AuthController::class, "updatePassword"])->name("update_password");

    Route::put("/profile/image-change", [AuthController::class, "update_profile"])->name("change_user_image_url");

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});