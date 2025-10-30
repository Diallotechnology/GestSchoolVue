<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StorePersonnelRequest;
use App\Models\Personnel;

final class PersonnelController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonnelRequest $request)
    {
        Personnel::create($request->validated());
        flash('Personnel ajouter avec success!');

        return back();
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
        return view('personnel.update', compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePersonnelRequest $request, Personnel $personnel)
    {
        $personnel->update($request->validated());
        flash('personnel mise à jour avec success!');

        return back();
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
