<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SpeakerAuthController;
use App\Http\Controllers\TalkProposalController;

use App\Http\Controllers\ReviewerAuthController;
use App\Http\Controllers\ReviewerController;


// Root URL: redirect to login if not authenticated, otherwise go to dashboard
Route::get('/', function () {
    if (Auth::guard('speaker')->check()) {
        return redirect()->route('speaker.dashboard');
    }
    return redirect()->route('speaker.login');
});

// Speaker login, register, logout, and dashboard routes
Route::get('/speaker/login', [SpeakerAuthController::class, 'showLoginForm'])
    ->middleware('auth.speaker')
    ->name('speaker.login');

Route::post('/speaker/login', [SpeakerAuthController::class, 'login'])
    ->name('speaker.login.post');

Route::get('/speaker/register', [SpeakerAuthController::class, 'showRegisterForm'])
    ->middleware('auth.speaker')
    ->name('speaker.register');

Route::post('/speaker/register', [SpeakerAuthController::class, 'register'])
    ->name('speaker.register.post');

Route::post('/speaker/logout', [SpeakerAuthController::class, 'logout'])
    ->name('speaker.logout');


Route::middleware('auth:speaker')->group(function () {
    Route::resource('talk-proposals', TalkProposalController::class);
    Route::get('/speaker/dashboard', function () {
        return view('speakers.dashboard');
    })->name('speaker.dashboard');
});



Route::prefix('reviewer')->group(function () {

    // Reviewer Authentication Routes
    Route::get('/login', [ReviewerAuthController::class, 'showLoginForm'])->name('reviewer.login');
    Route::post('/login', [ReviewerAuthController::class, 'login'])->name('reviewer.login.post');
    Route::post('/logout', [ReviewerAuthController::class, 'logout'])->name('reviewer.logout');


    
    // Protected Reviewer Routes - Only accessible when logged in as a reviewer
    Route::middleware('auth:reviewer')->group(function () {
        Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('reviewer.dashboard');

         Route::post('/talk-proposals/{id}/review', [ReviewerController::class, 'storeReview'])->name('reviewer.talk-proposals.review');
     });
});

