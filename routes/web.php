<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\Car\CarFuelController;
use App\Http\Controllers\Car\CarReviewController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtDetailController;
use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

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

Route::post('/agents/{agent}/restore', [AgentController::class, 'restore'])->name('agents.restore');
Route::resource('/agents', AgentController::class)->except('edit');
Route::resource('/phones', PhoneController::class)->except('edit');

Route::resource('/debts', DebtController::class)->except('edit');

// Route::resource('/debts/{debt}/details', DebtDetailController::class)->except('edit');
Route::get('/debts/{debt}/details', [DebtDetailController::class, 'index']);
Route::get('/debts/{debt}/details/create', [DebtDetailController::class, 'create']);
Route::get('/debts/{debt}/details/{debtDetail}', [DebtDetailController::class, 'show']);
Route::patch('/debts/{debt}/details/{debtDetail}', [DebtDetailController::class, 'update']);
Route::post('/debts/{debt}/details', [DebtDetailController::class, 'store']);

Route::resource('/cars', CarController::class)->except('edit');

Route::get('/cars/{car}/fuel', [CarFuelController::class, 'index'])->name('fuel.index');
Route::get('/cars/{car}/fuel/create', [CarFuelController::class, 'create'])->name('fuel.create');
Route::post('/cars/{car}/fuel', [CarFuelController::class, 'store'])->name('fuel.store');
Route::get('/cars/{car}/fuel/{fuel}', [CarFuelController::class, 'show'])->name('fuel.show');
Route::patch('/cars/{car}/fuel/{fuel}', [CarFuelController::class, 'update'])->name('fuel.update');
Route::delete('/cars/{car}/fuel/{fuel}', [CarFuelController::class, 'destroy'])->name('fuel.destroy');

Route::get('/cars/{car}/review', [CarReviewController::class, 'index'])->name('review.index');
Route::get('/cars/{car}/review/create', [CarReviewController::class, 'create'])->name('review.create');
Route::get('/cars/{car}/review/{carReview}', [CarReviewController::class, 'show'])->name('review.show');
Route::post('/cars/{car}/review', [CarReviewController::class, 'store'])->name('review.store');
Route::patch('/cars/{car}/review/{carReview}', [CarReviewController::class, 'update'])->name('review.update');
