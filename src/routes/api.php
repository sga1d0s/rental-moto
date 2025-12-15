<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\HighScoreController;

// High scores (CORS only for the game endpoints)
Route::middleware(function (Request $request, $next) {
    $response = $next($request);

    // Adjust this origin if you later serve the game from a different domain/port
    $origin = $request->headers->get('Origin');
    $allowedOrigins = [
        'http://192.168.1.96:5180',
    ];

    if ($origin && in_array($origin, $allowedOrigins, true)) {
        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Vary', 'Origin');
    }

    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    return $response;
})->group(function () {
    // Preflight
    Route::options('/high-scores', fn () => response('', 204));

    Route::get('/high-scores', [HighScoreController::class, 'index']);
    Route::post('/high-scores', [HighScoreController::class, 'store']);
});

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