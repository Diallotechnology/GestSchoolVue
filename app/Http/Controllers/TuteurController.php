<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreParentRequest;
use App\Models\Tuteur;

final class TuteurController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParentRequest $request)
    {
        Tuteur::create($request->validated());
        flash('Parent ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tuteur $tuteur)
    {
        return view('parent.show', compact('matiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tuteur $tuteur)
    {
        return view('parent.update', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreParentRequest $request, Tuteur $tuteur)
    {
        $tuteur->update($request->validated());
        flash('parent mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tuteur $tuteur): \Illuminate\Http\JsonResponse
    {
        $tuteur->delete();
        flash()->success('tuteur supprimée avec succès');
    }
}
