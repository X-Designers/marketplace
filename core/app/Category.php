<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function categoryDetails()
    {
        return $this->hasMany(CategoryDetail::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tempProducts()
    {
        return $this->hasMany(TempProduct::class);
    }
}
