<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return "success";
});

// Admin Route
Route::post("/admin/login", [AdminController::class, 'login']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'admin'
], function ($router) {
    Route::post('/', [AdminController::class, "create"]);
    Route::post("/logout", [AdminController::class, 'logout']);
    Route::post("/refresh", [AdminController::class, 'refresh']);
    Route::post("/me", [AdminController::class, 'me']);
});

// Kategori Route
Route::prefix('kategori')->group(function () {
    Route::post('/', [KategoriController::class, 'create']);
    Route::get('/', [KategoriController::class, 'findAll']);
    Route::get('/{id}/alat', [KategoriController::class, 'findKategoriAlat']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

// Pelanggan Route
Route::prefix('pelanggan')->group(function () {
    Route::post('/', [PelangganController::class, "create"]);
    Route::get('/', [PelangganController::class, "findAll"]);
    Route::get('/full', [PelangganController::class, "findAllFull"]);
    Route::get('/{id}/full', [PelangganController::class, "findOneFull"]);
    Route::put('/{id}', [PelangganController::class, "update"]);
    Route::delete('/{id}', [PelangganController::class, "destroy"]);
});


Route::prefix("alat")->group(function () {
    Route::post("/", [AlatController::class,"create"]);
    Route::get("/", [AlatController::class,"findAll"]);
    Route::put("/{id}", [AlatController::class,"update"]);
    Route::delete("/{id}", [AlatController::class,"destroy"]);
});