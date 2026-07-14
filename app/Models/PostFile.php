<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'file_path', 'file_name',
    ];

    // Define the relationship with the Post model
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
