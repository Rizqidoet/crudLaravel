<?php

namespace App\Http\Controllers\Web\Back\Recipes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Events\RecipesCreated;
use App\Http\Requests\Resep\StoreRecipesRequest;
use App\Http\Requests\Resep\UpdateRecipesRequest;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\CookingStep;
use App\Models\Ingredients;
use App\Models\Recipes;
use App\Models\RecipesImage;
use App\Models\tagable_tag;
use App\Models\TagableTag;
use App\Models\Taggable_Tag;
use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpFoundation\Response;

use File;
use Validator;
use Event;
use Session;
use function PHPUnit\Framework\isEmpty;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipes::orderBy('status' , 'asc')->get();
        
        //dd($recipes);
        return view('recipes.index', compact('recipes'));
    }
//--------------------------------------------------------------------------------------//
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
        );//return view('recipes/create');
    }
//--------------------------------------------------------------------------------------//

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //request value dari view
        $data = $request->all();
        //dd($data);

    //------------------------------------------------------------------------------//    
        
        //save recipe
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 0;
        //dd($data);
        $recipes = Recipes::create($data);

        
        //end save recipe

    //------------------------------------------------------------------------------//
        //save image
        $request->validate([
            'moreFieldsIngredient.*.ingredient_name' => 'required',
            'moreFieldsStepCooking.*.stepcooking_name' => 'required',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        if($image = $request->file('path')){
            $destinationPath = 'storage/ImagesRecipes/';
            $profileImage = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['path'] = "$profileImage";
            $data['recipes_id'] = $recipes->id;
            $data['user_id'] = Auth::user()->id;
        }
        RecipesImage::create($data);
        //end save image

    //------------------------------------------------------------------------------//
        
        //save tags
        $this->validate($request, [
            'tag_name' => 'required',
        ]);

        $input_tag = $request->all();
        $tags = explode(",", $input_tag['tag_name']);
        $input_tag['recipes_id'] = $recipes->id;
        $post_tag = TagableTag::create($input_tag);
        $post_tag->tag($tags);
        //end save tags

    //------------------------------------------------------------------------------//
        
        //save ingredient & stepcooking
        foreach($request->moreFieldsIngredient as $keyIngredient => $valueIngredient){
            //dd($request->moreFieldsIngredient);
            $valueIngredient['recipes_id'] = $recipes->id;
            Ingredients::create($valueIngredient);

        }
        foreach($request->moreFieldsStepCooking as $keyStepCooking => $valueStepCooking){
            $valueStepCooking['recipes_id'] = $recipes->id;
            CookingStep::create($valueStepCooking);

        }
        //end save ingredient & stepcooking
    //------------------------------------------------------------------------------//
        //back ke index menu
        //$request->session()->flash('ID', $recipes->id);
       

        RecipesCreated::dispatch($recipes->id);
        /*return redirect()->route('recipes.index')
        ->with('success',$recipes->id);
        */
        }
//--------------------------------------------------------------------------------------//
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //narik data dari view tampung di variable data
        $data = $request->all();
        //print_r($data);
        
    //--------------------------------------------------------------------------------//

        //update resep
        $recipe = Recipes::find($id);
        $recipe['status'] = 1;
        $recipe->update($data);
        //selesai resep
    //-------------------------------------------------------------------------------//
    
    return redirect()->route('recipes.index')
        ->with('Updated','Success - Data Updated to Publish!');

    }
