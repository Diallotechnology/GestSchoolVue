<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Helper\DeleteAction;
use App\Http\Requests\StoreDevoirRequest;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Course;
use App\Models\Devoir;
use App\Models\Matiere;
use App\Models\Periode;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

final class DevoirController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDevoirRequest $request)
    {
        $item = Devoir::create($request->validated());
        $item->generateId('DEV');
        $notification = new MessageNotification($item->type, "Vous avez un nouveau $item->type");
        $users = User::without('userable')->where('role', RoleEnum::STUDENT)
            ->whereIn('userable_id', $item->classe->students->pluck('id'))->get();
        if ($users->isNotEmpty()) {
            Notification::send($users, $notification);
        }
        flash('Devoir ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Devoir $devoir)
    {
        Gate::authorize('view', $devoir);

        return view('devoir.show', compact('devoir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Devoir $devoir)
    {
        Gate::authorize('update', $devoir);
        $auth = Auth::user();
        $matiere = Matiere::ForUser()->get();
        $classe = Classe::ForUser()->get();
        $cours = Course::ForUser()->get();
        $periode = Periode::select('id', 'nom')->get();

        return view('devoir.update', compact('devoir', 'matiere', 'classe', 'cours', 'periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDevoirRequest $request, Devoir $devoir)
    {
        $devoir->update($request->validated());
        flash('Devoir mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devoir $devoir)
    {
        $devoir->delete();
        flash()->success('Devoir supprimée avec succès');
    }
}
