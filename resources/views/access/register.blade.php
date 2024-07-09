@extends('partials.head')

@section('title')
    Register
@endsection

@section('body')

    <body
        style="background-color: #F4F1ED; background-image: url({{ url('storage/img/fondo.png') }}); background-size:cover; background-repeat: no-repeat">
        <div class="container-fluid">
            <div class="column">
                <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                    <a href="/"><img src="{{ url('storage/img/scribl-logo.png') }}" alt="scribl logo" /></a>
                    <div>
                        <label for="email" class="form-label fw-bold fs-5 my-3">Email*</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            style="background-color: #eeeae5" placeholder="..." id="email" />
                        <label for="password" class="form-label fw-bold fs-5 my-3">Contraseña*</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control form-control-lg"
                                style="background-color: #eeeae5" placeholder="..." id="password" />
                            <span class="input-group-text" style="background-color: #eeeae5">
                                <button class="bi-eye-slash border-0" style="background-color: #eeeae5" id="toggle-password"
                                    type="button"></button>
                            </span>
                        </div>
                        <label for="name" class="form-label fw-bold fs-5 my-3">Nombre*</label>
                        <input type="name" name="name" class="form-control form-control-lg"
                            style="background-color: #eeeae5" placeholder="..." id="name" />
                        <label for="surname" class="form-label fw-bold fs-5 my-3">Apellidos*</label>
                        <input type="surname" name="surname" class="form-control form-control-lg"
                            style="background-color: #eeeae5" placeholder="..." id="surname" />
                        <input class="form-check-input" type="checkbox" value="" id="terms" />
                        <div>
                            <label for="terms" class="form-check-label">
                                He leído y acepto&nbsp;
                                <a class="fw-bold fs-6 text-decoration-none text-reset pe-auto" onclick="politica()">
                                    la política de privacidad y los términos y condiciones
                                </a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-center mt-5">
                    <button class="btn btn-dark w-25 p-2 mb-3 rounded-3" id="registerBtn" onclick="register()">
                        Crear cuenta
                    </button>
                    <button class="btn btn-light w-25 p-2 rounded-3" onclick="showLogin()">
                        Volver al Login
                    </button>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('storage/js/showPassword.js') }}"></script>
    <script type="text/javascript" src="{{ url('storage/js/loginAndRegister.js') }}"></script>
@endsection
