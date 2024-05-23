@extends('app')

@section('titulo')
Editar Usuario
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
<section>
    <div class="container py-5 vh-140">
        <form action="{{ url('update') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://www.hotelbooqi.com/wp-content/uploads/2021/12/128-1280406_view-user-icon-png-user-circle-icon-png.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h6 class="my-3">Editando al usuario:</h6>
                            <h3 class="">{{ $user->name }} {{ $user->lastname_p }}</h3>
                        </div>
                        <div class="d-flex justify-content-center pt-3 pb-4">
                            <button type="submit" class="btn btn-dark">Guardar cambios</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Nombre:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Apellido paterno:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="lastname_p" name="lastname_p" value="{{ $user->lastname_p }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Apellido materno:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="lastname_m" name="lastname_m" value="{{ $user->lastname_m }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Edad:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="age" name="age" value="{{ $user->age }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Fecha de nacimiento:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $user->birthdate }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Correo:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Teléfono:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0"><b>Estado de la cuenta:</b></p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="active" id="active1" value="1" {{ $user->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active1">
                                            Activa
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="active" id="active0" value="0" {{ !$user->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active0">
                                            Inactiva
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection