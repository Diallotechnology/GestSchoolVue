<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreDepenseRequest;

final class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = Depense::query()->with('user:id,email')
            ->search($request->search, ['motif', 'montant'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Depense/Index', compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepenseRequest $request)
    {
        Auth::user()->depenses()->create($request->validated());
        flash('Depense ajouter avec success!');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        // Gate::authorize('update', $depense);

        return inertia('Depense/Edit', compact('depense'));
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
