<?php

namespace App\Notifications;

use App\Models\TodoItem;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TodoItemReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var TodoItem */
    private $todoItem;

    /** @var User */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TodoItem $todoItem, User $user)
    {
        $this->todoItem = $todoItem;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hi '. $this->user->name)
                    ->line('This is a reminder for '.$this->todoItem->title)
                    ->line('Thank you for using our application!');
    }
}
