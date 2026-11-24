
@extends('app')

@section('contenido')

<main class="container py-4" style="max-width:700px">

    <h2 class="mb-3">Editar lista</h2>

    <form class="card card-body shadow-sm"
          action="{{ route('listas.update', $lista->id_lista) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label class="form-label">Título</label>

            <input type="text"
                   name="titulo"
                   class="form-control"
                   value="{{ old('titulo', $lista->titulo) }}"
                   required>

        </div>

        <label class="form-label">Elementos actuales</label>

        <div id="items">

            @foreach ($lista->items as $item)

                <div class="input-group mb-2 item">

                    <input type="text"
                           name="items[{{ $item->id_item }}]"
                           class="form-control"
                           value="{{ $item->descripcion }}"
                           required>

                    <button type="button"
                            class="btn btn-outline-danger btn-quitar">
                        Eliminar
                    </button>

                </div>

            @endforeach

        </div>

        <label class="form-label mt-2">Nuevos elementos</label>

        <div id="nuevos"></div>

        <button type="button"
                id="btnAgregar"
                class="btn btn-outline-primary btn-sm mb-3">
            + Agregar elemento
        </button>

        <div class="d-flex gap-2">

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>

            <a href="{{ route('listas.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>

        </div>

    </form>

</main>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        // Agregar nuevos elementos
        $('#btnAgregar').click(function () {

            $('#nuevos').append(`
                <div class="input-group mb-2 item">

                    <input type="text"
                           name="nuevos[]"
                           class="form-control"
                           placeholder="Nuevo elemento"
                           required>

                    <button type="button"
                            class="btn btn-outline-danger btn-quitar">
                        Eliminar
                    </button>

                </div>
            `);

        });

        // Eliminar elementos
        $('#items, #nuevos').on('click', '.btn-quitar', function () {
            $(this).closest('.item').remove();
        });

    });
</script>

@endsection
