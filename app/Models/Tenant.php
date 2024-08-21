<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasUuids;

    /**
     * Get the name of the tenant key.
     *
     * @return string
     */
    public function getTenantKeyName(): string
    {
        return 'name';
    }

    /**
     * Get the custom columns to be returned for the Tenant model.
     *
     * @return array
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
        ];
    }

    /**
     * Get the domain associated with the tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManu
     */
    public function domain(): HasMany
    {
        return $this->hasMany(
            related: Domain::class,
            foreignKey: 'tenant_id',
            localKey: 'id'
        );
    }
}
