@extends('partials.head')

@section('css')
    <link rel="stylesheet" href="{{ url('storage/style/addNote.css') }}" />
@endsection
@section('title')
    My note
@endsection

@section('body')

    <body class="my-4 mx-5">
        <div class="d-flex justify-content-between align-items-center mx-3">
            <div>
                <button onclick="showHome()" class="btn btn-dark btn-lg bi bi-house-fill p-3 px-4"></button>
            </div>
            <div class="logo">
                <img src="{{ url('storage/img/scribl-title.png') }}" alt="scribl logo" width="260" height="60" />
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-dark btn-lg p-3 px-3" onclick="reminder({{ $note->id }})">
                    <i class="bi bi-bell-fill"></i>
                    <label>Recordatorio</label>
                </button>
                <button class="btn btn-dark btn-lg border-start px-4 nav-btn" onclick="inputImage()">
                    <i class="bi bi-image-fill"></i>
                    <label>Imagen</label>
                    <input type="file" id="uploadFile" onchange="uploadImage({{ $note->id }})"></input>
                </button>
                <button class="btn btn-dark btn-lg border-start px-4 nav-btn" onclick="editNote({{ $note->id }})">
                    <i class="bi bi-bookmarks-fill"></i>
                    <label>Guardar</label>
                </button>
            </div>
        </div>
        <div class="mt-5 mx-3">
            <div class="note-body">
                <input type="text" class="text-dark fs-3 fw-bold w-100 note-input p-1" id="title"
                    value="{{ $note->title }}" /> <br>
                <textarea class="fs-5 text-dark h-75 w-100 mt-3 note-input p-1" id="note">{{ $note->note }}</textarea>
                <div id="div-imatges" class="h-25">
                    @include('partials.images')
                </div>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('storage/js/editNote.js') }}"></script>
@endsection
