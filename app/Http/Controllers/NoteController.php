<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{

    // MÈTODES GET
    function show_home()
    {
        $user = Auth::user();
        if ($user) {
            $notes = $user->notes();
            return view('homepage', ['notes' => $notes, 'user' => $user]);
        } else {
            return redirect('login');
        }
    }

    function show_add_note()
    {
        return view('notes.add-note');
    }

    function show_edit_note(Request $request)
    {
        $user = Auth::user();
        $notes = $user->notes()->where('unique_id', $request->unique_id)->first();
        return view('notes.edit-note', ['note' => $notes]);
    }

    function get_images($id)
    {
        $note = Note::find($id);
        return view('partials.images', compact('note'));
    }

    function getNotes(Request $request)
    {
        $user = Auth::user();

        return view('partials.note-item', compact('user'));
    }

    function get_filtered_notes(Request $request, $query)
    {
        $auth = Auth::user();

        $user = $auth->notes()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                    ->orWhere('note', 'like', "%$query%");
            })->get();

        return view('partials.note-item', ['user' => $user]);
    }

    // MÈTODES POST
    function add_note(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:1'],
            'note' => ['required', 'string']
        ]);

        $user = Auth::user();
        $unique_id = uniqid();
        $note = $user->notes()->create([
            'title' => $request->title,
            'note' => $request->note,
            'unique_id' => $unique_id
        ]);

        return response()->json(['state' => 200, 'message' => 'note saved successfully', 'unique_id' => $note->unique_id]);
    }

    function edit_note(Request $request, $id)
    {
        if ($note = Note::findOrFail($id)) {
            if ($request->title == $note->title) {
                $request->validate([
                    'note' => ['required', 'string', 'min:1']
                ]);
            } else {
                $request->validate([
                    'title' => ['required', 'string', 'min:1'],
                    'note' => ['required', 'string']
                ]);
            }

            $note->update($request->all());
            return response()->json(['state' => 200, 'message' => 'note updated successfully']);
        }
    }

    function delete_note($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['state' => 200, 'message' => 'note deleted successfully']);
    }

    function search_note(Request $request)
    {
        $search = $request->input('user_input');

        return response()->json(['state' => 200, 'query' => $search]);
    }

    function upload_image(Request $request, $id)
    {
        if ($request->hasFile('document')) {
            $request->validate([
                'document' => 'required|mimes:jpg,png,jpeg|max:10240', // Ajusta las extensiones y el tamaño según tus necesidades
            ]);

            $file = $request->file('document');
            $route = $file->store('note-img', 'public'); // Almacenar el archivo en la carpeta 'public/storage/note-img'

            $url = Storage::url($route);

            $image = new Image();

            $image->create([
                'route' => $url,
                'note_id' => $id
            ]);

            return response()->json(['state' => 200, 'url' => $url]);
        } else {
            return response()->json(['state' => 400, 'message' => 'no image was uploaded']);
        }
    }

    function delete_image($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        return response()->json(['state' => 200, 'message' => 'image deleted successfully']);
    }

    function pin_note($id)
    {
        $note = Note::findOrFail($id);
        $note->pinned = !$note->pinned;
        $note->save();

        return response()->json(['state' => 200, 'message' => 'note pinned successfully']);
    }

    function reminder(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->reminder = $request->date;
        $note->save();
        return response()->json(['state' => 200, 'message' => 'reminder set successfully']);
    }
}
