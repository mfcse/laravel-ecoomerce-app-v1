<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function parent_category()
    {
        //return $this->belongsTo(Category::class);
        return $this->belongsTo(__CLASS__);
    }
    public function child_category()
    {
        //return $this->hasMany(Category::class);
        return $this->hasMany(__CLASS__);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}