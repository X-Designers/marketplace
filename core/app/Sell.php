<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
}
