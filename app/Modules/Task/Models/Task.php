<?php

namespace App\Modules\Task\Models;

use App\Modules\Task\Enums\TaskStatus;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'due_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeByStatus($query, ?TaskStatus $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeByDueDate($query, ?string $dueDate)
    {
        if ($dueDate && !empty(trim($dueDate))) {
            try {
                // Remove qualquer parte de hora se existir
                $cleanDate = explode(' ', trim($dueDate))[0];
                $date = Carbon::parse($cleanDate)->format('Y-m-d');
                return $query->whereDate('due_date', $date);
            } catch (\Exception $e) {
                return $query;
            }
        }
        return $query;
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status === TaskStatus::Open;
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::Done;
    }
} 