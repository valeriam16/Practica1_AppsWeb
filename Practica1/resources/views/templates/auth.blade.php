@extends('app')
@section('titulo')
Dashboard
@endsection
@section('opciones')
<li class="nav-item">
    <a class="nav-link" href="/read">Lista de usuarios</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/logout">Cerrar Sesión</a>
</li>
@endsection

@section('contenido')
<section class="vh-120">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-4 gradient-custom2 text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <img src="https://www.hotelbooqi.com/wp-content/uploads/2021/12/128-1280406_view-user-icon-png-user-circle-icon-png.png" alt="Avatar" class="img-fluid mt-5 mb-3" style="width: 80px;" />
                            <h5 style="color: black;">{{ Auth::user()->name }} {{ Auth::user()->lastname_p }} {{ Auth::user()->lastname_m }}</h5>
                            <a href="/editar"><img src="https://i.pinimg.com/originals/6f/d0/53/6fd05369a0fb8c1bc2b3ef84976e954a.png" alt="Editar" class="img-fluid mt-4" style="width: 30px;" /></a>
                            <i class="far fa-edit mb-5"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h3>Mi info</h3>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Correo</h6>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Teléfono</h6>
                                        <p class="text-muted">{{ Auth::user()->phone }}</p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Edad</h6>
                                        <p class="text-muted">{{ Auth::user()->age }}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Nacimiento</h6>
                                        <p class="text-muted">{{ Auth::user()->birthdate }}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                    <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                    <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection