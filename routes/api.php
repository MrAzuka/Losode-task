<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Business;
use App\Http\Controllers\Guest;
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
    Route::get('/{job_id}/applications', [Job::class, 'getJobApplication']);
    Route::patch('/{job_id}', [Job::class, 'updateJobs']);
    Route::delete('/{job_id}', [Job::class, 'deleteJob']);
});
Route::prefix('v1/jobs')->group(function () {
    Route::get('/', [Guest::class, 'getAllJobs']);
    Route::get('/{job_id}', [Guest::class, 'getSpecificJob']);
    Route::post('/{job_id}/apply', [Guest::class, 'applyForJobs']);
});
