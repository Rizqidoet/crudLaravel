<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipesImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'recipes_id',
        'user_id'
    ];
    
    public function recipes(){
        return $this->belongsTo(Recipes::class);
    }

}
