<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AccountSettingController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\CommentsController;
use App\Http\Controllers\API\FilesController;


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
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate'])->name('login');
Route::post('logout', [RegisterController::class,'logout'])->name('logout');



    Route::group(['middleware' => ['jwt.verify']], function() {

    // Projects
    Route::post('add-project',[ProjectsController::class, 'store']);
    Route::get('get-project', [ProjectsController::class, 'index']);
    Route::get('get-project/{id}', [ProjectsController::class, 'getProjectById']);
    Route::put('update-project/{id}', [ProjectsController::class, 'update']);
    Route::delete('delete-project/{id}', [ProjectsController::class, 'destroy']);
    Route::put('change-project-status/{id}', [ProjectsController::class, 'changeProjectStatus']);

    // Comments
    Route::post('add-comment',[CommentsController::class, 'store']);
    Route::get('get-comment', [CommentsController::class, 'index']);
    // Route::get('get-comment/{id}', [CommentsController::class, 'getcommentById']);
    Route::get('get-comment-by-project-id/{id}', [CommentsController::class, 'getCommentByProjectId']);
    // Route::put('update-comment/{id}', [CommentsController::class, 'update']);
    Route::delete('delete-comment/{id}', [CommentsController::class, 'destroy']);

    // Files
    Route::post('add-file',[FilesController::class, 'store']);
});