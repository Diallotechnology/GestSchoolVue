<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Models\Filiere;
use Illuminate\Http\Request;

final class FiliereController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:50']);
        Filiere::create(['nom' => $request->nom]);

        flash('Filiere ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Filiere $filiere): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filiere $filiere)
    {
        return view('filiere.update', compact('filiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filiere $filiere)
    {
        $data = $request->validate(['nom' => 'required|string|max:50']);
        $filiere->update($data);
        flash('Filiere mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $filiere): \Illuminate\Http\JsonResponse
    {
        $delete = Filiere::findOrFail($filiere);

        return $this->supp($delete);
    }
}
