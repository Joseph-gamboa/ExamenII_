@extends('app')

@section('contenido')

<main class="container py-5" style="max-width:600px">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="mb-0">Compras del súper</h2>
        <p class="text-muted">Lista de Juan Pérez</p>
        <div class="d-flex justify-content-between"><span id="contador">0 de 4 completados</span><span
            id="porcentaje">0%</span></div>
        <div class="progress mb-3" style="height:20px">
          <div id="barra" class="progress-bar bg-success" style="width:0%"></div>
        </div>
        <ul class="list-group mb-3" id="lista">
          <li class="list-group-item"><input class="form-check-input me-2 chk" type="checkbox" data-id="1"
              id="i1"><label for="i1">Leche</label></li>
          <li class="list-group-item"><input class="form-check-input me-2 chk" type="checkbox" data-id="2"
              id="i2"><label for="i2">Pan</label></li>
          <li class="list-group-item"><input class="form-check-input me-2 chk" type="checkbox" data-id="3"
              id="i3"><label for="i3">Huevos</label></li>
          <li class="list-group-item"><input class="form-check-input me-2 chk" type="checkbox" data-id="4"
              id="i4"><label for="i4">Café</label></li>
        </ul>
        <div id="felicitacion" class="alert alert-success text-center d-none">¡Lo lograste! Has completado todos los
          elementos de tu lista</div>
      </div>
    </div>
  </main>
@endsection