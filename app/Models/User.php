<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The database connection to use for this model.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
        ];
    }

    /**
     * Get the tenants that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Tenant::class,
            table: 'tenant_user',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'tenant_id',
        );
    }

    /**
     * Get the domain associated with the user through the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function domain()
    {
        return $this->hasOneThrough(
            related: Domain::class,
            through: Tenant::class,
            firstKey: 'id',
            secondKey: 'tenant_id'
        );
    }
}
