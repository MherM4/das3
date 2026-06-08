<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
    use HasFactory;
    
    protected $fillable = ['name'];

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
