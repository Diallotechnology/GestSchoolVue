<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Models\Periode;
use Illuminate\Http\Request;

final class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = Periode::query()
            ->search($request->search, ['nom'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Periode/Index', compact('rows'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:50']);
        Periode::create(['nom' => $request->nom]);

        flash()->success('periode ajouter avec success!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periode $periode)
    {
        return inertia('Periode/Edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periode $periode)
    {
        $data = $request->validate(['nom' => 'required|string|max:50']);
        $periode->update($data);
        flash()->success('periode mise à jour avec success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();
        flash()->success('Periode supprimée avec succès');
    }
}
