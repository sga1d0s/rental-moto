<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use Illuminate\Http\Request;
use App\Models\Status;

class MotoController extends Controller
{
    public function index()
    {
        $motos = Moto::all();
        return view('home', compact('motos'));
    }

    public function create()
    {
        return view('motos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo'     => 'required|string',
            'matricula'  => 'required|string',
            'kilometros' => 'required|integer',
            'fecha_itv'  => 'required|date',
            'estado'     => 'required|in:Libre,Ocupada,Reservada,Averiada,Otros',
            'comentarios' => 'nullable|string',
        ]);

        Moto::create($request->all());

        return redirect()->route('motos.index');
    }

    /**
     * Muestra el formulario de edición para una moto.
     */
    public function edit(Moto $moto)
    {
        // Para el <select> de estados
        $statuses = Status::pluck('name', 'id');
        return view('motos.edit', compact('moto', 'statuses'));
    }

    /**
     * Actualiza la moto en BD.
     */
    public function update(Request $request, Moto $moto)
    {
        $request->validate([
            'modelo'      => 'required|string',
            'matricula'   => 'required|string',
            'kilometros'  => 'required|integer',
            'fecha_itv'   => 'required|date',
            'comentarios' => 'nullable|string',
            'status_id'   => 'required|exists:statuses,id',
        ]);

        $moto->update($request->only([
            'modelo',
            'matricula',
            'kilometros',
            'fecha_itv',
            'comentarios',
            'status_id'
        ]));

        return redirect()->route('motos.index')
            ->with('success', 'Moto actualizada correctamente.');
    }

    /**
     * Elimina una moto y redirige al listado.
     */
    public function destroy(Moto $moto)
    {
        $moto->delete();
        return redirect()->route('motos.index');
    }
}
