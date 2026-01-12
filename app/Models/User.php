<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\RoleEnum;
use App\Helper\CacheHelper;
use App\Helper\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, CacheHelper, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'role',
        'sexe',
        'status',
        'change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'role' => RoleEnum::class,
            'status' => 'boolean',
            'change_password' => 'boolean',
        ];
    }

    protected static array $cacheKeys = [
        'count_users',
    ];

    /**
     * Get the parent userable model (Student,Teacher,Administration or Parent).
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    public function name_view(): string
    {

        return $this->userable ? $this->userable->prenom . ' ' . $this->userable->nom : 'inexistant';
    }


    public function DocLink(): string
    {
        return Storage::url($this->photo);
    }

    public function getPhoto(): string
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }

        return match ($this->sexe) {
            'Homme' => asset('images/avatars/h.svg'),
            'Femme' => asset('images/avatars/f.svg'),
            default => '', // au cas où sexe serait vide ou autre
        };
    }

    /**
     * Get all of the depenses for the User
     */
    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }

    /**
     * Get all of the scolarites for the User
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
