@extends('partials.head')
@section('title')
    My profile
@endsection

@section('body')

    <body class="my-4 mx-5 h-100">
        <div class="d-flex justify-content-between align-items-center mx-3">
            <div>
                <button onclick="showHome()" class="btn btn-dark btn-lg bi bi-house-fill p-3 px-4"></button>
            </div>
            <div></div>
            <div class="logo">
                <img src="{{ url('storage/img/scribl-title.png') }}" alt="scribl logo" width="260" height="60" />
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-dark btn-lg p-3 px-3" id="btnEditar" onclick="changePage('userEdit')">
                    <i class="bi bi-pencil-fill"></i>
                    <label>Editar perfil</label>
                </button>
                <button class="btn btn-light btn-lg border-start px-4 nav-btn" id="btnPassword"
                    onclick="changePage('userPassword')">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <label>Cambiar contraseña</label>
                </button>
            </div>
        </div>
        <div id="defaultDiv">
            @include('user.edit-user')
        </div>
        <div id="userEdit" hidden>
            @include('user.edit-user')
        </div>
        <div id="userPassword" hidden>
            @include('user.password')
        </div>
    </body>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('storage/js/updateUser.js') }}"></script>
@endsection
