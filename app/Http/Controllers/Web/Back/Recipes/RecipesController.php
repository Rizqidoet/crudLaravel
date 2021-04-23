<?php

namespace App\Http\Controllers\Web\Back\Recipes;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests\Resep\StoreRecipesRequest;
use App\Http\Requests\Resep\UpdateRecipesRequest;

use App\Models\Category;
use App\Models\CookingStep;
use App\Models\Ingredients;
use App\Models\Recipes;
use App\Models\RecipesImage;
use App\Models\tagable_tag;
use App\Models\TagableTag;
use App\Models\Taggable_Tag;

use Symfony\Component\HttpFoundation\Response;

use File;
class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipes::orderBy('created_at' , 'Desc')->get();
        
        //dd($recipes);
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $model = new Recipes;
        $recipeCategories = Category::where([
            ['status', '=', 1],
        ])->get();

        $post_tags = TagableTag::all();
        
        return view('recipes.create')->with(
            [
                'recipeCategories' => $recipeCategories,
                'budgetLists' => $this->budgetList($model),
                'levelLists'=>$this->levelList($model),
                'halalLists'=>$this->halalList($model),
                'vegetarianLists'=>$this->vegetarianList($model),
                'post_tags' => $post_tags,
            ]
        );

        

        //return view('recipes/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //save recipe
        $data = $request->all();
        dd($data);
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 1;
        print_r($data);
        $recipes = Recipes::create($data);

        //save image
        $validatedData = $request->validate([
            'file.*' => 'image|max:1024',
    
        ]);
        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->store('public/storage/recipes/');
        $save = new RecipesImage;
        $save->name = $name;
        $save->path = $path;

        $recipes->recipes_image()->create([
            'name' => $name,
            'path' => $path,
            'user_id' => auth()->user()->id,
        ]);

        //save ingredient & stepcooking
        $request->validate([
            'moreFieldsIngredient.*.ingredient_name' => 'required',
            'moreFieldsStepCooking.*.stepcooking_name' => 'required'
        ]);

        foreach($request->moreFieldsIngredient as $keyIngredient => $valueIngredient){
            $valueIngredient['recipes_id'] = $recipes->id;
            Ingredients::create($valueIngredient);

        }
        foreach($request->moreFieldsStepCooking as $keyStepCooking => $valueStepCooking){
            $valueStepCooking['recipes_id'] = $recipes->id;
            $valueStepCooking['order'] = 0;
            CookingStep::create($valueStepCooking);

        }

        //save tags
        $this->validate($request, [
            'tag_name' => 'required',
        ]);

        $input_tag = $request->all();
        $tags = explode(",", $input_tag['tag_name']);
        $input_tag['recipes_id'] = $recipes->id;
        $post_tag = TagableTag::create($input_tag);
        $post_tag->tag($tags);

        return redirect()->route('recipes.index');
        
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
        $model = new Recipes;
        $recipe = Recipes::find($id);
        $recipeCategories = Category::where([
            ['status', '=', 1],
        ])->get();
        $post_tags = TagableTag::where([
            ['recipes_id', '=', $id]
        ])->first();
        $recipe_image = RecipesImage::where([
            ['recipes_id', '=', $id]
        ])->first();
        $ingredients = Ingredients::where([
            ['recipes_id', '=', $id]
        ])->get();
        $cooking_steps = CookingStep::where([
            ['recipes_id', '=', $id]
        ])->get();
        $idx = 1;
        //dd($ingredients);
        return view('recipes.edit', compact('recipe'))->with([
            'recipeCategories' => $recipeCategories,
            'budgetLists' => $this->budgetList($model),
            'levelLists'=>$this->levelList($model),
            'halalLists'=>$this->halalList($model),
            'vegetarianLists'=>$this->vegetarianList($model),
            'post_tags' => $post_tags,
            'recipe_image' => $recipe_image,
            'ingredients' => $ingredients,
            'cooking_steps' => $cooking_steps,
            'idx' => $idx,
        ]);
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
        //narik data dari view tampung di variable data
        $data = $request->all();
    
        //update resep
        $recipe = Recipes::find($id);
        $recipe->update($data);
        //selesai resep

        //update tags
        $post_tags = TagableTag::where([
            ['recipes_id', '=', $id]
        ])->first();
        $post_tags->update($data);
        //selesai tags

        //proses update bahan dan cara masak
        $request->validate([
            'moreFieldsIngredientUpdate.*.ingredient_name' => 'required',
            'moreFieldsStepCookingpdate.*.stepcooking_name' => 'required'
        ]);
        //Query bahan masak
        $ingredients = Ingredients::where([
            ['recipes_id', '=', $id]
        ])->first();
        $bahan = $data['moreFieldsIngredient'];
            //ubah data
            foreach($bahan as $key => $itemingredient){
                $ingredients = Ingredients::find($key);  
                $ingredients->ingredient_name = $itemingredient['ingredient_name'];
                $ingredients->save();
            }
            //nambah data
            foreach($request->moreFieldsIngredientUpdate as $keyIngredient => $valueIngredient){
                $valueIngredient['recipes_id'] = $recipe->id;
                Ingredients::create($valueIngredient);
            }

        //Query cara masak
        $cooking_steps = CookingStep::where([
            ['recipes_id', '=', $id]
        ])->first();
        $step = $data['moreFieldsStepCooking'];
            //ubah data
            foreach($step as $key => $itemstepcooking){
                $cooking_steps = CookingStep::find($key);

                $cooking_steps->stepcooking_name = $itemstepcooking['stepcooking_name'];
                $cooking_steps->save();
            }
            //nambah data
            foreach($request->moreFieldsStepCookingpdate as $keyStepCooking => $valueStepCooking){
                $valueStepCooking['recipes_id'] = $recipe->id;
                $valueStepCooking['order'] = 0;
                CookingStep::create($valueStepCooking);
            }
        //selesai bahan dan cara masak

        
        
        
        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipes::find($id);
        $recipe->forceDelete();
        return back();
    }

    private function budgetList($model)
    {
        $data = $model->budgetLists();
        return $data;
    }

    private function levelList($model)
    {
        $data = $model->levelLists();
        return $data;
    }

    private function halalList($model)
    {
        $data = $model->halalLists();
        return $data;
    }

    private function vegetarianList($model)
    {
        $data = $model->vegetarianLists();
        return $data;
    }
}
