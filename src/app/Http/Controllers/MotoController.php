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
        $statuses = Status::pluck('name', 'id');
        return view('motos.create', compact('statuses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'modelo'     => 'required|string',
            'matricula'  => 'required|string',
            'kilometros' => 'required|integer',
            'fecha_itv'  => 'required|date',
            'status_id'  => 'required|exists:statuses,id',
            'comentarios' => 'nullable|string',
            'ubicacion'   => 'nullable|string',
        ]);

        Moto::create($request->only([
            'modelo',
            'matricula',
            'kilometros',
            'fecha_itv',
            'status_id',
            'comentarios',
            'ubicacion',
        ]));

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
            'status_id'   => 'required|exists:statuses,id',
            'comentarios' => 'nullable|string',
            'ubicacion'   => 'nullable|string',

        ]);

        $moto->update($request->only([
            'modelo',
            'matricula',
            'kilometros',
            'fecha_itv',
            'status_id',
            'comentarios',
            'ubicacion',
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
