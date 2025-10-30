<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Periode;
use App\Helper\DeleteAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCoursRequest;
use App\Models\Course;

final class CoursController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoursRequest $request)
    {
        DB::transaction(function () use ($request) {
            $item = Course::create($request->safe()->except(['classe_id', 'periode_id', 'files']));
            $item->generateId('CO');
            $item->classes()->attach($request->safe()->only(['classe_id']));
            $item->periodes()->attach($request->safe()->only(['periode_id']));
            if ($request->hasFile('files')) {
                $this->file_uplode($request, $item);
            }
            flash('Cours ajouter avec success!');
        });
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        Gate::authorize('view', $course);

        return view('cours.show', compact('cour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        Gate::authorize('update', $course);
        $auth = Auth::user();
        $matiere = Matiere::ForUser()->get();
        $classe = Classe::ForUser()->get();
        $periode = Periode::all();
        $type = Type::all();

        return view('cours.update', compact('cour', 'classe', 'periode', 'type', 'matiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCoursRequest $request, Course $course)
    {
        DB::transaction(function () use ($request, $course) {

            $course->update($request->safe()->except(['classe_id', 'periode_id', 'files']));
            $course->classes()->sync($request->safe()->only(['classe_id']));
            $course->periodes()->sync($request->safe()->only(['periode_id']));
            if ($request->hasFile('files')) {
                $this->file_uplode($request, $course);
            }
        });

        flash('Cours mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        flash()->success('Cours supprimée avec succès');
    }
}
