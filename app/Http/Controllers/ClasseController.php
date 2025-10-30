<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreClasseRequest;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Matiere;

final class ClasseController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClasseRequest $request)
    {

        $item = Classe::create($request->safe()->except(['matiere_id']));
        $item->matieres()->attach($request->matiere_id);
        flash('Classe ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Classe $classe)
    {
        return view('classe.show', compact('classe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        $matiere = Matiere::all();
        $filiere = Filiere::all();

        return view('classe.update', compact('classe', 'matiere', 'filiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClasseRequest $request, Classe $classe)
    {
        $classe->update($request->safe()->except(['matiere_id']));
        $classe->matieres()->sync($request->matiere_id);
        flash('Classe mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classe $classe)
    {
        $classe->delete();
        flash()->success('Classe supprimée avec succès');
    }
}
