<?php

declare(strict_types = 1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'accessible_routes',
        'description',
        'full_access',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'accessible_routes' => 'array',
    ];
}
