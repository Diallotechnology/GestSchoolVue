<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClasseRequest;

final class ClasseController extends Controller
{

    public function index(Request $request)
    {
        $rows = Classe::query()->with('filiere:id,nom', 'matieres:id,nom')
            ->search($request->search, ['nom'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        // dd($rows);
        $filieres = Filiere::select('id', 'nom')->get();
        $matieres = Matiere::select('id', 'nom', 'coeficient')->get();
        return inertia('Classe/Index', compact('rows', 'filieres', 'matieres'));
    }

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
        $classe->loadMissing('matieres:id,nom', 'filiere:id,nom');
        $matieres = Matiere::select('id', 'nom')->get();
        $filieres = Filiere::select('id', 'nom')->get();

        return inertia('Classe/Edit', compact('classe', 'matieres', 'filieres'));
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
