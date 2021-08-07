<?php

namespace App\Observers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param TodoItem $todoItem
     * @return void
     */
    public function creating(TodoItem $todoItem): void
    {
        $todoItem->user_id = auth()->user()->id;
    }
}
