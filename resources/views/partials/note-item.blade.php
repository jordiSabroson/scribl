{{-- El div esta dividido en 12 columnas --}}
<div class="col-md-12">

    {{-- Usando el método chunk para dividir de 4 en 4 los elementos del array $user->notes y asignándolo a la variable $chunk --}}
    {{-- Se itera con un foreach para que aparezcan 4 notas por cada row --}}
    @foreach ($user->notes->sortByDesc('pinned')->chunk(4) as $chunk)
        {{-- Se crea un nuevo row cada conjunto de 4 notas --}}
        <div class="row">
            {{-- Se usa el método forelse para que en caso de que no haya notas, aparezca el mensaje que hay después del @empty --}}
            {{-- Por cada nota se crea una columna de 3 para que haya 4 notas en total --}}
            @foreach ($chunk as $note)
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card border-0 mt-3 note-item mx-sm-1">
                        <div class="card-body overflow-y-scroll">
                            {{-- Clase 'nota' que usa el script de la barra de búsqueda --}}
                            <h5 class="card-title nota">{{ $note->title }}</h5>
                            @if ($note->images->isNotEmpty())
                                @php
                                    $first_image = $note->images()->first();
                                @endphp
                                <img class="card-img-bottom rounded-2 " src="{{ $first_image->route }}" alt="user img">
                            @else
                                <p class="card-text nota">{{ $note->note }}</p>
                            @endif
                        </div>

                        {{-- Div que contiene los tres botones de las notas --}}
                        <div class="my-2 border-secondary-subtle border-top z-3">
                            <div class="me-3 d-flex flex-row-reverse">
                                {{-- Botones de las notas donde cada uno tiene el ID de la nota y llama a su función correspondiente --}}
                                <div class="pt-2">
                                    {{-- Botón que llama a la función 'pinNote' y pasa como parámetro el propio elemento para cambiar el estilo
                                        del botón y cambiar el 'aria-valuenow' para saber que la nota está fijada --}}
                                    <button onclick="pinNote(this)" class="bi bi-pin-fill text-reset border-0 button-28"
                                        id="{{ $note->id }}"
                                        aria-valuenow="{{ $note->pinned ? '1' : '0' }}"></button>
                                </div>
                                <div class="pt-2 mx-3">
                                    <button onclick="showEditNote('{{ $note->unique_id }}')"
                                        class="bi bi-pencil-fill text-reset border-0 button-28"></button>
                                </div>
                                <div class="pt-2">
                                    <button onclick="deleteNote('{{ $note->id }}')"
                                        class="bi bi-trash-fill text-reset border-0 button-28"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> {{-- Cierre del row --}}
    @endforeach
</div> {{-- Cierre de las 12 columnas --}}

{{-- En caso de que no haya notas se muestra este mensaje --}}
@empty($user->notes())
    <div class="d-flex flex-column align-items-center text-secondary">
        <h5>¡Oops!</h5>
        <h5>Parece que tus notas están vacías :(</h5>
    </div>
@endempty
