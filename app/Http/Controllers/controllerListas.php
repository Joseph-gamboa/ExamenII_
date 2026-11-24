<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class controllerListas extends Controller
{
    // Mostrar las listas del usuario autenticado
    public function index()
    {
        $lista = Lista::all();

        return view('listas.index', compact('lista'));
    }

    // Mostrar formulario para crear una lista
    public function create()
    {
        return view('listas.create');
    }

    // Guardar lista y sus ítems
    public function store(Request $request)
    {
        $request->validate([
            'titulo'  => 'required|string|max:200',
            'items'   => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            // Generar token único de 20 caracteres
            do {
                $token = Str::random(20);
            } while (Lista::where('token', $token)->exists());

            // Crear la lista
            $lista = Lista::create([
                'id_usuario' => 1,
                'titulo' => $request->titulo,
                'token' => $token
            ]);

            // Guardar los ítems
            foreach ($request->items as $descripcion) {
                $lista->items()->create([
                    'descripcion' => $descripcion,
                    'completado' => false
                ]);
            }
        });

        return redirect()->route('listas.index')
            ->with('ok', 'Lista creada correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $lista = Lista::with('items')->findOrFail($id);

        return view('listas.edit', compact('lista'));
    }

    // Actualizar lista e ítems
    public function actualizar(Request $request, Lista $lista)
    {
        $request->validate([
            'titulo'   => 'required|string|max:200',
            'items'    => 'nullable|array',
            'items.*'  => 'required|string|max:255',
            'nuevos'   => 'nullable|array',
            'nuevos.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $lista) {

            // Actualizar título
            $lista->update([
                'titulo' => $request->titulo
            ]);

            $existentes = $request->input('items', []);

            // Eliminar ítems quitados
            $lista->items()
                ->whereNotIn('id_item', array_keys($existentes))
                ->delete();

            // Actualizar ítems existentes
            foreach ($existentes as $idItem => $descripcion) {
                $lista->items()
                    ->where('id_item', $idItem)
                    ->update([
                        'descripcion' => $descripcion
                    ]);
            }

            // Agregar ítems nuevos
            foreach ($request->input('nuevos', []) as $descripcion) {
                $lista->items()->create([
                    'descripcion' => $descripcion,
                    'completado' => false
                ]);
            }
        });

        return redirect()->route('listas.index')
            ->with('ok', 'Lista actualizada correctamente.');
    }

    // Eliminar lista
    public function destroy(Lista $lista)
    {
        $lista->delete();

        return redirect()->route('listas.index')
            ->with('ok', 'Lista eliminada correctamente.');
    }

    // ===== GESTIÓN PÚBLICA =====

    // Mostrar lista pública
    public function publica(string $token)
{
    $lista = Lista::with(['usuario', 'items'])
        ->where('token', $token)
        ->first();

    if (!$lista) {
        abort(404, 'La lista no existe o el token no es válido.');
    }

    return view('publica.index', compact('lista'));
}

    // Marcar o desmarcar un ítem
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
            'porcentaje' => $total
                ? (int) round($completados * 100 / $total)
                : 0,
        ]);
    }
}