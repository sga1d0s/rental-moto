<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\ReservaController;
use App\Models\Status;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->route('login')->with('error', 'Credenciales inválidas');
    }

    session(['user_id' => $user->id]);
    return redirect('/');
});

Route::post('/logout', function () {
    session()->forget('user_id');
    return redirect('/login');
})->name('logout');


// Grupo protegido con middleware personalizado
Route::middleware('auth.blade')->group(function () {

    // Rutas para motos: usa el controlador completo
    Route::resource('motos', MotoController::class)->except(['show']);

    // Rutas para reservas: ya usas controller, bien así
    Route::resource('reservas', ReservaController::class)->except(['show'])->names([
        'index'   => 'reservas.index',
        'create'  => 'reservas.create',
        'store'   => 'reservas.store',
        'edit'    => 'reservas.edit',
        'update'  => 'reservas.update',
        'destroy' => 'reservas.destroy',
    ]);
});