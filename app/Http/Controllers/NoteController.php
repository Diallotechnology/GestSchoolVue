<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Periode;
use App\Models\Student;
use Illuminate\Support\Facades\Gate;

final class NoteController extends Controller
{
    use DeleteAction;

    /**
     * Display the specified resource.
     */
    public function show(Note $note): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        Gate::authorize('update', $note);
        $student = Student::select('id', 'reference', 'nom', 'prenom')->get();
        $matiere = Matiere::select('id', 'nom')->get();
        $periode = Periode::select('id', 'nom')->get();

        return view('note.update', compact('note', 'matiere', 'student', 'periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        flash('note mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        flash()->success('Note supprimée avec succès');
    }
}
