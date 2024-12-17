<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'content',
        'author_id',
        'publication_date',
        'category_id',
    ];

    /**
     * Post model relationship with author
     * Get the user (author) that owns the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Post model relationship with category
     * Get the category associated with the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
