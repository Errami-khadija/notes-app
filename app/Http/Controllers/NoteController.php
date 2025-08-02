<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

         $search = $request->input('search');

    $notes = Note::where('user_id', Auth::id())
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
        })
     ->paginate(3);

    return view('notes.index', compact('notes', 'search'));
        //  $notes = Note::where('user_id', Auth::id())->get();
        // return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'nullable|string',
    ]);

    Note::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'content' => $request->content,
        'category' => $request->category,
    ]);

    return redirect()->route('notes.index')->with('success', 'Note added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
         if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($request->only('title', 'content'));

        return redirect()->route('notes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index');
    }
}
