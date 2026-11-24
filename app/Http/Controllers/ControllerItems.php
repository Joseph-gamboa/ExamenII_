<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use Illuminate\Http\Request;

class ControllerItems extends Controller
{
     public function update(Request $request, string $token, Item $item)
{
    $lista = Lista::where('token', $token)->firstOrFail();

    abort_unless((int) $item->id_lista === (int) $lista->id_lista, 404);

    $data = $request->validate([
        'completado' => 'required|boolean',
    ]);

    $item->update([
        'completado' => $data['completado']
    ]);

    $total = $lista->items()->count();

    $completados = $lista->items()
        ->where('completado', true)
        ->count();

    return response()->json([
        'ok' => true,
        'total' => $total,
        'completados' => $completados,
        'porcentaje' => $total ? (int) round($completados * 100 / $total) : 0,
    ]);
}
}