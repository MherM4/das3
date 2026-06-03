<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['post_id', 'image'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
