<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_name',
        'recipes_id'
    ]; 

    protected $guarded = [];
    public function recipes()
    {
        return $this->belongsTo(Recipes::class);
    }
}
