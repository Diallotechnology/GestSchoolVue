<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreMatiereRequest;
use App\Models\Matiere;

final class MatiereController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatiereRequest $request)
    {
        Matiere::create($request->validated());

        flash('Matiere ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Matiere $matiere)
    {
        return view('matiere.show', compact('matiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matiere $matiere)
    {
        return view('matiere.update', compact('matiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMatiereRequest $request, Matiere $matiere)
    {
        $matiere->update($request->validated());
        flash('Matiere mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matiere $matiere)
    {
        $matiere->delete();
        flash()->success('matiere supprimée avec succès');
    }
}
