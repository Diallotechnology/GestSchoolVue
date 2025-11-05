<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Log;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Teacher;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTeacherRequest;

final class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $rows = Teacher::query()->with('classes:id,nom', 'matieres:id,nom')
            ->search($request->search, ['nom', 'prenom', 'contact'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        $matieres = Matiere::select('id', 'nom', 'coeficient')->get();
        $classes = Classe::select('id', 'nom', 'filiere_id')->get();
        return inertia('Teacher/Index', compact('rows', 'classes', 'matieres'));
    }

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
        $teacher->loadMissing('matieres:id,nom', 'classes:id,nom,filiere_id');
        $matieres = Matiere::select('id', 'nom', 'coeficient')->get();
        $classes = Classe::select('id', 'nom', 'filiere_id')->get();

        return inertia('Teacher/Edit', compact('teacher', 'matieres', 'classes'));
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
