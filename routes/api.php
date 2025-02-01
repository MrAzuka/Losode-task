<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Business;
use App\Http\Controllers\Job;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/register', [Authentication::class, 'register']);
    Route::post('/login', [Authentication::class, 'login']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Authentication::class, 'logout']);
    Route::get('/user', [Business::class, 'showBusinessInfo']);
});

Route::prefix('v1/my/jobs')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [Job::class, 'createJob']);
    Route::get('/', [Job::class, 'getAllBusinessJobs']);
    Route::patch('/{job_id}', [Job::class, 'updateJobs']);
});
