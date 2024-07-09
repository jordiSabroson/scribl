@extends('partials.head')

@section('title')
    Log in
@endsection

@section('body')

    <body>
        <div class="container-fluid">
            <div class="row vh-100">
                <!-- Mitad izquierda de la pantalla principal con el GIF -->
                <div class="col-lg-6 bg-black d-flex align-items-center justify-content-center">
                    <img src="{{ url('storage/img/smile.gif') }}" alt="smile face" />
                </div>

                <!-- Mitad derecha con el formulario de login -->
                <div class="col-lg-6" style="background-color: #f4f1ed">
                    <div class="text-center mt-5">
                        <img src="{{ url('storage/img/scribl-logo.png') }}" alt="scribl logo" />
                    </div>
                    <div class="d-flex flex-column justify-content-center mt-5">
                        <div class="mb-3 mx-5">
                            <label for="email" class="form-label fw-bold fs-5">Email*</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                style="background-color: #eeeae5" placeholder="..." id="email" required />
                        </div>
                        <div class="mb-3 mx-5">
                            <label for="password" class="form-label fw-bold fs-5">Contraseña*</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control form-control-lg"
                                    style="background-color: #eeeae5" placeholder="..." id="password" required />
                                <span class="input-group-text" style="background-color: #eeeae5">
                                    <button class="bi-eye-slash border-0" style="background-color: #eeeae5"
                                        id="toggle-password" type="button"></button>
                                </span>
                            </div>
                            <div class="form-text d-flex justify-content-end">
                                He olvidado mi contraseña&nbsp;
                                <a href="/recover" class="fw-bold text-decoration-none text-reset">
                                    Recuperar</a>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center mt-5">
                            <button class="btn btn-dark w-25 p-2 mb-3 rounded-3" id="loginBtn" onclick="login()">
                                Inicia sesión
                            </button>
                            <button class="btn btn-light w-25 p-2 border border-black rounded-3" onclick="showRegister()">
                                Registrarse
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('storage/js/showPassword.js') }}"></script>
    <script type="text/javascript" src="{{ url('storage/js/loginAndRegister.js') }}"></script>
@endsection
