<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'body'];

    // Relation entre le commentaire et le post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relation entre le commentaire et l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
