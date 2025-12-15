<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\HighScoreController;

// Preflight (CORS) SOLO para high-scores
Route::options('/high-scores', [HighScoreController::class, 'options']);

Route::get('/high-scores', [HighScoreController::class, 'index']);
Route::post('/high-scores', [HighScoreController::class, 'store']);

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    return response()->json([
        'message' => 'Login correcto',
        'user' => $user
    ]);
});