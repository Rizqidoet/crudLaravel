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
        //request value dari view
        $data = $request->all();
        //dd($data);

        //save recipe
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 1;
        //dd($data);
        $recipes = Recipes::create($data);
        //end save recipe

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
        
        //save ingredient & stepcooking
        foreach($request->moreFieldsIngredient as $keyIngredient => $valueIngredient){
            //dd($request->moreFieldsIngredient);
            $valueIngredient['recipes_id'] = $recipes->id;
            Ingredients::create($valueIngredient);

        }
        foreach($request->moreFieldsStepCooking as $keyStepCooking => $valueStepCooking){
            $valueStepCooking['recipes_id'] = $recipes->id;
            $valueStepCooking['order'] = 0;
            CookingStep::create($valueStepCooking);

        }
        //end save ingredient & stepcooking

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

        //back ke index menu
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
        //dd($data);

//-------------------------------------------------------------------------------------------------------//

        //update resep
        $recipe = Recipes::find($id);
        $recipe->update($data);
        //selesai resep
//------------------------------------------------------------------------------------------------------//

        // //update image
        // $request->validate([
        //     'moreFieldsIngredientUpdate.*.ingredient_name' => 'required',
        //     'moreFieldsStepCookingpdate.*.stepcooking_name' => 'required',
        //     'path' => 'required'
        // ]);
            
        // if($image = $request->file('path')){
        //     $destinationPath = 'storage/ImagesRecipes/';
        //     $profileImage = date('YmdHis').'.'.$image->getClientOriginalExtension();
        //     $image->move($destinationPath, $profileImage);
        //     $data['path'] = "$profileImage";
        // }else{
        //     unset($data['path']);
        // }

        // $recipe_image = RecipesImage::where([
        //     ['recipes_id', '=', $id]
        // ])->first();
        //     $recipe_image->path = $data['path'];
        //     //dd($data);
        //     $recipe_image->save();
        // //end update image

//------------------------------------------------------------------------------------------------------//

        // //update tags
        // $post_tags = TagableTag::where([
        //     ['recipes_id', '=', $id]
        // ])->first();
        // //dd($post_tags);
        // $post_tags->update($data);
        // //selesai tags
        

//------------------------------------------------------------------------------------------------------//     
        //update ingredient

        //Query bahan masak berdasarkan recipes_id
        $ingredientsAwal = Ingredients::where([
            ['recipes_id', '=', $id]
        ])->get();
        //menghitung jumlah asli record dari db
        $ingredientsDB = count($ingredientsAwal);        
        //menghitung jumlah record setelah diupdate
        //$ingredients = $data['moreFieldsIngredient'];
        $ingredientsView = count($data['moreFieldsIngredient']);

        //print_r($ingredientsDB);
        //print_r($ingredientsView);
        
        //lalu cek apakah ada penambahan data baru atau tidak, karna input untuk penambahan
        //data baru dengan data yang gua panggil dari DB Berbeda name di input nya 
        if(isset($data['moreFieldsIngredientUpdate'])){
            print_r('ada input update');
            
            $ingredients2 = $data['moreFieldsIngredientUpdate'];
            $ingredientsView2 = count($ingredients2);
            //print_r($ingredientsView2);
            //dd($data);
        }else{
            print_r('tidak ada input update');
            
            $ingredients2 = 0;
            $ingredientsView2 = $ingredients2;
            //print_r($ingredientsView2);
            //dd($data);
        }
        //print_r($ingredientsView2);
        $totalIngredientView = $ingredientsView + $ingredientsView2;
        //print_r($totalIngredientView);
        //dd($data);
        $cek = $data['hiddenInputlah'];
        $cek2 = $data['moreFieldsIngredient'];
        //dd($request->moreFieldsIngredientUpdate);
        //cek kondisi apakah ini sintax edit add / edit delete / edit doang
        if($ingredientsDB < $totalIngredientView){
            print_r("Data Nambah");

            //dd($ingredientsLoop);
            //nambah data
            $ingredientsLoop = $request->moreFieldsIngredientUpdate;
        
            foreach($ingredientsLoop as $valueIngredient){
                //dd($valueIngredient);
                $valueIngredient['recipes_id'] = $recipe->id;
                Ingredients::create($valueIngredient);
    
            }
            
            //ubah data
            foreach($cek2 as $key => $itemingredient){
               //dd($key);
                $ingredients = Ingredients::find($key);  
                $ingredients->ingredient_name = $itemingredient;
                $ingredients->save();
            }

        }else if($ingredientsDB > $totalIngredientView){
            print_r("Data Kurang");
            $idDB = $data['hiddenInputlah'];;
            $idView = $data['moreFieldsIngredient'];

            $result = array_diff_assoc($idDB, $idView);
            print_r($result);
            //dd($data);

            // //nambah data
            // $ingredientsLoop = $request->moreFieldsIngredientUpdate;
        
            // foreach($ingredientsLoop as $valueIngredient){
            //     //dd($valueIngredient);
            //     $valueIngredient['recipes_id'] = $recipe->id;
            //     Ingredients::create($valueIngredient);
    
            // }

            //ubah data
            foreach($cek2 as $key => $itemingredient){
                //dd($key);
                 $ingredients = Ingredients::find($key);  
                 $ingredients->ingredient_name = $itemingredient;
                 $ingredients->save();
             }

            foreach($result as $key => $valueIngredient){
                $valueIngredient = Ingredients::find($key);
                $valueIngredient->forceDelete();
            }
            //dd($idDB);

        }else if($ingredientsDB == $totalIngredientView){
            print_r("Data Di View dan di DB Sama");

            //ubah data
            foreach($cek2 as $key => $itemingredient){
                //dd($key);
                 $ingredients = Ingredients::find($key);  
                 $ingredients->ingredient_name = $itemingredient;
                 $ingredients->save();
             }
        }
        
        

