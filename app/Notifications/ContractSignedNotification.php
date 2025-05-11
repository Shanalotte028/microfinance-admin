<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractSignedNotification extends Notification
{
    use Queueable;

    public $contract;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contract $contract)
    {
        //
        $this->contract = $contract;
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
    // app/Notifications/ContractSignedNotification.php
    public function toMail($notifiable)
    {
        // Determine who signed (client or user)
        $signer = $this->contract->client ?? $this->contract->user;
        
        // Determine who should be notified (admin or another party)
        $notificationMessage = $notifiable->isAdmin() 
            ? "{$signer->first_name} ({$signer->email}) has signed the contract."
            : "Your contract #{$this->contract->id} has been successfully signed.";
    
        return (new MailMessage)
            ->subject("Contract #{$this->contract->id} Signed")
            ->line($notificationMessage)
            ->action('View Contract', route('admin.contracts.show', $this->contract));
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
