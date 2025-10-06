<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function images()   { return $this->morphMany(Image::class, 'imageable'); }
    public function tags()     { return $this->morphToMany(Tag::class, 'taggable'); }
}
