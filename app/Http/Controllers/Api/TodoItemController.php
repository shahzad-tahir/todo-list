<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoItemRequest;
use App\Http\Resources\TodoItemResource;
use App\Jobs\CalculateReminderDateJob;
use App\Models\TodoItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $todoItems = TodoItem::filterItems($request->filter)
            ->orderBy(DB::raw('-`due_date`'), 'desc')
            ->latest()
            ->get();

        return TodoItemResource::collection($todoItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoItemRequest $request
     * @return JsonResponse
     */
    public function store(TodoItemRequest $request): JsonResponse
    {
        $todoItem = TodoItem::create($request->only([
            'title',
            'body',
            'due_date',
            'has_reminder',
            'status'
        ]));

        //saving media
        if ($request->has('media')) {
            $todoItem->addMediaFromRequest('media')
                ->toMediaLibrary();
        }

        // Calculate reminder date of an item
        if ($request->has_reminder) {
            CalculateReminderDateJob::dispatch($request->reminder, $todoItem);
        }

        return response()->json(['message' => 'Item created successfully'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TodoItem $todoItem
     * @return TodoItemResource
     */
    public function edit(TodoItem $todoItem)
    {
        return TodoItemResource::make($todoItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TodoItemRequest $request
     * @param TodoItem $todoItem
     * @return JsonResponse
     */
    public function update(TodoItemRequest $request, TodoItem $todoItem): JsonResponse
    {
        $todoItem->update($request->only([
            'title',
            'body',
            'due_date',
            'has_reminder',
            'status'
        ]));

        // Saving media
        if ($request->has('media')) {
            $todoItem->clearMediaCollection();
            $todoItem->addMediaFromRequest('media')
                ->toMediaLibrary();
        }

        // Calculate reminder date of an item
        if ($request->has_reminder) {
            CalculateReminderDateJob::dispatch($request->reminder, $todoItem);
        }

        return response()->json(['message' => 'Item updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TodoItem $todoItem
     * @return JsonResponse
     */
    public function destroy(TodoItem $todoItem): JsonResponse
    {
        $todoItem->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }

    /**
     * Mark item as complete/incomplete
     *
     * @param Request $request
     * @param TodoItem $todoItem
     * @return JsonResponse
     */
    public function changeStatus(Request $request, TodoItem $todoItem): JsonResponse
    {
        $todoItem->status = $request->status;
        $todoItem->save();

        return response()->json(['message' => 'Item status updated successfully']);
    }
}
