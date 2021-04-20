<?php

namespace App\Models;

use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    protected $guarded = [];

    use HasFactory;
    //use Taggable;

    public $table = 'recipes';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'stories',
        'serving',
        'preptime',
        'cooktime',
        'calories',
        'level',
        'budget',
        'status',
        'ishalal',
        'isvegan',
        'created_at',
        'updated_at',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredients::class);
    }

    public function cooking_steps()
    {
        return $this->hasMany(CookingStep::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipes_image()
    {
        return $this->hasMany(RecipesImage::class);
    }

    public function taggable_tag()
    {
        return $this->hasMany(TagableTag::class);
    }

    public function budgetLists()
    {
        $data = array(
            ['id' => 1, 'name' => '5.000 - 10.000'],
            ['id' => 2, 'name' => '10.000 - 50.000'],
            ['id' => 3, 'name' => '50.000 - 100.000'],
            ['id' => 4, 'name' => '100.000 - 500.000'],
            ['id' => 5, 'name' => '500.000 - 1.000.000'],
        );
        return $data;
    }

    public function levelLists(){
        $data = array(
            ['id'=>1,'name'=>'Belum pernah memasak'],
            ['id'=>2,'name'=>'Pemula'],
            ['id'=>3,'name'=>'Mahir memasak']
        );

        return $data;
    }

    public function halalLists(){
        $data = array(
            ['id'=>1,'name'=>'Yes'],
            ['id'=>2,'name'=>'No'],
        );

        return $data;
    }

    public function vegetarianLists(){
        $data = array(
            ['id'=>1,'name'=>'Yes'],
            ['id'=>2,'name'=>'No'],
        );

        return $data;
    }
}
