@extends('app')
@section('titulo')
Registro
@endsection
@section('opciones')
<li class="nav-item">
    <a class="nav-link" href="/loginForm">Logearme</a>
</li>
@endsection
@section('contenido')
<section class="h-100 h-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img3.webp" class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem;" alt="Sample photo">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Info de registro</h3>

                        <form class="px-md-2" action="{{ url('/registrar') }}" method="POST" id="register-form">
                            @csrf

                            @if ($errors->has('g-recaptcha-response'))
                            <div class="alert alert-danger p-2 mt-2" style="font-weight: bold;">
                                {{ $errors->first('g-recaptcha-response') }}
                            </div>
                            @endif

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="name">Nombre</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" />
                                @error('name')
                                <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                @enderror

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="lastname_p" class="form-label">Apellido paterno</label>
                                        <input type="text" class="form-control" id="lastname_p" name="lastname_p" value="{{ old('lastname_p') }}" />
                                        @error('lastname_p')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="lastname_m" class="form-label">Apellido materno</label>
                                        <input type="text" class="form-control" id="lastname_m" name="lastname_m" value="{{ old('lastname_m') }}" />
                                        @error('lastname_m')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="age" class="form-label">Edad</label>
                                        <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}" />
                                        @error('age')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" />
                                        @error('birthdate')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" />
                                @error('email')
                                <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                @enderror
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="phone">Teléfono</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" />
                                @error('phone')
                                <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" />
                                        @error('password')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline datepicker">
                                        <label for="password_confirmation" class="form-label">Confirma la contraseña</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                                        @error('password_confirmated')
                                        <div id="nombreError" class="alert alert-danger p-2 mt-2" style=" font-weight: bold;">{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="g-recaptcha btn btn-dark btn-md" data-sitekey="6LejC-gpAAAAAPVuDnsxH04aywYl6EbaohIc0lZT" data-callback='onSubmit' data-action='submit'>Registrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("register-form").submit();
    }
</script>
@endsection