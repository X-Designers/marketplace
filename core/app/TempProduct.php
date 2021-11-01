<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempProduct extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'tag' => 'array',
        'category_details' => 'array',
        'screenshot' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
