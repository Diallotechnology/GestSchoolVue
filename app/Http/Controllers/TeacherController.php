<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Log;

final class TeacherController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {

        DB::transaction(
            callback: function () use ($request): void {
                $item = Teacher::create($request->safe()->except(['classe_id', 'matiere_id']));
                $matieres = $request->safe()->only(['matiere_id']);
                $classes = $request->safe()->only(['classe_id']);
                $item->matieres()->attach($matieres['matiere_id']);
                $item->classes()->attach($classes['classe_id']);
                flash('Professeur ajouter avec success!');
            },

        );

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $matiere = Matiere::all();
        $classe = Classe::all();

        return view('teacher.update', compact('teacher', 'matiere', 'classe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeacherRequest $request, Teacher $teacher)
    {
        DB::transaction(function () use ($request, $teacher): void {
            $teacher->update($request->safe()->except(['classe_id', 'matiere_id']));
            $matieres = $request->safe()->only(['matiere_id']);
            $classes = $request->safe()->only(['classe_id']);
            $teacher->matieres()->sync($matieres['matiere_id']);
            $teacher->classes()->sync($classes['classe_id']);
            flash('Professeur mise à jour avec success!');
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        flash()->success('Prof supprimée avec succès');
    }
}
