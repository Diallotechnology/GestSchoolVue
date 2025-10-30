<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

final class FolderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        return view('folder.show', compact('folder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder): void {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder): void
    {
        //
    }
}
