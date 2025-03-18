<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $frontendUrl = "http://localhost:3001/ResetPassword?token={$this->token}&email=" . urlencode($this->email);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->line('Click the button below to reset your password.')
            ->action('Reset Password', $frontendUrl)
            ->line('If you did not request a password reset, no further action is required.')
            ->line("If you're having trouble, copy and paste this URL into your browser:")
            ->line($frontendUrl);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
