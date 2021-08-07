<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:300',
            'due_date' => 'sometimes|date',
            'has_reminder' => 'required|boolean',
            'reminder.reminder_period_type' => 'required_if:has_reminder,true|string|in:today,day,week,custom',
            'reminder.reminder_count' => 'required_if:reminder.reminder_period_type,day,week|integer',
            'reminder.reminder_time' => 'sometimes|string',
            'reminder.custom_reminder_date' => 'required_if:reminder.reminder_period_type,custom|date',
            'status' => 'sometimes|in:complete,incomplete'
        ];
    }
}
