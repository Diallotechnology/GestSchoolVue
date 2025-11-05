<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMatiereRequest;

final class MatiereController extends Controller
{
    use DeleteAction;

    public function index(Request $request)
    {
        $rows = Matiere::query()
            ->search($request->search, ['nom', 'coeficient', 'duree'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Matiere/Index', compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatiereRequest $request)
    {
        Matiere::create($request->validated());

        flash('Matiere ajouter avec success!');
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
        return inertia('Matiere/Edit', compact('matiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMatiereRequest $request, Matiere $matiere)
    {
        $matiere->updateOrFail($request->validated());
        flash('Matiere mise à jour avec success!');
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
