@extends('partials.head')

@section('css')
    <link rel="stylesheet" href="{{ url('storage/style/homepage.css') }}" />
@endsection
@section('title')
    Home
@endsection

@section('body')

    <body style="background-color: #F4F1ED;">
        <div class="d-flex justify-content-between align-items-center px-5 my-4">
            <div></div>
            <div>
                <img src="{{ url('storage/img/scribl-title.png') }}" alt="scribl logo" width="260" height="60"
                    style="margin-left: 13rem" />
            </div>
            <div>
                <label class="bi bi-pencil-fill">
                    <a href="/edit" class="text-reset text-decoration-none mx-2">Editar perfil</a>
                </label>
                <label class="bi bi-box-arrow-right ms-3">
                    <a href="/logout" class="text-reset text-decoration-none mx-2">Salir</a>
                </label>
            </div>
        </div>
        <div class="mx-5">
            {{-- SEARCH BAR --}}
            <div class="input-group mb-4" role="search">
                <span class="input-group-append rounded-pill rounded-end" style="background-color: #EEEAE5;">
                    <button class="btn btn-lg rounded-pill rounded-end" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </span>
                <input class="form-control form-control-lg border-0 rounded-pill rounded-start" type="text"
                    placeholder="Buscar..." style="background-color: #EEEAE5;" id="search">
            </div>

            <div class="d-flex border-bottom justify-content-between mb-2">
                <h2>Mis notas</h2>
                <button class="btn btn-dark bi bi-plus rounded-3 px-3 mb-1" onclick="showAddNote()">Añadir</button>
            </div>

            {{-- Mensaje de éxito cuando se actualize la info del usuario --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div id="notes-list">
                @include('partials.note-item')
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ url('storage/js/homepage.js') }}"></script>
@endsection
