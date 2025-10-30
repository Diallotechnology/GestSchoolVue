<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreUeRequest;
use App\Http\Requests\UpdateUeRequest;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Periode;
use App\Models\Ue;

final class UeController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUeRequest $request)
    {

        $item = Ue::create($request->safe()->except(['matiere_id']));

        $item->matieres()->attach($request->matiere_id);
        flash('Ue ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ue $ue): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ue $ue)
    {
        $filiere = Filiere::select('id', 'nom')->get();
        $matiere = Matiere::select('id', 'nom')->get();
        $periode = Periode::select('id', 'nom')->get();

        return view('ue.update', compact('periode', 'matiere', 'filiere', 'ue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUeRequest $request, Ue $ue)
    {
        $ue->update($request->safe()->except(['matiere_id']));
        $ue->matieres()->sync($request->matiere_id);
        flash('Ue mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ue $ue): \Illuminate\Http\JsonResponse
    {
        $ue->delete();
        flash()->success('Dépense supprimée avec succès');
    }
}