//-----------------------------------------------------------------------------------------------------//
        
        // //Query cara masak berdasarkan recipes_id
        // $stepCookingsAwal = CookingStep::where([
        //     ['recipes_id', '=', $id]
        // ])->get();
        // //menghitung jumlah asli record dari db
        // $stepCookingsDB = count($stepCookingsAwal);
        // //dd($stepCookingsDB);
        // //Query cara masak berdasarkan recipes_id
        // $stepCookingsAkhir = CookingStep::where([
        //     ['recipes_id', '=', $id]
        // ])->first();
        // //menghitung jumlah record setelah diupdate
        // $stepCookings = $data['moreFieldsStepCooking'];
        // //dd(count($stepCookings));
        // //lalu cek apakah ada penambahan data baru atau tidak, karna input untuk penambahan
        // //data baru dengan data yang gua panggil dari DB Berbeda name di input nya 
        // if(isset($data['moreFieldsStepCookingUpdate'])){
        //     //print_r('ada input update');
        //     $stepCookings2 = $data['moreFieldsStepCookingUpdate'];
        //     $stepCookingsView2 = count($stepCookings2);
        // }else{
        //     //print_r('tidak ada input update');
        //     $stepCookings2 = 0;
        //     $stepCookingsView2 = $stepCookings2;
        // }
        // //dd($stepCookingsView2);
        // $stepCookingsView = count($stepCookings);
        // $totalStepCookingView = $stepCookingsView + $stepCookingsView2;
        
        // //dd($stepCookings);
        // print_r($stepCookingsDB.'-');
        // print_r($totalStepCookingView);

        // //cek kondisi apakah ini sintax edit add / edit delete / edit doang
        // if($stepCookingsDB < $totalStepCookingView){
        //     print_r("Data Nambah");
            
        //     //nambah data
        //     foreach($request->moreFieldsStepCookingUpdate as $keyStepCooking => $valueStepCooking){
        //         //dd($valueStepCooking);    
        //         $valueStepCooking['recipes_id'] = $recipe->id;
        //         $valueStepCooking['order'] = 1;
        //         CookingStep::create($valueStepCooking);
        //     }
            
        //     //ubah data
        //     foreach($stepCookings as $key => $itemStepCooking){
        //         //dd($stepCookings);
        //         $stepCookings = CookingStep::find($key);  
        //         $stepCookings->stepcooking_name = $itemStepCooking['stepcooking_name'];
        //         $stepCookings->save();
        //     }

        // }else if($stepCookingsDB > $totalStepCookingView){
        //     print_r("Data Kurang");

        //     //hapus data

        // }else if($stepCookingsDB == $totalStepCookingView){
        //     print_r("Data Di View dan di DB Sama");

        //     //ubah data
        //     foreach($stepCookings as $key => $itemStepCooking){
        //         //dd($stepCookings);
        //         $stepCookings = CookingStep::find($key);  
        //         $stepCookings->stepcooking_name = $itemStepCooking['stepcooking_name'];
        //         $stepCookings->save();
        //     }
        // }
//-----------------------------------------------------------------------------------------------------//

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
