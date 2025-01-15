<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];

    // Mutator to generate the slug before saving
    public static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            // Generate slug if not already set
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Define the relationship with the parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Define the relationship with child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
