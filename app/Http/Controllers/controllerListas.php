<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // Muestra el formulario con el título y los ítems actuales
    public function edit($id)
    {
     $lista = Lista::findOrFail($id);

    return view('listas.edit', compact('lista'));
    }

    // Guarda el título, actualiza ítems existentes, borra los quitados y crea los nuevos
    public function update(Request $request, Lista $lista)
    {
        $request->validate([
            'titulo'    => 'required|string|max:200',
            'items'     => 'nullable|array',
            'items.*'   => 'required|string|max:255',
            'nuevos'    => 'nullable|array',
            'nuevos.*'  => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $lista) {
            $lista->update(['titulo' => $request->titulo]);

            $existentes = $request->input('items', []);

            // Ítems que ya no vienen en el formulario = fueron eliminados
            $lista->items()->whereNotIn('id_item', array_keys($existentes))->delete();

            // Ítems existentes (conservan su estado de completado)
            foreach ($existentes as $idItem => $descripcion) {
                $lista->items()->where('id_item', $idItem)->update(['descripcion' => $descripcion]);
            }

            // Ítems nuevos
            foreach ($request->input('nuevos', []) as $descripcion) {
                $lista->items()->create(['descripcion' => $descripcion, 'completado' => false]);
            }
        });

        return redirect()->route('listas.index')->with('ok', 'Lista actualizada correctamente.');
    }

    // Elimina la lista (los ítems se borran solos por ON DELETE CASCADE)
    public function destroy(Lista $lista)
    {
        $lista->delete();

        return redirect()->route('listas.index')->with('ok', 'Lista eliminada correctamente.');
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
}