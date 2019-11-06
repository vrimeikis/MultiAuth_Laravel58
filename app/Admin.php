<?php

declare(strict_types = 1);

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Admin
 *
 * @package App
 */
class Admin extends Authenticatable
{
    use Notifiable;

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

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
}
