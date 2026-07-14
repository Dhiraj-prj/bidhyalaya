<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Program;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [
        'Program_id',
        'subProgram',
        'name',
        'slug',
        'postType',
        'description',
        'yt_iframe',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'hideStatus',
        'created_by',
    ];

    // Define the relationship with the Program model

    // public function program()
    // {
    //     return $this->belongsTo(Program::class, 'program_id');
    // }

    public function program()
    {
        return $this->belongsTo(Program::class, 'Program_id'); // Corrected to 'Program_id'
    }

    public function created_by()
    {
    return $this->belongsTo(User::class, 'created_by','id'); // Adjust 'created_by' if necessary
    }

    public function user()
    {
    return $this->belongsTo(User::class, 'created_by','id'); // Adjust 'created_by' if necessary
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }

    public function files()
    {
        return $this->hasMany(PostFile::class);
    }
}
