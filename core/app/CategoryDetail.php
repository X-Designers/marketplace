<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
