<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Note;
use App\Http\Controllers\NoteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
      Route::get('logout', [AuthController::class, 'logout']);
      Route::get('user', [AuthController::class, 'user']);

      
    });
});

Route::get('notes/{user_id}', [NoteController::class, 'list']);
Route::get('sharednotes', [NoteController::class, 'listshared']);

Route::group(['prefix' => 'note'], function () {
    Route::get('/{id}', [NoteController::class, 'get']);
    Route::put('/update/{id}', [NoteController::class, 'update']);
    Route::post('/add', [NoteController::class, 'store']);
    Route::get('/show/{id}/{secret_key}', [NoteController::class, 'show']);
    Route::delete('/{id}', [NoteController::class, 'delete']);
});
