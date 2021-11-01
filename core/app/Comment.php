<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public function user(){

        return $this->belongsTo(User::class);
    }
    public function product(){

        return $this->belongsTo(Product::class);
    }
    public function replies(){

        return $this->hasMany(Reply::class);
    }
}
