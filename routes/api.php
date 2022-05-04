<?php

use App\Http\Controllers\api\v1\AnswerController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\QuestionController;
use App\Http\Controllers\api\v1\QuizController;
use App\Http\Controllers\api\v1\ResultController;
use App\Http\Controllers\api\v1\ResultDetailController;
use App\Http\Controllers\api\v1\StartScreenController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/test', function () {
        return [
            'data' => 'api works!',
            'success' => true
        ];
    });

    Route::apiResources([
        'categories' => CategoryController::class,
        'quizzes' => QuizController::class,
        'answers' => AnswerController::class,
        'questions' => QuestionController::class,
        'results' => ResultController::class,
        'result-details' => ResultDetailController::class,
        'start-screens' => StartScreenController::class,
    ]);

    Route::post('categories/{id}', [CategoryController::class, 'update']);
    Route::post('quizzes/{id}', [QuizController::class, 'update']);
    Route::post('start-screens/{id}', [StartScreenController::class, 'update']);
    Route::post('questions/{id}', [StartScreenController::class, 'update']);


});

Route::post('/login', [UserController::class, 'login'] );
Route::post('/register', [UserController::class, 'register'] );



