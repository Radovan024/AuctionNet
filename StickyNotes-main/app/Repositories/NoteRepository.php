<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
    public function getNotes($userId)
    {
        return Note::where('user_id', $userId)->get();
    }
    public function create($note)
    {
        return Note::create([
            'note' => $note['note'],
            'user_id' => $note['userId'],
        ]);
    }

    public function update($data)
    {
        return Note::where('id', $data['noteId'])->update([
            'note' => $data['note'],
        ]);
    }

    public function delete($noteId)
    {
        return Note::destroy($noteId);
    }

    public function getAllNotes()
    {
        return Note::all();
    }
}
