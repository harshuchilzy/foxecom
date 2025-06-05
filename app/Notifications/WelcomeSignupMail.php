<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeSignupMail extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailData = [
            'user' => $this->user,
            'name' => $this->user->first_name . ' ' . $this->user->last_name,
            'company_name' => $this->user->company_name,
            'store_name' => $this->user->store_name,
            'store_url' => $this->user->store_url,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'country_code' => $this->user->country_code,
            'company_type' => $this->user->company_type,
            'company_registration' => $this->user->company_registration,
            'company_sector' => $this->user->company_sector,
            'registration_certificate' => $this->user->registration_certificate,
            'vat_certificate' => $this->user->vat_certificate,
            'proof_of_id' => $this->user->proof_of_id,
            'proof_of_address' => $this->user->proof_of_address
        ];
        
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
