<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'sub_category_id');
    }

    public function tempProducts()
    {
        return $this->hasMany(TempProduct::class,'sub_category_id');
    }
}
