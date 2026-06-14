<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\HomeController;
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
    return redirect()->route('home');
});

Route::post('/logout', function () {
    session()->forget('user_id');
    return redirect('/login');
})->name('logout');


// Grupo protegido con middleware personalizado
Route::middleware('auth.blade')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/avisos', [AvisoController::class, 'store'])->name('avisos.store');
    Route::patch('/avisos/{aviso}/completar', [AvisoController::class, 'completar'])->name('avisos.completar');
    Route::patch('/avisos/{aviso}/desmarcar', [AvisoController::class, 'desmarcar'])->name('avisos.desmarcar');
    Route::delete('/avisos/{aviso}', [AvisoController::class, 'destroy'])->name('avisos.destroy');

    // Ruta para el modal (más específica) — declarar ANTES del resource
    Route::get('/motos/{moto}/partial', [MotoController::class, 'partial'])->name('motos.partial');

    // Rutas para motos: usa el controlador completo
    Route::resource('motos', MotoController::class);

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
