@extends('app')
@section('titulo')
Dashboard
@endsection
@section('opciones')
<li class="nav-item">
    <a class="nav-link" href="/auth">Mi perfil</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/logout">Cerrar Sesión</a>
</li>
@endsection

@section('contenido')
<div class="container-fluid px-5 py-5 vh-200">
    @if (session('message'))
    <div id="message-alert" class="alert alert-success">
        {{ session('message') }}
    </div>
    <script>
        // Ocultar el mensaje de alerta después de 3 segundos
        setTimeout(function() {
            document.getElementById('message-alert').style.display = 'none';
        }, 3000);
    </script>
    @endif
    @if (session('error'))
    <div id="error-alert" class="alert alert-danger">
        {{ session('error') }}
    </div>
    <script>
        // Ocultar el mensaje de error después de 3 segundos
        setTimeout(function() {
            document.getElementById('error-alert').style.display = 'none';
        }, 3000);
    </script>
    @endif
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Nombre</th>
                <th class="text-center">Edad</th>
                <th class="text-center">Fecha de nacimiento</th>
                <th class="text-center">Status</th>
                <th class="text-center">Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img class="ms-2" src="https://www.hotelbooqi.com/wp-content/uploads/2021/12/128-1280406_view-user-icon-png-user-circle-icon-png.png" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                        <div class="ms-4">
                            <p class="fw-bold mb-1">{{ $user->name }} {{ $user->lastname_p }} {{ $user->lastname_m }}</p>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                            <p class="text-muted mb-0">{{ $user->phone }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1 text-center">{{ $user->age }}</p>
                </td>
                <td>
                    <p class="fw-normal mb-1 text-center">{{ $user->birthdate }}</p>
                </td>
                <td class="text-center">
                    <span class="badge rounded-pill text-bg-{{ $user->active ? 'success' : 'danger' }}">{{ $user->active ? 'Activo' : 'Inactivo' }}</span>
                </td>
                <!-- <td class="text-center">
                    <button type="submit" class="btn btn-link btn-sm btn-rounded">
                        <a href="/update">
                            <img src="https://cdn-icons-png.flaticon.com/512/5996/5996831.png" alt="Editar" style="height: 40px; width: 40px;">
                        </a>
                    </button>
                </td> -->
                <td class="text-center">
                    <form action="{{ url('edit') }}" method="GET" style="display: inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-link btn-sm btn-rounded">
                            <img src="https://cdn-icons-png.flaticon.com/512/5996/5996831.png" alt="Editar" style="height: 40px; width: 40px;">
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection