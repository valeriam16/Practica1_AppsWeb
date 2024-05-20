@extends('app')
@section('titulo')
Principal
@endsection
@section('opciones')
<li class="nav-item">
    <a class="nav-link" href="/registrarForm">Registrarme</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/loginForm">Logearme</a>
</li>
@endsection

@section('contenido')
<!--Main Navigation-->
<header>
  <!-- Background image -->
  <div id="intro" class="bg-image shadow-2-strong">
    <div class="mask">
      <div class="container d-flex align-items-center justify-content-center text-center h-100">
        <div class="text-white" data-mdb-theme="dark">
          <h1 class="mb-3">Bienvenido/a a nuestra web</h1>
          <h5 class="mb-4">Por Valeria y Jonathan</h5>
          <!--
          <a class="btn btn-outline-light btn-lg m-2" data-mdb-ripple-init href="" role="button"
             rel="nofollow" target="_blank">Start tutorial</a>
          <a class="btn btn-outline-light btn-lg m-2" data-mdb-ripple-init href="https://mdbootstrap.com/docs/standard/" target="_blank"
             role="button">Download MDB UI KIT</a>
          -->
        </div>
      </div>
    </div>
  </div>
  <!-- Background image -->
</header>
@endsection
