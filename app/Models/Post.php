<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public $fillable = [
        'title',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
