<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Models\Type;
use Illuminate\Http\Request;

final class TypeController extends Controller
{
    public function index(Request $request)
    {
        $rows = Type::query()
            ->search($request->search, ['nom'])
            ->latest()
            ->paginate(20)
            ->withQueryString()->toResourceCollection();

        return inertia('Type/Index', compact('rows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:50']);
        Type::create(['nom' => $request->nom]);
        flash('Type ajouter avec success!');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return inertia('Type/Edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $data = $request->validate(['nom' => 'required|string|max:50']);
        $type->update($data);
        flash('Type mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        flash()->success('type supprimée avec succès');
    }
}
