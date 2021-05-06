<?php

namespace App\Http\Controllers\Web\Back\Recipes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Recipes;
use App\Models\RecipesImage;

class RecipesFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = DB::table('recipes')
            ->join('recipes_images', 'recipes.id', '=', 'recipes_images.recipes_id')
            ->select('recipes.id', 'recipes.title', 'recipes_images.path')
            ->orderBy('recipes.created_at','desc')
            ->get();

            // dd($recipes);
        return view('recipes.recipesFront', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipes = DB::table('recipes')
            ->join('recipes_images', 'recipes.id', '=', 'recipes_images.recipes_id')
            ->join('ingredients', 'recipes.id', '=', 'ingredients.recipes_id')
            ->join('cooking_steps', 'recipes.id', '=', 'cooking_steps.recipes_id')
            ->join('tagable_tags', 'recipes.id', '=', 'tagable_tags.recipes_id')
            ->select('recipes.*', 'recipes_images.path','ingredients.ingredient_name','cooking_steps.stepcooking_name','tagable_tags.tag_name')
            ->where('recipes.id', '=', $id)
            ->orderBy('recipes.created_at','desc')
            ->first();
            // foreach($recipes as $key => $valueRecipes){
            //     //dd($valueRecipes);
            // }
            dd($recipes->title);

            return view('recipes.recipesFrontDetail', compact('recipes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
