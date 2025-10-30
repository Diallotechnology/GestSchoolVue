<?php

declare(strict_types=1);

namespace App\Helper;

use App\Models\Cours;
use App\Models\Course;
use App\Models\Devoir;
use App\Models\Document;
use App\Models\Folder;
use App\Models\Journal;
use App\Models\Student;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

trait DeleteAction
{
    // public function journal(string $action): void
    // {
    //     Journal::create([
    //         'user_id' => Auth::user()->id,
    //         'structure_id' => Auth::user()->structure(),
    //         'libelle' => $action,
    //     ]);
    // }




    public function file_delete(Model $model): bool
    {
        if (File::exists(public_path($model->DocLink()))) {
            return File::delete(public_path($model->DocLink()));
        }

        return false;
    }

    public function file_uplode(array $files, Model $model): void
    {
        if (empty($files)) {
            return;
        }

        try {
            // Définir le chemin de stockage selon le type de modèle
            $path = match (true) {
                $model instanceof Devoir => 'devoir',
                $model instanceof Course => 'course',
                default => 'documents'
            };

            // Créer le dossier associé
            $folder = $model->folder()->create([
                'nom' => $model->reference,
            ]);

            // Parcourir et stocker les fichiers
            foreach ($files as $file) {
                $chemin = $file->storeAs($path, $file->hashName(), 'public');

                Document::create([
                    'libelle' => $file->getClientOriginalName(),
                    'extension' => $file->extension(),
                    'user_id' => Auth::id(),
                    'folder_id' => $folder->id,
                    'chemin' => $chemin,
                ]);
            }
        } catch (\Throwable $th) {
            // Optionnel : log de l’erreur
            \Log::error('Erreur lors de l\'upload de fichiers : ' . $th->getMessage());

            flash()->error('Erreur lors de l\'upload des fichiers. Veuillez réessayer.');
        }
    }



    public function Restore(Model $delete): JsonResponse
    {
        Gate::authorize('restore', $delete);
        $delete->restore();

        return response()->json([
            'success' => true,
            'message' => $delete ? class_basename($delete) . ' restaure avec success ' : class_basename($delete) . ' non trouvé',
        ]);
    }

    public function Remove(Model $delete)
    {
        Gate::authorize('forceDelete', $delete);
        $delete->forceDelete();

        return response()->json([
            'success' => true,
            'message' => $delete ? class_basename($delete) . ' definitivement supprimer avec success ' : class_basename($delete) . ' non trouvé',
        ]);
    }

    public function All_restore(Builder $delete)
    {
        $delete->restore();
        flash('Tous les elements ont été restaure avec success!');

        return back();
    }

    public function All_remove(Builder $delete)
    {
        $delete->forceDelete();
        flash('Tous les elements ont été definitivement supprimé avec success!');

        return back();
    }
}
