<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::get('/inventory/{page?}', [HomeController::class, 'index'])->name('inventory');
Route::post('/create', [DataController::class, "store"])->name("store");
Route::get("/login",[LoginController::class, "index"])->name("login");
Route::get("/",[HomeController::class, "index"])->name("inventory");
Route::get("/inventory/product/add",[ProductController::class, "index"])->name("add_product");
Route::get("/sale",[SaleController::class, "index"])->name("sale");