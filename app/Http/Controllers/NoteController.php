<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Log;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note::all();
    }

    public function list($user_id)
    {
        return Note::where('user_id', $user_id)->get();
    }

    public function listshared()
    {
        return Note::where('shared', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $note = new Note();
        $note->user_id = $request->input('user_id');
        $note->title = $request->input('title');
        $note->note = $request->input('note');
        $note->shared = $request->input('shared');
        if ($note->shared) {
            $note->share_password = password_hash($request->input('share_password'), PASSWORD_DEFAULT);
          } else 
          { 
            $note->share_password = '';
          }
        $note->save();
        return response($note, 200);
    }

    public function get($id)
    {
        return Note::find($id);
    }

    public function show($id, $secret_key)
    {
        $note = Note::find($id);
        if (password_verify($secret_key, $note->share_password)) {
            return $note;
        } 
        else 
        { 
            return response()->json([ 'error' => 'wrong password' ]);
        }
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        if ($note)
            $note->delete(); 
        else
            return response()->json(error);
        return response()->json(null); 
    }

    public function update(UpdateNoteRequest $request, Note $note, $id)
    {
        $note = Note::findOrFail($id);
  
        $note->update($request->all());
        if ($note->shared) {
          $note->share_password = password_hash($note->share_password, PASSWORD_DEFAULT);
        } else 
        { 
          $note->share_password = '';
        }
        $note->save();
        
        return $note;
    }

}
