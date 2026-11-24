
@extends('app')

@section('contenido')

<main class="container py-4">

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Editar lista</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('listas.update', $lista->id_lista) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Título de la lista</label>

                    <input type="text"
                           name="titulo"
                           class="form-control"
                           value="{{ old('titulo', $lista->titulo) }}"
                           required>
                    
                    @error('titulo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="{{ route('listas.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>
    </div>

</main>

@endsection
