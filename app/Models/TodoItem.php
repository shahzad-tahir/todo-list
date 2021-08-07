<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TodoItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Constants
     */
    public const COMPLETE = 'complete';
    public const INCOMPLETE = 'incomplete';
    public const TYPE_TODAY = 'today';
    public const TYPE_DAY = 'day';
    public const TYPE_WEEK = 'week';
    public const TYPE_CUSTOM = 'custom';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'due_date',
        'has_reminder',
        'reminder_date',
        'status',
        'reminder_sent',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_reminder' => 'boolean',
        'reminder_sent' => 'boolean',
        'reminder_date' => 'datetime',
        'due_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Query items of given status.
     *
     * @param Builder $query
     * @param null $filter
     * @return Builder
     */
    public function scopeFilterItems(Builder $query, $filter = null): Builder
    {
        return $query->when($filter, function ($query, $filter) {
            return $query->where('status', $filter);
        });
    }

    /**
     * Gets the status of the item based on parameter
     *
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeItemStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Adds a clause which checks whether the item has reminder or not
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasUnSentReminder($query)
    {
        return $query->whereNotNull('reminder_date')
            ->where('reminder_sent', false);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the detail of the todoitem creator
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
