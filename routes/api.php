<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserAnswerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// public routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// can be accessed by user or admin
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('/quiz', [QuizController::class, 'index']);
});

// only admin routes
Route::group(['middleware' => ['jwt.verify', 'admin']], function () {
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::delete('/questions/{question}', [QuestionController::class, 'index'])->missing(function () {
        return response()->json(['error' => 'Question not found.'], 404);
    });
});

// only user route
Route::group(['middleware' => ['jwt.verify', 'user']], function () {
    Route::post('/submit', [UserAnswerController::class, 'store']);
});
