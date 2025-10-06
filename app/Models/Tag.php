<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    public function posts() {        // inverse for posts
        return $this->morphedByMany(Post::class, 'taggable');
    }
    public function videos() {       // inverse for videos
        return $this->morphedByMany(Video::class, 'taggable');
    }
}
