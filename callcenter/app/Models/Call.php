<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Call extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = [
        'caller_number',
        'agent_id',
        'status',
        'duration',
        'notes',
        'call_type',
        'recording_url',
        'started_at',
        'ended_at',
        'priority',
        'category'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration' => 'integer',
    ];

    // Relationships
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function notes()
    {
        return $this->hasMany(CallNote::class);
    }

    public function recordings()
    {
        return $this->hasMany(CallRecording::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['queued', 'in-progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeMissed($query)
    {
        return $query->where('status', 'missed');
    }

    // Helper methods
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'ended_at' => now(),
            'duration' => $this->started_at ? now()->diffInSeconds($this->started_at) : null
        ]);
    }

    public function markAsMissed()
    {
        $this->update([
            'status' => 'missed',
            'ended_at' => now()
        ]);
    }
}
