<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use Illuminate\Http\Request;

class controllerListas extends Controller
{
    public function index()
    {
        $lista = Lista::all();
        return view('listas.index', compact('lista'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Lista $lista)
    {
        //
    }

    public function edit(Lista $lista)
    {
        //
    }

    public function destroy(Lista $lista)
    {
        //
    }

    // ===== GESTIÓN PÚBLICA (Estudiante B) =====

    // Vista pública: si el token no existe, devuelve 404
    public function publica(string $token)
    {
        $lista = Lista::with(['usuario', 'items'])
            ->where('token', $token)
            ->firstOrFail();

        return view('publica.index', compact('lista'));
    }

    // Marca/desmarca un ítem (lo llama el fetch de la vista pública)
    public function update(Request $request, string $token, Item $item)
    {
        $lista = Lista::where('token', $token)->firstOrFail();

        abort_unless((int) $item->id_lista === (int) $lista->id_lista, 404);

        $data = $request->validate([
            'completado' => 'required|boolean',
        ]);

        $item->update(['completado' => $data['completado']]);

        $total = $lista->items()->count();
        $completados = $lista->items()->where('completado', true)->count();

        return response()->json([
            'ok'          => true,
            'total'       => $total,
            'completados' => $completados,
            'porcentaje'  => $total ? (int) round($completados * 100 / $total) : 0,
        ]);
    }
}