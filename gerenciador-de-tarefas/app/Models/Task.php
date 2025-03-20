<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'user_id',
        'completed',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
