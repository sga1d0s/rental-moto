<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Moto;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Reservas SIN moto asignada
        $reservasSinMoto = Reserva::with('moto')
            ->whereNull('moto_id')
            ->orderBy('fecha_desde')
            ->get();

        // Reservas CON moto asignada
        $reservasConMoto = Reserva::with('moto')
            ->whereNotNull('moto_id')
            ->orderBy('fecha_desde')
            ->get();

        return view('reservas.index', compact('reservasSinMoto', 'reservasConMoto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Todas las motos (las reservadas se podrán elegir; validaremos solapes al guardar)
    $motos = Moto::orderBy('modelo')->pluck('modelo', 'id');

    return view('reservas.create', compact('motos'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'moto_id'     => ['nullable', 'exists:motos,id'],
        'cliente'     => ['nullable', 'string', 'max:255'],
        'fecha_desde' => ['required', 'date'],
        'fecha_hasta' => ['required', 'date', 'after_or_equal:fecha_desde'],
    ]);

    // Regla post-validación: si hay moto elegida, comprobar solape
    $validator->after(function ($v) use ($request) {
        $motoId = $request->input('moto_id');
        if ($motoId) {
            $desde = Carbon::parse($request->input('fecha_desde'))->toDateString();
            $hasta = Carbon::parse($request->input('fecha_hasta'))->toDateString();

            if ($this->haySolape((int)$motoId, $desde, $hasta, null)) {
                $v->errors()->add('moto_id', 'La moto seleccionada está ocupada en ese rango de fechas.');
            }
        }
    });

    $validator->validate();

    Reserva::create($validator->validated());

    return redirect()->route('reservas.index')
        ->with('success', 'Reserva creada correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
{
    $motos = Moto::orderBy('modelo')->pluck('modelo', 'id');
    return view('reservas.edit', compact('reserva', 'motos'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
{
    $validator = Validator::make($request->all(), [
        'moto_id'     => ['nullable', 'exists:motos,id'],
        'cliente'     => ['nullable', 'string', 'max:255'],
        'fecha_desde' => ['required', 'date'],
        'fecha_hasta' => ['required', 'date', 'after_or_equal:fecha_desde'],
    ]);

    $validator->after(function ($v) use ($request, $reserva) {
        $motoId = $request->input('moto_id');
        if ($motoId) {
            $desde = Carbon::parse($request->input('fecha_desde'))->toDateString();
            $hasta = Carbon::parse($request->input('fecha_hasta'))->toDateString();

            if ($this->haySolape((int)$motoId, $desde, $hasta, $reserva->id)) {
                $v->errors()->add('moto_id', 'La moto seleccionada está ocupada en ese rango de fechas.');
            }
        }
    });

    $validator->validate();

    $reserva->update($validator->validated());

    return redirect()->route('reservas.index')
        ->with('success', 'Reserva actualizada correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada.');
    }

    private function haySolape(int $motoId, string $desde, string $hasta, ?int $ignorarId = null): bool
{
    // Trata fecha_hasta NULL como "abierta" (muy en el futuro)
    return Reserva::where('moto_id', $motoId)
        ->when($ignorarId, fn($q) => $q->where('id', '!=', $ignorarId))
        // Solape con bordes INCLUSIVOS:
        // existing.desde <= nueva.hasta  AND  COALESCE(existing.hasta,'9999-12-31') >= nueva.desde
        ->whereDate('fecha_desde', '<=', $hasta)
        ->whereRaw("COALESCE(fecha_hasta, '9999-12-31') >= ?", [$desde])
        ->exists();
}
}
