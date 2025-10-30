<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
final class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cours_id',
        'student_id',
        'teacher_id',
        'message',
    ];

    /**
     * Get the student that owns the Question
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the teacher that owns the Question
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the course that owns the Question
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    private function getCreatedAtAttribute(string $date): string
    {
        Carbon::setLocale('fr');

        return Carbon::parse($date)->diffForHumans();
    }
}
