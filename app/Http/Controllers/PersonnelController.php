<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonnelRequest;

final class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = Personnel::query()
            ->search($request->search, ['nom', 'prenom', 'contact'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Personnel/Index', compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonnelRequest $request)
    {
        Personnel::create($request->validated());
        flash('Personnel ajouter avec success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personnel $personnel): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        return inertia('Personnel/Edit', compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePersonnelRequest $request, Personnel $personnel)
    {
        $personnel->update($request->validated());
        flash('personnel mise à jour avec success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personnel $personnel)
    {
        $personnel->delete();
        flash()->success('Personnel supprimée avec succès');
    }
}
