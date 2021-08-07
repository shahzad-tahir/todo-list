<?php

namespace App\Jobs;

use App\Models\TodoItem;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CalculateReminderDateJob
{
    use Dispatchable, SerializesModels;

    /**
     * @var $remainderDetails
     */
    public $remainderDetails;

    /**
     * @var TodoItem
     */
    public $todoItem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($remainderDetails, TodoItem $todoItem)
    {
        $this->remainderDetails = $remainderDetails;
        $this->todoItem = $todoItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reminderDate = '';

        switch ($this->remainderDetails['reminder_period_type']) {
            case TodoItem::TYPE_TODAY:
                $reminderDate = Carbon::now()
                    ->setTimeFromTimeString($this->remainderDetails['reminder_time'] ?? '00:00')
                    ->format('Y-m-d H:i:s');
                break;
            case TodoItem::TYPE_DAY:
                $reminderDate = Carbon::now()
                    ->addDays($this->remainderDetails['reminder_count'])
                    ->setTimeFromTimeString($this->remainderDetails['reminder_time'] ?? '00:00')
                    ->format('Y-m-d H:i:s');
                break;
            case TodoItem::TYPE_WEEK:
                $reminderDate = Carbon::now()
                    ->addWeeks($this->remainderDetails['reminder_count'])
                    ->setTimeFromTimeString($this->remainderDetails['reminder_time'] ?? '00:00')
                    ->format('Y-m-d H:i:s');
                break;
            case TodoItem::TYPE_CUSTOM:
                $reminderDate = Carbon::parse( $this->remainderDetails['custom_reminder_date'])
                    ->setTimeFromTimeString($this->remainderDetails['reminder_time'] ?? '00:00')
                    ->format('Y-m-d H:i:s');
                break;
        }

        $this->todoItem->update([
           'reminder_date' => $reminderDate
        ]);
    }
}
