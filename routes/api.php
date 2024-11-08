<?php

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

use App\Http\Controllers\AuthController;


use App\Http\Controllers\Api\ReviewerController;
use App\Http\Controllers\Api\TalkProposalController;


Route::get('/reviewers', [ReviewerController::class, 'index']);  // List all reviewers
Route::get('/talk-proposals/{id}/reviews', [TalkProposalController::class, 'getReviews']);  // Get reviews for a specific talk proposal
Route::get('/talk-proposals/statistics', [TalkProposalController::class, 'getStatistics']);  // Get statistics about talk proposals
