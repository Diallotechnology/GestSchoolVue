<?php

use Inertia\Inertia;
use App\Enum\RoleEnum;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\DevoirController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\PersonnelController;


Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::middleware('role:' . RoleEnum::ADMIN->value)->group(function () {

    // Route::controller(StudentController::class)->group(function () {
    //     Route::get('student/archive', 'archive')->name('student.archive');
    //     Route::get('student/restore/{id}', 'recover')->whereNumber('id');
    //     Route::delete('student/delete/{id}', 'force_delete')->whereNumber('id');
    // });

    // Route::apiResource('planning', PlanningController::class);
    // Route::post('planning/export', [PlanningController::class, 'export'])->name('planning.export');
    // Route::get('user', UserIndex::class)->name('user.index');
    // Route::get('user/create', UserCreate::class)->name('user.create');
    // Route::get('note/create', NoteCreate::class)->name('note.create');
    Route::resource('user', UserController::class)->except('create');
    Route::resource('student', StudentController::class)->except('create');
    Route::resource('classe', ClasseController::class)->except('create');
    Route::resource('periode', PeriodeController::class)->except('create');
    Route::resource('matiere', MatiereController::class)->except('create');
    Route::resource('tuteur', TuteurController::class)->except('create', 'show');
    Route::resource('teacher', TeacherController::class)->except('create');
    Route::resource('type', TypeController::class)->except('create', 'show');
    Route::resource('filiere', FiliereController::class)->except('create');
    Route::resource('personnel', PersonnelController::class)->except('create');
    Route::resource('note', NoteController::class)->except('create', 'store');
    Route::resource('depense', DepenseController::class)->except('create', 'show');
    // Route::resource('scolarite', ScolariteController::class)->except( 'create');
    Route::resource('ue', UeController::class)->except('create', 'show');
    // });
    Route::middleware('role:' . RoleEnum::TEACHER->value)->group(function () {
        // Route::get('dossier', Dossier::class)->name('dossier');
        // Route::get('etudiant', StudentIndex::class)->name('student.index');
        // Route::resource('cours', CoursController::class)->except('create');
        // Route::resource('devoir', DevoirController::class)->except('create');
        // Route::resource('folder', FolderController::class)->only('show');
        // Route::resource('document', DocumentController::class)->except('create', 'store');
    });
    Route::middleware('role:' . RoleEnum::STUDENT->value)->group(function () {

        // Route::resource('document', DocumentController::class)->only('show');
        // Route::get('document/download/{document}', [DocumentController::class, 'download'])->name('document.download');
        // Route::resource('user', UserController::class)->only('show', 'update');
        // Route::resource('cours', CoursController::class)->only('show');
        // Route::resource('devoir', DevoirController::class)->only('show');
        // Route::get('devoir', Examen::class)->name('devoir');
        // Route::get('course', Course::class)->name('course');
    });

    Route::middleware('role:' . RoleEnum::PARENT->value)->group(function () {
        // Route::get('ue/validation', UeValidation::class)->name('bulletin');
        // Route::get('note', NoteIndex::class)->name('note.index');
        // Route::controller(AdminController::class)->group(function () {
        //     Route::get('/', 'dashboard')->name('dashboard');
        //     Route::get('planning', PlanningIndex::class)->name('planning');
        // });
    });
});

require __DIR__ . '/settings.php';
