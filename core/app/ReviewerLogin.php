<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewerLogin extends Model
{
    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class);
    }
}
