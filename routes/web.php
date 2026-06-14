<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ManageTeamController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\ParticipationController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

// Valodas
Route::get('/lang/{locale}', function ($locale) {
    // Pārbaudām, vai valoda ir viena no atļautajām
    if (in_array($locale, ['lv', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

// neregistreta lietotaja maršruti
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Role-specific registration routes
    Route::get('/register/player', [RegisteredUserController::class, 'createPlayer'])->name('register.player');
    Route::post('/register/player', [RegisteredUserController::class, 'storePlayer'])->name('register.player.store');

    Route::get('/register/coach', [RegisteredUserController::class, 'createCoach'])->name('register.coach');
    Route::post('/register/coach', [RegisteredUserController::class, 'storeCoach'])->name('register.coach.store');
});

// Payment routi
Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/checkout', [StripeController::class, 'checkout']); // Route for initiating checkout
Route::get('/payment/success/{paymentId}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [StripeController::class, 'cancel'])->name('payment.cancel'); // Route for cancel page

Route::post('/payment/checkout/{paymentId}', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

// piedalīšanās treniņiem
Route::get('/participate/{practice}/{user}', [ParticipationController::class, 'status']);
Route::post('/participate/{practice}/{user}/update', [ParticipationController::class, 'update']);
Route::get('/practice/{id}/participants', [PracticeController::class, 'participants'])->name('practice.participants');

Route::delete('/team/remove-member/{id}', [ManageTeamController::class, 'removeMember'])->name('team.removeMember');

// Authenticated Routes ar login
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        \Log::info('User Role:', ['role' => $user->role]);

        //  0 = Treneris, 1 = Spēlētājs
        if ($user->role == 0) { 
            return view('dashboard.coach-dashboard');
        } elseif ($user->role == 1) { 
            return view('dashboard.player-dashboard');
        } else {
            return abort(403, 'Unauthorized Role');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Trenera
    Route::prefix('coach')->group(function () {
        Route::get('/payments', [PaymentController::class, 'coachIndex'])->name('coach.payments');
        Route::post('/payments', [PaymentController::class, 'store'])->name('coach.payments.store');
    });

    // Speletaja
    Route::get('/player/payments', [PaymentController::class, 'playerIndex'])->name('player.payments');
    Route::get('/payment/pay/{payment}', [PaymentController::class, 'showPaymentPage'])->name('payment.pay');

    Route::get('/manage-team', [ManageTeamController::class, 'index']);
    
    // Treniņu maršruti
    Route::get('/practices', [PracticeController::class, 'index'])->name('practices.index');
    Route::get('/practices/create', [PracticeController::class, 'create'])->name('practices.create');
    Route::post('/practices', [PracticeController::class, 'store'])->name('practices.store');
    Route::delete('/practices/{id}', [PracticeController::class, 'destroy'])->name('practices.destroy');
    
    // Skatīt konkrētu treniņu
    Route::get('/practices/{practice}', [PracticeController::class, 'show'])->name('practices.show');
});

// Include additional default Laravel auth routes
require __DIR__.'/auth.php';