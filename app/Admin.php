<?php

declare(strict_types = 1);

namespace App;

use App\Notifications\ResetPasswordNotification;
use App\Traits\RoleTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Admin
 *
 * @package App
 */
class Admin extends Authenticatable
{
    use Notifiable, RoleTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
}
