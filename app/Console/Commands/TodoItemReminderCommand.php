<?php

namespace App\Console\Commands;

use App\Models\TodoItem;
use App\Notifications\TodoItemReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class TodoItemReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks for reminders and send reminder notification to the user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        TodoItem::hasUnSentReminder()
            ->itemStatus(TodoItem::INCOMPLETE)
            ->get()
            ->each(static function ($item) {
                if ($item->reminder_date = Carbon::now()->format('Y-m-d H:i:00')) {
                    Notification::send($item->user, new TodoItemReminderNotification($item, $item->user));
                    $item->reminder_sent = true;
                    $item->save();
                }
            });
    }
}
