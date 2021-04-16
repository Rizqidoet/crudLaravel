<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taggable_Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function recipes()
    {
        return $this->belongsTo(Recipes::class);
    }
}
