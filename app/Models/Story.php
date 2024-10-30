<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'media_path', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to get only active stories
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }
}
