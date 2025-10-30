<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreDepenseRequest;
use App\Models\Depense;
use Illuminate\Support\Facades\Gate;

final class DepenseController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepenseRequest $request)
    {
        Depense::create($request->validated());
        flash('Depense ajouter avec success!');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        if (! Gate::allows('update-depense', $depense)) {
            abort(403);
        }

        return view('depense.update', compact('depense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepenseRequest $request, Depense $depense)
    {

        $depense->update($request->validated());

        flash('depense mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();
        flash()->success('Dépense supprimée avec succès');
    }
}
