<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'levelType',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'navbarHiddenStatus',
        'hideStatus',
        'created_by', // Ensure this field is fillable
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by'); // Link to the User model
    }

    public function posts()
{
    return $this->hasMany(Post::class, 'program_id'); // Assuming 'program_id' is the foreign key in the 'posts' table
}
}
