<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookingStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'stepcooking_name',
        'recipes_id',
        'order'
    ];
    
    protected $guarded = [];
    public function recipes()
    {
        return $this->belongsTo(Recipes::class);
    }
}
