<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title', 
        'content',
        'image_path',
        'is_published',
    ];

    //Relacion uno a muchos inversa.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //Relacion muchos a muchos.
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
