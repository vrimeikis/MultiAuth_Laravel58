<?php

declare(strict_types = 1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

/**
 * Class ResetPasswordNotification
 *
 * @package App\Notifications
 */
class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct(string $token) {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject(Lang::get('Reset Admin Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your admin account.'))
            ->action(
                Lang::get('Reset Password'),
                url(config('app.url') . route('admin.password.reset',
                        ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()],
                        false
                    )
                )
            )
            ->line(
                Lang::get('This password reset link will expire in :count minutes.',
                    [':count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]
                )
            )
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
