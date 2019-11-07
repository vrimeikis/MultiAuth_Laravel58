<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait RoleTrait
 *
 * @package App\Traits
 */
trait RoleTrait
{
    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany {
        return $this->belongsToMany(
            Role::class,
            'admin_role',
            'admin_id',
            'role_id'
        );
    }
}