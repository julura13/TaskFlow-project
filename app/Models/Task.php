<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * Status order for list display: Pending, In Progress, Completed (last).
     */
    public function scopeOrderByStatus(Builder $query): Builder
    {
        $driver = $query->getConnection()->getDriverName();
        $statusColumn = $query->getModel()->getTable() . '.status';

        if ($driver === 'mysql') {
            return $query->orderByRaw(
                "FIELD({$statusColumn}, 'pending', 'in_progress', 'completed')"
            );
        }

        return $query->orderByRaw(
            "CASE {$statusColumn} WHEN 'pending' THEN 1 WHEN 'in_progress' THEN 2 WHEN 'completed' THEN 3 ELSE 4 END"
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'assigned_to',
        'event_type',
        'old_values',
        'new_values',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'project_id' => 'integer',
            'assigned_to' => 'integer',
            'status' => Status::class,
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function taskHistories(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }
}
