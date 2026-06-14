<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'texto'     => 'required|string|max:500',
            'prioridad' => 'required|in:urgente,general',
        ]);

        Aviso::create($request->only('texto', 'prioridad'));

        return redirect()->route('home');
    }

    public function completar(Aviso $aviso)
    {
        $aviso->update(['completado' => true]);

        return redirect()->route('home');
    }

    public function desmarcar(Aviso $aviso)
    {
        $aviso->update(['completado' => false]);

        return redirect()->route('home');
    }

    public function destroy(Aviso $aviso)
    {
        $aviso->delete();

        return redirect()->route('home');
    }
}
