<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\{AuthController,MeController};
use App\Http\Controllers\Api\V1\Tournament\{TournamentController,RegistrationController};
use App\Http\Controllers\Api\V1\Player\PlayerController;
use App\Http\Controllers\Api\V1\Admin\{DashboardController, TournamentController as AdminTournamentController};
Route::prefix('v1')->group(function () {
	Route::post('auth/register', [AuthController::class, 'register']);
	Route::post('auth/login', [AuthController::class, 'login']);
	Route::get('tournaments', [TournamentController::class, 'index']);
	Route::get('tournaments/{tournament}', [TournamentController::class, 'show']);
	Route::get('players', [PlayerController::class, 'index']);
	Route::get('players/{user}', [PlayerController::class, 'show']);

	Route::middleware(['auth:sanctum'])->group(function () {
		Route::get('auth/me', [MeController::class, 'show']);
		Route::patch('auth/me', [MeController::class, 'update']);
		Route::post('auth/logout', [AuthController::class, 'logout']);
		Route::post('auth/logout-all', [AuthController::class, 'logoutAll']);

		Route::middleware('role:organizer,admin')->group(function () {
			Route::post('tournaments', [TournamentController::class, 'store']);
			Route::put('tournaments/{tournament}', [TournamentController::class, 'update']);
			Route::delete('tournaments/{tournament}', [TournamentController::class, 'destroy']);
		});

		Route::middleware('role:player')->post('tournaments/{tournament}/registrations', [RegistrationController::class, 'store']);
		Route::middleware('role:organizer,admin')->group(function () {
			Route::get('tournaments/{tournament}/registrations', [RegistrationController::class, 'index']);
			Route::patch('registrations/{registration}', [RegistrationController::class, 'update']);
		});
		Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy']);

		Route::middleware('role:admin')->prefix('admin')->group(function () {
			Route::get('dashboard', [DashboardController::class, 'index']);
			Route::get('tournaments/pending', [AdminTournamentController::class, 'pending']);
			Route::patch('tournaments/{tournament}/approve', [AdminTournamentController::class, 'approve']);
			Route::patch('tournaments/{tournament}/reject', [AdminTournamentController::class, 'reject']);
		});
	});
});
