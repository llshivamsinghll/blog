<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    // Fillable attributes to allow mass assignment
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'category_id',
        'tags',
        'status',
        'views_count',
    ];

    // Default values for certain attributes
    protected $attributes = [
        'status' => 'draft',
        'views_count' => 0,
    ];

    // Mutator to generate the slug before saving
    public static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (!$article->slug) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // Define the relationship with the author (User model)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Define the relationship with the category (Category model)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Accessor for tags attribute (converts JSON string into array)
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    // Mutator for tags attribute (converts array into JSON string)
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    // Accessor to format created_at and updated_at dates if necessary
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
