<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public string $token;

    /**
     * Password reset notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Send password reset link to user
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::error(print_r($this->token, true));
        return (new MailMessage)
            ->subject('Password Reset Link')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $this->token)
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
