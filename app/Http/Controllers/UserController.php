<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\DeleteAction;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\MailNotificationJob;
use App\Models\Personnel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

final class UserController extends Controller
{
    use DeleteAction;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validate = $request->validated();
        if ($validate['role'] === 'Professeur') {
            $parent = Teacher::findOrFail($validate['userable_id']);
        } elseif ($validate['role'] === 'Etudiant') {
            $parent = Student::findOrFail($validate['userable_id']);
        } elseif ($validate['role'] === 'Parent') {
            $parent = Tuteur::findOrFail($validate['userable_id']);
        } elseif ($validate['role'] === 'Administration') {
            $parent = Personnel::findOrFail($validate['userable_id']);
        }
        $user = $parent->user()->create($request->safe()->except(['userable_id']));
        MailNotificationJob::dispatch($user);
        flash('Utilisateur ajouter avec success!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        $parents = match ($user->role->value) {
            'Professeur' => Teacher::select('id', 'prenom', 'nom')->get(),
            'Etudiant' => Student::select('id', 'prenom', 'nom')->get(),
            'Parent' => Tuteur::select('id', 'prenom', 'nom')->get(),
            'Administration' => Personnel::select('id', 'prenom', 'nom')->get(),
            default => collect(),
        };

        return view('user.update', compact('user', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $filename = $request->photo->hashName();
            $chemin = $request->photo->storeAs('student/photo', $filename, 'public');
            $validatedData['photo'] = $chemin;
        }
        $user->update($validatedData);

        flash('Utilisateur mise à jour avec success!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();
        flash()->success('user supprimée avec succès');
    }
}
