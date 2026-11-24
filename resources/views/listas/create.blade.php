
@extends('app')

@section('contenido')

<main class="container py-4" style="max-width:700px">

    <h2 class="mb-3">Crear lista</h2>

    <form class="card card-body shadow-sm"
          action="{{ route('listas.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">Título</label>

            <input type="text"
                   name="titulo"
                   class="form-control"
                   value="{{ old('titulo') }}"
                   placeholder="Nombre de la lista"
                   required>

        </div>

        <label class="form-label">Elementos</label>

        <div id="items">

            <div class="input-group mb-2 item">

                <input type="text"
                       name="items[]"
                       class="form-control"
                       placeholder="Elemento"
                       required>

                <button type="button"
                        class="btn btn-outline-danger btn-quitar">
                    Eliminar
                </button>

            </div>

        </div>

        <button type="button"
                id="btnAgregar"
                class="btn btn-outline-primary btn-sm mb-3">
            + Agregar elemento
        </button>

        <div class="d-flex gap-2">

            <button type="submit" class="btn btn-primary">
                Guardar
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

        // Agregar elementos
        $('#btnAgregar').click(function () {

            $('#items').append(`
                <div class="input-group mb-2 item">

                    <input type="text"
                           name="items[]"
                           class="form-control"
                           placeholder="Elemento"
                           required>

                    <button type="button"
                            class="btn btn-outline-danger btn-quitar">
                        Eliminar
                    </button>

                </div>
            `);

        });

        // Eliminar elementos
        $('#items').on('click', '.btn-quitar', function () {

            if ($('.item').length > 1) {
                $(this).closest('.item').remove();
            } else {
                alert('Debe existir al menos un elemento.');
            }

        });

    });
</script>

@endsection
