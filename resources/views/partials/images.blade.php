@foreach ($note->images as $image)
    <div class="image-container h-100">
        <img src="{{ $image->route }}" alt="user image" class="me-3 h-100 rounded-2">
        <div class="btn-delete">
            <button class="bi bi-trash-fill text-reset border-0 button-28"
                onclick="deleteImage('{{ $image->id }}', {{ $note->id }})"></button>
        </div>
    </div>
@endforeach
