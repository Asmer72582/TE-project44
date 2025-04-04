<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanbanTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'group_no',
        'assigned_to',
        'created_by',
        'due_date',
        'priority'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    /**
     * Get the user that the task is assigned to
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user that created the task
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
