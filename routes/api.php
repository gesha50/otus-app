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

    Route::get('user-quizzes', [QuizController::class, 'userQuizzes']);
    Route::post('quizzes/{id}', [QuizController::class, 'update']);
    Route::post('quizzes/{id}/update-category', [QuizController::class, 'updateCategory']);
    Route::post('quizzes/{id}/update-is_visible', [QuizController::class, 'updateIsVisible']);

    Route::post('start-screens/{id}', [StartScreenController::class, 'update']);
    Route::post('start-screens/{id}/update-title', [StartScreenController::class, 'updateTitle']);
    Route::post('start-screens/{id}/update-description', [StartScreenController::class, 'updateDescription']);
    Route::post('start-screens/{id}/update-source', [StartScreenController::class, 'updateSource']);
    Route::post('start-screens/{id}/update-image', [StartScreenController::class, 'updateImage']);
    Route::delete('start-screens/{id}/delete-image', [StartScreenController::class, 'deleteImage']);

    Route::post('questions/{id}', [QuestionController::class, 'update']);
    Route::post('questions/{id}/update-title', [QuestionController::class, 'updateTitle']);
    Route::post('questions/{id}/update-correct_answer', [QuestionController::class, 'updateCorrectAnswer']);
    Route::post('questions/{id}/update-bonus', [QuestionController::class, 'updateBonus']);
    Route::post('questions/{id}/update-time', [QuestionController::class, 'updateTime']);
    Route::post('questions/{id}/update-image', [QuestionController::class, 'updateImage']);
    Route::delete('questions/{id}/delete-image', [QuestionController::class, 'deleteImage']);

    Route::post('answers/{id}', [AnswerController::class, 'update']);
    Route::post('answers/{id}/update-title', [AnswerController::class, 'updateTitle']);

    Route::post('results/{id}', [ResultController::class, 'update']);
    Route::post('result-details/{id}', [ResultDetailController::class, 'update']);
});

Route::post('/login', [UserController::class, 'login'] );
Route::post('/register', [UserController::class, 'register'] );



