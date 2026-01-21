<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\RoleEnum;
use App\Models\Tuteur;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Personnel;
use App\Helper\DeleteAction;
use Illuminate\Http\Request;
use App\Jobs\MailNotificationJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

final class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = User::query()
            ->when($request->filled('search'), fn($query) => $query->whereAny(['role', 'name', 'email'], 'like', '%' . $request->search . '%'))
            ->when($request->filled('role'), fn($query) => $query->where('role', $request->role))
            ->latest()
            ->paginate(15)
            ->toResourceCollection();

        $roles = RoleEnum::all();

        return inertia('User/Index', compact('rows', 'roles'));
    }

    public function fetch_Role(Request $request)
    {
        $request->validate(['role' => ['required', 'string']]);

        $role = $request->query('role');

        $users = match ($role) {
            RoleEnum::TEACHER->value      => Teacher::select('id', 'nom', 'prenom', 'contact')->get(),
            RoleEnum::STUDENT->value      => Student::select('id', 'nom', 'prenom', 'reference')->get(),
            RoleEnum::PARENT->value       => Tuteur::select('id', 'nom', 'prenom')->get(),
            RoleEnum::ADMIN->value,
            RoleEnum::ASSISTANT->value,
            RoleEnum::COMPTABLE->value,
            RoleEnum::DG->value,
            RoleEnum::SURVEILLANT->value  => Personnel::select('id', 'nom', 'prenom')->get(),
            default                       => collect(),
        };
        // dd($users);
        return response()->json($users);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validate = $request->validated();
        $roleEnum = RoleEnum::from($validate['role']);

        $parent = match ($roleEnum) {
            RoleEnum::TEACHER     => Teacher::findOrFail($validate['userable_id']),
            RoleEnum::STUDENT       => Student::findOrFail($validate['userable_id']),
            RoleEnum::PARENT         => Tuteur::findOrFail($validate['userable_id']),
            RoleEnum::ADMIN->value,
            RoleEnum::ASSISTANT->value,
            RoleEnum::COMPTABLE->value,
            RoleEnum::DG->value,
            RoleEnum::SURVEILLANT->value  => Personnel::findOrFail($validate['userable_id']),
        };

        $user = $parent->user()->create($request->safe()->only(['email', 'sexe', 'role']));
        // MailNotificationJob::dispatch($user);
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
        // Gate::authorize('update', $user);
        $parents = match ($user->role->value) {
            'Professeur' => Teacher::select('id', 'prenom', 'nom', 'contact')->get(),
            'Etudiant' => Student::select('id', 'prenom', 'nom', 'reference')->get(),
            'Parent' => Tuteur::select('id', 'prenom', 'nom')->get(),
            'Administration' => Personnel::select('id', 'prenom', 'nom')->get(),
            default => collect(),
        };
        $roles = RoleEnum::all();
        return \inertia('User/Update', compact('user', 'parents', 'roles'));
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
    public function destroy(Request $request, User $user)
    {
        if (Auth::user()->id === $user->id) {
            abort(403, 'Vous ne pouvez pas désactiver votre propre compte');
        }
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $user->update([
            'status' => $request->boolean('status'),
        ]);

        flash()->success(
            $user->status
                ? 'Utilisateur activé avec succès'
                : 'Utilisateur désactivé avec succès'
        );
    }
}
