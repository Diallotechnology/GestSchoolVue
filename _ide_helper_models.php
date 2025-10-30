<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Classe
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\ClasseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Classe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe withoutTrashed()
 * @property int $filiere_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read Filiere $filiere
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereFiliereId($value)
 * @property int $scolarite
 * @property int $frais
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $courses
 * @property-read int|null $courses_count
 * @property-read mixed $full_classe_name
 * @property-read mixed $full_name
 * @property-read string $frais_format
 * @property-read string $montant_format
 * @property-read string $scolarite_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static Builder<static>|Classe forUser()
 * @method static Builder<static>|Classe whereFrais($value)
 * @method static Builder<static>|Classe whereScolarite($value)
 * @mixin \Eloquent
 */
	final class Classe extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $type_id
 * @property int $matiere_id
 * @property int $teacher_id
 * @property string $nom
 * @property string|null $reference
 * @property string $description
 * @property string $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classe> $classes
 * @property-read int|null $classes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read Folder|null $folder
 * @property-read mixed $full_name
 * @property-read string|null $deleted_at
 * @property-read \App\Models\Matiere $matiere
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Periode> $periodes
 * @property-read int|null $periodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Teacher $teacher
 * @property-read Type $type
 * @method static \Database\Factories\CourseFactory factory($count = null, $state = [])
 * @method static Builder<static>|Course forUser()
 * @method static Builder<static>|Course newModelQuery()
 * @method static Builder<static>|Course newQuery()
 * @method static Builder<static>|Course query()
 * @method static Builder<static>|Course whereCreatedAt($value)
 * @method static Builder<static>|Course whereDescription($value)
 * @method static Builder<static>|Course whereId($value)
 * @method static Builder<static>|Course whereMatiereId($value)
 * @method static Builder<static>|Course whereNom($value)
 * @method static Builder<static>|Course whereReference($value)
 * @method static Builder<static>|Course whereTeacherId($value)
 * @method static Builder<static>|Course whereTypeId($value)
 * @method static Builder<static>|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $libelle
 * @property int $montant
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUserId($value)
 * @mixin \Eloquent
 */
	final class Depense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Devoir
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $cours_id
 * @property int $classe_id
 * @property int $matiere_id
 * @property string $description
 * @property string $delai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read Cours $cours
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @property-read Teacher $teacher
 * @method static \Database\Factories\DevoirFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir query()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereCoursId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDelai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir withoutTrashed()
 * @property int $periode_id
 * @property string|null $reference
 * @property string $type
 * @property DevoirEnum $etat
 * @property-read Folder|null $folder
 * @property-read string $delai_format
 * @property-read Periode $periode
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereType($value)
 * @property int $course_id
 * @property-read \App\Models\Course $course
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devoir whereCourseId($value)
 * @mixin \Eloquent
 */
	final class Devoir extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Folder|null $folder
 * @property-read string $date_format
 * @property-read User|null $user
 * @method static \Database\Factories\DocumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 * @property int $user_id
 * @property int $folder_id
 * @property string $libelle
 * @property string $extension
 * @property string $chemin
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereChemin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserId($value)
 * @property-read string $delai_format
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @mixin \Eloquent
 */
	final class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Filiere
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\FiliereFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @mixin \Eloquent
 */
	final class Filiere extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Folder
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Document> $documents
 * @property-read int|null $documents_count
 * @property-read Model|Eloquent $folderable
 * @property-read User|null $user
 * @method static \Database\Factories\FolderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Folder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Folder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Folder query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereUpdatedAt($value)
 * @property string $folderable_type
 * @property int $folderable_id
 * @property string $nom
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereFolderableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereFolderableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereNom($value)
 * @mixin \Eloquent
 * @mixin Eloquent
 */
	final class Folder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Matiere
 *
 * @property int $id
 * @property string $nom
 * @property int $coeficient
 * @property string $duree
 * @property string $credit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\MatiereFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCoeficient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Periode> $periodes
 * @property-read int|null $periodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @method static Builder<static>|Matiere forUser()
 * @mixin \Eloquent
 */
	final class Matiere extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $student_id
 * @property int $matiere_id
 * @property string $valeur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @property-read Student $student
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereValeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note withoutTrashed()
 * @property int $user_id
 * @property int $periode_id
 * @property string $type
 * @property-read string $delai_format
 * @property-read Periode $periode
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Note wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUserId($value)
 * @property string $diplome
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereDiplome($value)
 * @mixin \Eloquent
 */
	final class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $reference
 * @property int $user_id
 * @property int $student_id
 * @property int $classe_id
 * @property string $type
 * @property PaymentModeEnum $mode
 * @property string|null $adresse
 * @property string $motif
 * @property int $montant
 * @property int|null $remise
 * @property string|null $remise_motif
 * @property string $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Classe $classe
 * @property-read string $montant_format
 * @property-read string $remise_format
 * @property-read \App\Models\Student $student
 * @property-read User $user
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereRemiseMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUserId($value)
 * @mixin \Eloquent
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Periode
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @method static \Database\Factories\PeriodeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Periode search(?string $term, array $columns = [])
 */
	final class Periode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Personnel
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Database\Factories\PersonnelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereUpdatedAt($value)
 * @property-read mixed $full_name
 * @mixin \Eloquent
 */
	final class Personnel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Planning
 *
 * @property int $id
 * @property int $matiere_id
 * @property int $classe_id
 * @property string $debut
 * @property string $fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @method static \Database\Factories\PlanningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Planning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning query()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning withoutTrashed()
 * @property int $teacher_id
 * @property string $type
 * @property-read string $delai_format
 * @property-read Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereType($value)
 * @property int $periode_id
 * @property string $salle
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \App\Models\Periode $periode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereSalle($value)
 * @mixin \Eloquent
 */
	final class Planning extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $cours_id
 * @property int|null $student_id
 * @property int|null $teacher_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cours $cours
 * @property-read Student|null $student
 * @property-read Teacher|null $teacher
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCoursId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @property int $course_id
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCourseId($value)
 * @mixin \Eloquent
 */
	final class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property int $filiere_id
 * @property int $classe_id
 * @property int $parent_id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property string $naissance
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read Filiere $filiere
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read User|null $user
 * @method static \Database\Factories\StudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFiliereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student withoutTrashed()
 * @property string $sexe
 * @property-read string $delai_format
 * @property-read string $naissance_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Question> $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSexe($value)
 * @property int $tuteur_id
 * @property int $scolarite
 * @property int $frais
 * @property-read \App\Models\Folder|null $folder
 * @property-read mixed $full_name
 * @property-read string $frais_format
 * @property-read string $montant_format
 * @property-read string $scolarite_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Tuteur $tuteur
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFrais($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereScolarite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTuteurId($value)
 * @mixin \Eloquent
 */
	final class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property int|null $salaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @property-read User|null $user
 * @method static \Database\Factories\TeacherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereSalaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Question> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static Builder<static>|Teacher forUser()
 * @mixin \Eloquent
 */
	final class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\TuteurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	final class Tuteur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Type
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read string $date_format
 * @method static \Database\Factories\TypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type withoutTrashed()
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @mixin \Eloquent
 */
	final class Type extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $filiere_id
 * @property int $periode_id
 * @property string $nom
 * @property string $code
 * @property int $credit
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Filiere $filiere
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \App\Models\Periode $periode
 * @method static \Database\Factories\UeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereFiliereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	final class Ue extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string|null $photo
 * @property string $userable_type
 * @property int $userable_id
 * @property string $sexe
 * @property \App\Enum\RoleEnum $role
 * @property string $password
 * @property int $change_password
 * @property int $two_factor_enabled
 * @property string|null $two_factor_expires_at
 * @property int|null $two_factor_code
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int $etat
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Depense> $depenses
 * @property-read int|null $depenses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $userable
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserableType($value)
 */
	class User extends \Eloquent {}
}

