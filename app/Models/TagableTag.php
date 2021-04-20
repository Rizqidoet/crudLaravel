<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;

class TagableTag extends Model
{
    use HasFactory;
    use \Conner\Tagging\Taggable;

    protected $fillable = [
        'tag_name',
        'recipes_id'
    ];

    public function recipes(){

        return $this->belongsTo(Recipes::class);
    }

}
