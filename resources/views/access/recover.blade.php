@extends('partials.head')

@section('title')
    Recover
@endsection

@section('body')

    <body
        style="background-color: #F4F1ED; background-image: url({{ url('storage/img/fondo.png') }}); background-size:cover; background-repeat: no-repeat">
        <div class="container-fluid">
            <div class="column">
                <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                    <div class="mw-vh-25">
                        <a href="/"><img src="{{ url('storage/img/scribl-logo.png') }}" alt="scribl logo" /></a>
                    </div>
                    <div>
                        <h3>Ayúdanos a recuperar tu contraseña</h3>
                        <p class="text-secondary">Introduce tu correo y te enviaremos las instrucciones para poder
                            recuperarla.</p>
                        <label for="email" class="form-label fw-bold fs-5 mb-3">Email*</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            style="background-color: #eeeae5" placeholder="..." id="email" required />
                    </div>
                </div>
                <div class="d-flex flex-column align-items-center mt-5">
                    <button type="submit" class="btn btn-dark w-25 p-2 mb-3 rounded-3" onclick="sendRecover()">
                        Enviar correo
                    </button>
                    <a class="text-decoration-none text-reset btn btn-light p-2 w-25 rounded-3" href="/">
                        Volver al Login
                    </a>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script src="{{ url('storage/js/sendMail.js') }}"></script>
@endsection
