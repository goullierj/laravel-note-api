<?php

namespace App\Http\Controllers;
use App\Http\Requests\Request;
use App\Note;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NoteController extends Controller
{
    public function index()
    {
        $result = Note::orderBy('created_at', 'desc')->get();
        if (sizeof($result) === 0) {
            return response()->json(['error' => 'Nothing to get']);
        }

        try {
            return response()->json(['notes' => $result, 'error' => null]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Nothing to get'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            return response()->json(['note' => Note::create($request->all()), 'error' => null]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Error to insert'], 404);
        }
    }
    public function show($id)
    {
        try {
            return response()->json(['note' => Note::findOrFail($id), 'error' => null]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Cet identifiant est inconnu'], 404);
        }
    }
}
