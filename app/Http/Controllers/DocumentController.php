<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class DocumentController extends Controller
{
    use DeleteAction;

    /**
     * Display the specified resource.
     */
    public function show(Document $document): BinaryFileResponse
    {
        Gate::authorize($document);
        $filePath = public_path($document->DocLink());
        header('Content-Type: application/pdf');

        return response()->file($filePath);
    }

    public function download(Document $document)
    {
        Gate::authorize($document);
        $filePath = public_path($document->DocLink());

        return response()->download($filePath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        Gate::authorize('update', $document);

        return view('document.update', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        if ($document instanceof Cours) {
            $path = 'cours';
        } elseif ($document instanceof Devoir) {
            $path = 'devoir';
        }
        if ($request->hasFile('file')) {
            $this->file_delete($document);
            $filename = $request->file->hashName();
            $chemin = $request->file->storeAs($path, $filename, 'public');
            $documentData = ['chemin' => $chemin];
        } else {
            $documentData = ['libelle' => $request->libelle];
        }

        $document->update($documentData);
        flash('Document mise à jour avec succès!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $document): \Illuminate\Http\JsonResponse
    {
        $delete = Document::findOrFail($document);
        $this->file_delete($delete);

        return $this->supp_auth($delete);
    }
}