//--------------------------------------------------------------------------------------//
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
//--------------------------------------------------------------------------------------//
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
            //print_r($data);

        //--------------------------------------------------------------------------------//

            //update resep
            $recipe = Recipes::find($id);
            $recipe->update($data);
            //selesai resep
        //--------------------------------------------------------------------------------//

            //update Image
            if($image = $request->file('path')){
                print_r('Data Terupdate');
                //dd($data);
                
                $destinationPath = 'storage/ImagesRecipes/';
                $profileImage = date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $data['path'] = "$profileImage";

                $recipe_image = RecipesImage::where([
                    ['recipes_id', '=', $id]
                ])->first();
                    $recipe_image->path = $data['path'];
                    //dd($data);
                    $recipe_image->save();
                    
            }else{
                print_r('Data Tidak Terupdate');
                unset($data['path']);
            }
            //end update image

        //--------------------------------------------------------------------------------//

            //update tags
            $post_tags = TagableTag::where([
                ['recipes_id', '=', $id]
            ])->first();
            //dd($post_tags);
            $post_tags->update($data);
            //selesai tags
            
        //--------------------------------------------------------------------------------//
            
            //update ingredient
            if(isset($data['moreFieldsIngredientUpdate'])){
                print_r('ada input update ');
                
                $ingredients = Ingredients::where([
                    ['recipes_id', '=', $id]
                ])->get();
                $ingredientsDB = count($ingredients);
                $ingredientsLoad = count($data['moreFieldsIngredient']);
                $ingredientsView = $data['moreFieldsIngredientUpdate'];
                $ingredientsViewsUpdate = count($ingredientsView);

                $totalIngredientView = $ingredientsLoad + $ingredientsViewsUpdate;


                print_r('/ Ingredient DB = '.$ingredientsDB.' / ');
                print_r('Ingredient Load = '.$ingredientsLoad.' / ');
                print_r('Ingredient View = '.$ingredientsViewsUpdate.' / ');
                print_r('Total Input Ingredient = '.$totalIngredientView.' / ');
                
                $arrayDbIngredient = $data['hiddenInputIngredient'];
                $arrayViewIngredient = $data['moreFieldsIngredient'];
                print_r($arrayDbIngredient);
                print_r($arrayViewIngredient);
                $compareArrayIngredient = array_diff_key($arrayDbIngredient, $arrayViewIngredient);
                print_r($compareArrayIngredient);
                
                foreach($compareArrayIngredient as $keyIngredient => $valueCompareArrayIngredient ){

                    if(isEmpty($keyIngredient)){
                        print_r('Ada Data Yang Dihapus yaitu = '.$keyIngredient);
                        
                        $valueIngredient = Ingredients::find($keyIngredient);
                        $valueIngredient->forceDelete();
                    }                
                }
                //nambah data
                foreach($ingredientsView as $valueIngredientsView){
                    //dd($valueIngredient);
                    $valueIngredientsView['recipes_id'] = $recipe->id;
                    Ingredients::create($valueIngredientsView);
                }
                //ubah data
                foreach($arrayViewIngredient as $keyIngredient => $valueArrayView){
                    //dd($keyIngredient);
                    $ingredients = Ingredients::find($keyIngredient);  
                    $ingredients->ingredient_name = $valueArrayView;
                    $ingredients->save();
                }
            }else{
                print_r('tidak ada input update');

                $ingredients = Ingredients::where([
                    ['recipes_id', '=', $id]
                ])->get();
                $ingredientsDB = count($ingredients);
                $ingredientsLoad = count($data['moreFieldsIngredient']);
                $ingredientsView = 0;
                $ingredientsViewsUpdate = $ingredientsView;
                $totalIngredientView = $ingredientsLoad + $ingredientsViewsUpdate;

                print_r('/ Ingredient DB = '.$ingredientsDB.' / ');
                print_r('Ingredient Load = '.$ingredientsLoad.' / ');
                print_r('Ingredient View = '.$ingredientsViewsUpdate.'  ');
                print_r('Total Input Ingredient = '.$totalIngredientView.' / ');

                $arrayDbIngredient = $data['hiddenInputIngredient'];
                $arrayViewIngredient = $data['moreFieldsIngredient'];
                print_r($arrayDbIngredient);
                print_r($arrayViewIngredient);
                $compareArrayIngredient = array_diff_key($arrayDbIngredient, $arrayViewIngredient);
                print_r($compareArrayIngredient);

                foreach($compareArrayIngredient as $keyIngredient => $valueCompareArrayIngredient ){

                    if(isEmpty($keyIngredient)){
                        print_r('Ada Data Yang Dihapus yaitu = '.$keyIngredient);
                        $valueIngredient = Ingredients::find($keyIngredient);
                        $valueIngredient->forceDelete();
                    }                
                }

                //ubah data
                foreach($arrayViewIngredient as $keyIngredient => $valueArrayView){
                    //dd($keyIngredient);
                    $ingredients = Ingredients::find($keyIngredient);  
                    $ingredients->ingredient_name = $valueArrayView;
                    $ingredients->save();
                }

            }
            //end update ingredient

        //--------------------------------------------------------------------------------//
            
            //update Step Cooking
            if(isset($data['moreFieldsStepCookingUpdate'])){
                print_r('ada input update ');
                
                $stepCookings = CookingStep::where([
                    ['recipes_id', '=', $id]
                ])->get();
                $stepCookingsDB = count($stepCookings);
                $stepCookingsLoad = count($data['moreFieldsStepCooking']);
                $stepCookingsView = $data['moreFieldsStepCookingUpdate'];
                $stepCookingsViewsUpdate = count($stepCookingsView);

                $totalStepCookingView = $stepCookingsLoad + $stepCookingsViewsUpdate;


                print_r('/ StepCooking DB = '.$stepCookingsDB.' / ');
                print_r('StepCooking Load = '.$stepCookingsLoad.' / ');
                print_r('StepCooking View = '.$stepCookingsViewsUpdate.' / ');
                print_r('Total Input StepCooking = '.$totalStepCookingView.' / ');

                $arrayDbStepCooking = $data['hiddenInputStepCooking'];
                $arrayViewStepCooking = $data['moreFieldsStepCooking'];
                print_r($arrayDbStepCooking);
                print_r($arrayViewStepCooking);
                $compareArrayStepCooking = array_diff_key($arrayDbStepCooking, $arrayViewStepCooking);
                print_r($compareArrayStepCooking);

                foreach($compareArrayStepCooking as $keyStepCooking => $valueCompareArray ){

                    if(isEmpty($keyStepCooking)){
                        print_r('Ada Data Yang Dihapus yaitu = '.$keyStepCooking);
                        $valueStepCooking = CookingStep::find($keyStepCooking);
                        $valueStepCooking->forceDelete();
                    }                
                }
                //nambah data
                foreach($stepCookingsView as $valueStepCookingsView){
                    //dd($valueStepCooking);
                    $valueStepCookingsView['recipes_id'] = $recipe->id;
                    CookingStep::create($valueStepCookingsView);
                }
                //ubah data
                foreach($arrayViewStepCooking as $keyStepCooking => $valueArrayView){
                    //dd($keyStepCooking);
                    $stepCookings = CookingStep::find($keyStepCooking);  
                    $stepCookings->StepCooking_name = $valueArrayView;
                    $stepCookings->save();
                }
            }else{
                print_r('tidak ada input update');
                
                $stepCookings = CookingStep::where([
                    ['recipes_id', '=', $id]
                ])->get();
                $stepCookingsDB = count($stepCookings);
                $stepCookingsLoad = count($data['moreFieldsStepCooking']);
                $stepCookingsView = 0;
                $stepCookingsViewsUpdate = $stepCookingsView;
                $totalStepCookingView = $stepCookingsLoad + $stepCookingsViewsUpdate;

                print_r('/ StepCooking DB = '.$stepCookingsDB.' / ');
                print_r('StepCooking Load = '.$stepCookingsLoad.' / ');
                print_r('StepCooking View = '.$stepCookingsViewsUpdate.'  ');
                print_r('Total Input StepCooking = '.$totalStepCookingView.' / ');

                $arrayDbStepCooking = $data['hiddenInputStepCooking'];
                $arrayViewStepCooking = $data['moreFieldsStepCooking'];
                print_r($arrayDbStepCooking);
                print_r($arrayViewStepCooking);
                $compareArrayStepCooking = array_diff_key($arrayDbStepCooking, $arrayViewStepCooking);
                print_r($compareArrayStepCooking);

                foreach($compareArrayStepCooking as $keyStepCooking => $valueCompareArray ){

                    if(isEmpty($keyStepCooking)){
                        print_r('Ada Data Yang Dihapus yaitu = '.$keyStepCooking);
                        $valueStepCooking = CookingStep::find($keyStepCooking);
                        $valueStepCooking->forceDelete();
                    }                
                }

                //ubah data
                foreach($arrayViewStepCooking as $keyStepCooking => $valueArrayView){
                    //dd($keyStepCooking);
                    $stepCookings = CookingStep::find($keyStepCooking);  
                    $stepCookings->StepCooking_name = $valueArrayView;
                    $stepCookings->save();
                }

            }
            //end update step cooking

        //--------------------------------------------------------------------------------//
        //$request->session()->flash($recipe->id, 'id');
        return redirect()->route('recipes.index')
        ->with('success','Data has been created as a draft!');
    }
//---------------------------------------------------------------------------------------//

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

//---------------------------------------------------------------------------------------//

    private function budgetList($model)
    {
        $data = $model->budgetLists();
        return $data;
    }

//---------------------------------------------------------------------------------------//

    private function levelList($model)
    {
        $data = $model->levelLists();
        return $data;
    }

//---------------------------------------------------------------------------------------//

    private function halalList($model)
    {
        $data = $model->halalLists();
        return $data;
    }

//---------------------------------------------------------------------------------------//

    private function vegetarianList($model)
    {
        $data = $model->vegetarianLists();
        return $data;
    }

//---------------------------------------------------------------------------------------//

    public function Draft(){
        print_r("Masuk Function Draft");
        die();
    }

}
