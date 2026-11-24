@extends('app')

@section('contenido')
    <main class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Mis listas</h2><a href="create.html" class="btn btn-primary">+ Nueva lista</a>
        </div>
        <table class="table table-striped bg-white shadow-sm align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Token</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $l)
                    <tr>
                        <td>{{ $l->id_lista }}</td>
                        <td>{{ $l->titulo }}</td>
                        <td><code>{{ $l->token }}</code></td>
                        <td class="text-end">
                            <a href="{{ route('publica.index', $l->token) }}" target="_blank"
                                class="btn btn-sm btn-info">Ver pública</a>
                            <a href="https://wa.me/?text={{ urlencode(url($l->token)) }}" target="_blank"
                                class="btn btn-sm btn-success">WhatsApp</a>
                            <a href="edit.html" class="btn btn-sm btn-warning">Editar</a>
                            <form class="d-inline form-eliminar"><button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection