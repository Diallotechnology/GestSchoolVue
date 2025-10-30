<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Tuteur;
use App\Models\Filiere;
use App\Models\Student;
use App\Helper\DeleteAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

final class StudentController extends Controller
{
    use DeleteAction;

    public function archive()
    {
        $rows = Student::onlyTrashed()->get();

        return view('student.archive', compact('rows'));
    }

    public function recover(int $id): JsonResponse
    {

        $row = Student::onlyTrashed()->whereId($id)->firstOrFail();

        return $this->Restore($row);
    }

    public function force_delete(int $id): JsonResponse
    {

        $row = Student::onlyTrashed()->whereId($id)->firstOrFail();

        return $this->Remove($row);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        DB::transaction(function () use ($request) {

            $item = Student::create($request->safe()->except(['files']));
            $item->generateId('ET');
            if ($request->hasFile('files')) {
                $this->file_uplode($request, $item);
            }
            flash('Etudiant ajouter avec success!');
        });

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);
        $student->withRelationshipAutoloading('scolarites');

        return view('student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        Gate::authorize('update', $student);
        $filiere = Filiere::select('id', 'nom')->get();
        $classe = Classe::with('filiere:id,nom')->select('id', 'nom', 'filiere_id')->get();
        $tuteur = Tuteur::select('id', 'nom', 'prenom', 'contact')->get();

        return view('student.update', compact('student', 'classe', 'filiere', 'tuteur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->safe()->except(['files']));
        if ($request->hasFile('files')) {
            $this->file_uplode($request, $student);
        }
        flash('Etudiant mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        flash()->success('Dépense supprimée avec succès');
    }
}
