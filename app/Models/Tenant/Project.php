<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates that the `id` column should be guarded from mass assignment.
     *
     * @var array<string>
     */
    protected $guarded = ['id'];
}
