<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin CRUD API via Sanctum (Protected, but open for postman via basic auth optionally or just sanctum token)
// For demonstration and ease of testing, you can attach auth:sanctum
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('posts', \App\Http\Controllers\Api\Admin\PostController::class);
    Route::apiResource('categories', \App\Http\Controllers\Api\Admin\CategoryController::class);
    
    Route::post('/upload-image', function (Illuminate\Http\Request $request, \App\Services\ImageService $imgService) {
        $request->validate(['image' => 'required|image|max:5120']);
        $result = $imgService->uploadToWebp($request->file('image'));
        return response()->json($result);
    });
});

Route::match(['get', 'post'], '/track/click', [\App\Http\Controllers\Api\ClickTrackingController::class, 'track'])
    ->middleware('throttle:60,1'); // 60 requests per minute

// Legacy endpoint (keep for backward compat)
Route::post('/tracking/events', [\App\Http\Controllers\Api\TrackingController::class, 'logEvent']);
