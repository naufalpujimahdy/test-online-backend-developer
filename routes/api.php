<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ChecklistController;
use App\Http\Controllers\API\V1\ChecklistItemController;
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
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });
    /********* Checklist *********/
    Route::get('checklists', [ChecklistController::class, 'index']);
    Route::post('checklists', [ChecklistController::class, 'store']);
    Route::get('checklists/{id}', [ChecklistController::class, 'show']);
    Route::put('checklists/{id}', [ChecklistController::class, 'update']);
    Route::delete('checklists/{id}', [ChecklistController::class, 'destroy']);

    /********* Checklist Item *********/
    Route::post('checklists/{checklistId}/items', [ChecklistItemController::class, 'store']);
    Route::get('checklists/{checklistId}/items/{itemId}', [ChecklistItemController::class, 'show']);
    Route::put('checklists/{checklistId}/items/{itemId}', [ChecklistItemController::class, 'update']);
    Route::delete('checklists/{checklistId}/items/{itemId}', [ChecklistItemController::class, 'destroy']);
    Route::put('checklists/{checklistId}/items/{itemId}/complete', [ChecklistItemController::class, 'complete']);
    Route::put('checklists/{checklistId}/items/{itemId}/incomplete', [ChecklistItemController::class, 'incomplete']);
});
