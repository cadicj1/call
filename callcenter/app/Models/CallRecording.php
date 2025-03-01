<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallRecording extends Model
{
    use HasFactory;

    protected $fillable = ['call_id', 'url', 'duration'];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }
}
