<?php

namespace App\Http\Controllers;

use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private NoteRepository $noteRepository;
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }
    public function index($userId)
    {
        $notes = $this->noteRepository->getNotes($userId);
        return view('dashboard', ['notes' => $notes]);
    }
    public function createNote(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $validatedData['userId'] = $userId;
        $this->noteRepository->create($validatedData);
        return redirect(route('dashboard', ['userId' => $userId]));
    }

    public function updateNote(Request $request)
    {
        $validatedData = $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $noteId = $request->noteId;
        $userId = $request->userId;
        $validatedData['noteId'] = $noteId;
        $this->noteRepository->update($validatedData);

        if ($userId == 1) {
            return redirect(route('adminDashboard', ['userId' => $userId]));
        } else {
            return redirect(route('dashboard', ['userId' => $userId]));
        }
    }

    public function deleteNote(Request $request)
    {
        $noteId = $request->noteId;
        $userId = $request->userId;
        $this->noteRepository->delete($noteId);

        if ($userId == 1) {
            return redirect(route('adminDashboard', ['userId' => $userId]));
        } else {
            return redirect(route('dashboard', ['userId' => $userId]));
        }
    }

    public function admin()
    {
        $notes = $this->noteRepository->getAllNotes();
        return view('admin', ['notes' => $notes]);
    }
}
