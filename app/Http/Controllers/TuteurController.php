<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tuteur;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreParentRequest;

final class TuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = Tuteur::query()
            ->search($request->search, ['nom', 'prenom', 'contact'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Tuteur/Index', compact('rows'));
    }

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
        return inertia('Tuteur/Show', compact('tuteur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tuteur $tuteur)
    {
        return inertia('Tuteur/Edit', compact('tuteur'));
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
    public function destroy(Tuteur $tuteur)
    {
        $tuteur->delete();
        flash()->success('tuteur supprimée avec succès');
    }
}
