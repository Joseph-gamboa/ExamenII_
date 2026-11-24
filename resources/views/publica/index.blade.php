
@extends('app')

@section('contenido')

<main class="container py-5" style="max-width:600px">

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-0">{{ $lista->titulo }}</h2>

            <p class="text-muted">
                Lista de {{ $lista->usuario->nombre }}
            </p>

            @php
                $total = $lista->items->count();
                $completados = $lista->items->where('completado', true)->count();
                $porcentaje = $total > 0 ? round($completados * 100 / $total) : 0;
            @endphp

            <div class="d-flex justify-content-between">
                <span id="contador">
                    {{ $completados }} de {{ $total }} completados
                </span>

                <span id="porcentaje">{{ $porcentaje }}%</span>
            </div>

            <div class="progress mb-3" style="height:20px">
                <div id="barra"
                     class="progress-bar bg-success"
                     role="progressbar"
                     style="width: {{ $porcentaje }}%">
                </div>
            </div>

            <ul class="list-group mb-3" id="lista">

                @forelse ($lista->items as $item)

                    <li class="list-group-item">

                        <input
                            class="form-check-input me-2 chk"
                            type="checkbox"
                            data-id="{{ $item->id_item }}"
                            id="item{{ $item->id_item }}"
                            {{ $item->completado ? 'checked' : '' }}
                        >

                        <label for="item{{ $item->id_item }}">
                            {{ $item->descripcion }}
                        </label>

                    </li>

                @empty

                    <li class="list-group-item text-muted">
                        Esta lista todavía no tiene elementos.
                    </li>

                @endforelse

            </ul>

            <div id="felicitacion"
                 class="alert alert-success text-center {{ $total > 0 && $completados == $total ? '' : 'd-none' }}">

                ¡Lo lograste! Has completado todos los elementos de tu lista.

            </div>

        </div>
    </div>

</main>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.querySelectorAll('.chk').forEach(function(check) {

        check.addEventListener('change', function() {

            let checkbox = this;
            let id = checkbox.dataset.id;

            fetch("{{ route('lista.items.update', [$lista->token, '__ITEM__']) }}".replace('__ITEM__', id), {
                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },

                body: JSON.stringify({
                    completado: checkbox.checked ? 1 : 0
                })
            })

            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo actualizar el elemento');
                }

                return response.json();
            })

            .then(data => {

                document.getElementById('contador').textContent =
                    data.completados + ' de ' + data.total + ' completados';

                document.getElementById('porcentaje').textContent =
                    data.porcentaje + '%';

                document.getElementById('barra').style.width =
                    data.porcentaje + '%';

                document.getElementById('barra').setAttribute(
                    'aria-valuenow', data.porcentaje
                );

                if (data.total > 0 && data.completados == data.total) {
                    document.getElementById('felicitacion').classList.remove('d-none');
                } else {
                    document.getElementById('felicitacion').classList.add('d-none');
                }

            })

            .catch(error => {

                checkbox.checked = !checkbox.checked;

                alert('Error al actualizar el elemento.');

                console.error(error);

            });

        });

    });
</script>

@endsection
