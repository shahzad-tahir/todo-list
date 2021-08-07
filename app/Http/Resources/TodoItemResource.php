<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'due_date' => $this->due_date,
            'reminder_date' => $this->reminder_date,
            'status' => $this->status,
            'media' => $this->getMedia(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
