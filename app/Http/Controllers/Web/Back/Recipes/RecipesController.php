<?php

namespace  App\ghostAPI\src\GhostContentAPI;
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
use App\ghostAPI\src\GhostAdminAPI;
class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipes::orderBy('created_at' , 'desc')->get();
        
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

        $recipes = DB::table('recipes')
            ->join('recipes_images', 'recipes.id', '=', 'recipes_images.recipes_id')
            ->join('tagable_tags', 'recipes.id', '=', 'tagable_tags.recipes_id')
            ->select('recipes.*', 'recipes_images.path','tagable_tags.tag_name')
            ->where('recipes.id', '=', $recipes->id)
            ->orderBy('recipes.created_at','desc')
            ->first();

         $ingredients = Ingredients::where([
            ['recipes_id', '=', $recipes->id]
        ])->get();
        $cooking_steps = CookingStep::where([
            ['recipes_id', '=', $recipes->id]
        ])->get(); 
        
        

        //dd($recipes);
        //end save ingredient & stepcooking
    //------------------------------------------------------------------------------//
        //back ke index menu
        //$request->session()->flash('ID', $recipes->id);
       

        // RecipesCreated::dispatch($recipes->id);
        // $config = [
        //     'url'    => config('services.ghost.url'),
        //     'key'    => config('services.ghost.admin_key'),
        //     'version'=> config('services.ghost.version'),
        // ];
        //     echo "Prepareing send api <br>";
        //     $api = new GhostAdminAPI($config);
        //     echo "Api Sent <br>";
        //     $rs = []; //hold results
            
        //     //print_r($rs);

        //     $htmlData = '<x-app-layout>';
        //     $htmlData .= '<x-slot name="header">';
        //     $htmlData .= '<h2 class="font-semibold text-xl text-gray-800 leading-tight">Resepku</h2>';
        //     $htmlData .= '</x-slot>';
        //     $htmlData .= '<div class="py-12">';
        //     $htmlData .= '<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">';
        //     $htmlData .= '<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">';
        //     $htmlData .= '<section class="text-gray-600 body-font">';
        //     $htmlData .= '<div class="container mx-auto flex px-5 py-3 items-center justify-center flex-col">';
        //     $htmlData .= '<img class="lg:w-2/6 md:w-3/6 w-5/6 object-cover object-center rounded" alt="hero" src="/storage/ImagesRecipes/'.$recipes->path.'"/>';
        //     $htmlData .= '<div class="text-center lg:w-2/3 w-full">';
        //     $htmlData .= '<h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">'.$recipes->title.'</h1>';
        //     $htmlData .= '<p class="mb-2 leading-relaxed">'.$recipes->stories.'</p>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</section>';
        //     $htmlData .= '<section class ="px-56">';
        //     $htmlData .= '<div class="flex justify-center">';
        //     $htmlData .= '<div class="h-full bg-gray-100 px-4 py-10 mb-10 rounded w-full">';
        //     $htmlData .= '<div class="row">';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/meal.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-12">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Serving</H1>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="mt-28 -ml-12">';
        //     $htmlData .= '<span class="text-xs text-gray-600">'.$recipes->serving.'Orang</span>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/time.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-12">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Prep time</H1>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="mt-28 -ml-16">';
        //     $htmlData .= '<span class="text-xs text-gray-600">'.$recipes->preptime.' Minutes</span>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/time-machine.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-12">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Cook time</H1>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="mt-28 -ml-16">';
        //     $htmlData .= '<span class="text-xs text-gray-600">'.$recipes->cooktime.' Minutes</span>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/caloric-energy.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-11">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Calories</H1>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="mt-28 -ml-12">';
        //     $htmlData .= '<span class="text-xs text-gray-600">'.$recipes->calories.' Kcal</span>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="row">';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/color/48/000000/cook-male--v1.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-11">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Level</H1>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="mt-28 -ml-12">';
        //     if($recipes->level == 1){
        //         $htmlData .=  '<span class="text-xs text-gray-600">Newbie Chef</span>';
        //     }elseif($recipes->level == 2){
        //         $htmlData .=  '<span class="text-xs text-gray-600">Junior Chef</span>';
        //     }elseif($recipes->level == 3){
        //         $htmlData .=  '<span class="text-xs text-gray-600">Master Chef</span>';
        //     }else{
        //         $htmlData .=  '<span class="text-xs text-gray-600">Value Empty/span>';
        //     }
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/expensive-2--v1.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-10">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Price</H1>';
        //     $htmlData .= '</div>';
        //     if($recipes->budget == 1){
        //         $htmlData .= '<div class="mt-28 -ml-12">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Idr. 10.000</span>';
        //         $htmlData .= '</div>';
        //     }elseif($recipes->budget == 2){
        //         $htmlData .= '<div class="mt-28 -ml-12">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Idr. 50.000</span>';
        //         $htmlData .= '</div>';
        //     }elseif($recipes->budget == 3){
        //         $htmlData .= '<div class="mt-28 -ml-12">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Idr. 100.000</span>';
        //         $htmlData .= '</div>';
        //     }
        //     elseif($recipes->budget == 4){
        //         $htmlData .= '<div class="mt-28 -ml-12">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Idr. 500.000</span>';
        //         $htmlData .= '</div>';
        //     }
        //     elseif($recipes->budget == 5){
        //         $htmlData .= '<div class="mt-28 -ml-14">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Idr. 1.000.000</span>';
        //         $htmlData .= '</div>';
        //     }else{
        //         $htmlData .= '<div class="mt-28 -ml-14">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Empty Value</span>';
        //         $htmlData .= '</div>';
        //     }
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/steak-rare.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-12">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Halal ?</H1>';
        //     $htmlData .= '</div>';
        //     if($recipes->ishalal == 1){
        //         $htmlData .= '<div class="mt-28 -ml-8">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Yes</span>';
        //         $htmlData .= '</div>';
        //     }elseif($recipes->ishalal == 2){
        //         $htmlData .= '<div class="mt-28 -ml-8">';
        //         $htmlData .= '<span class="text-xs text-gray-600">No</span>';
        //         $htmlData .= '</div>';
        //     }else{
        //         $htmlData .= '<div class="mt-28 -ml-14">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Empty Value</span>';
        //         $htmlData .= '</div>';
        //     }
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="px-4 w-3/12 flex justify-center items-center">';
        //     $htmlData .= '<img src="https://img.icons8.com/ultraviolet/40/000000/organic-food.png"/>';
        //     $htmlData .= '<div class="mt-20 -ml-11">';
        //     $htmlData .= '<H1 class="text-sm font-semibold text-gray-600">Vegan ?</H1>';
        //     $htmlData .= '</div>';
        //     if($recipes->isvegan == 1){
        //         $htmlData .= '<div class="mt-28 -ml-10">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Yes</span>';
        //         $htmlData .= '</div>';
        //     }elseif($recipes->isvegan == 2){
        //         $htmlData .= '<div class="mt-28 -ml-8">';
        //         $htmlData .= '<span class="text-xs text-gray-600">No</span>';
        //         $htmlData .= '</div>';
        //     }else{
        //         $htmlData .= '<div class="mt-28 -ml-14">';
        //         $htmlData .= '<span class="text-xs text-gray-600">Empty value</span>';
        //         $htmlData .= '</div>';
        //     }
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</section>';

        //     $htmlData .= '<section class="text-gray-600 body-font overflow-hidden">';
        //     $htmlData .= '<div class="container px-5 py-12 mx-auto">';
        //     $htmlData .= '<div class="lg:w-4/5 mx-auto flex flex-wrap">';
        //     $htmlData .= '<img class="lg:w-1/2 w-full object-cover object-center rounded"style="height: 500px" src="storage/StaticImage/ingredients.jpg"/>';
        //     $htmlData .= '<div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">';
        //     $htmlData .= '<h1 class="text-gray-900 text-4xl title-font font-medium mb-1 text-center ">Ingredients</h1>';
        //     $htmlData .= '<hr>';
        //     $htmlData .= '<nav class="flex flex-col px-4 sm:items-start sm:text-left text-left items-center -mb-1 space-y-2.5">';
        //     foreach($ingredients as $ingredient){
        //         $htmlData .= '<div class="row">';
        //         $htmlData .= '<div class="w-2/12">';
        //         $htmlData .= '<span class="bg-blue-100 text-blue-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"></path></svg></span>';
        //         $htmlData .= '</div>';
        //         $htmlData .= '<div class="w-10/12">';
        //         $htmlData .= '<a>'.$ingredient["ingredient_name"].'</a>';
        //         $htmlData .= '</div>';
        //         $htmlData .= '</div>';
        //     }
        //     $htmlData .= '</nav>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</section>';

        //     $htmlData .= '<section class="text-gray-600 body-font px-32">';
        //     $htmlData .= '<div class="container px-5 mx-auto flex flex-wrap">';
        //     $htmlData .= '<div class="flex flex-wrap w-full">';
        //     $htmlData .= '<div class="lg:w-3/6 md:w-1/2 px-4">';
        //     $htmlData .= '<h1 class="title-font sm:text-4xl text-3xl mb-8 font-medium text-gray-900">Steps Cooking</h1>';
        //     foreach($cooking_steps as $cooking_step){
        //         $htmlData .= '<div class="flex relative">';
        //         $htmlData .= '<div class="h-full w-10 absolute inset-0 flex items-center justify-center">';
        //         $htmlData .= '<div class="h-full w-1 bg-gray-200 pointer-events-none"></div>';
        //         $htmlData .= '</div>';
        //         $htmlData .= '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500 inline-flex items-center justify-center text-white relative z-10">';
        //         $htmlData .= '<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">';
        //         $htmlData .= '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>';
        //         $htmlData .= '<path d="M22 4L12 14.01l-3-3"></path>';
        //         $htmlData .= '</svg>';
        //         $htmlData .= '</div>';
        //         $htmlData .= '<div class="flex-grow pl-4 h-28">';
        //         $htmlData .= '<h2 class="font-medium title-font text-sm text-gray-900 mb-1 mt-2 tracking-wider">STEP</h2>';
        //         $htmlData .= '<p class="leading-relaxed text-sm">'.$cooking_step["stepcooking_name"].'</p>';
        //         $htmlData .= '</div>';
        //         $htmlData .= '</div>'; 
        //     }
        //     $htmlData .= '<div class="flex relative">';
        //     $htmlData .= '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500 inline-flex items-center justify-center text-white relative z-10">';
        //     $htmlData .= '<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">';
        //     $htmlData .= '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>';
        //     $htmlData .= '<path d="M22 4L12 14.01l-3-3"></path>';
        //     $htmlData .= '</svg>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="flex-grow pl-4 mt-2">';
        //     $htmlData .= '<h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">FINISH</h2>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '<div class="lg:w-3/6 md:w-1/2 px-4 rounded-lg md:mt-0 mt-12" style="height: 500px">';
        //     $htmlData .= '<img class="object-containt object-center h-full w-full rounded" src="storage/StaticImage/stepcooking.jpg" alt="step">';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</section>';

        //     $htmlData .= '<section class="text-gray-600 body-font">';
        //     $htmlData .= '<div class="container mx-auto flex px-5 py-3 mt-5 mb-10 items-center justify-center flex-col">';
        //     $htmlData .= '<div class="text-center lg:w-2/3 w-full">';
        //     $htmlData .= '<h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Topics related with the recipe</h1>';
        //     $htmlData .= '<input type="text" value="'.$recipes->tag_name.'" data-role="tagsinput" name="tag_name" class="tags w-full" disabled/>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</div>';
        //     $htmlData .= '</section>';

        //     $htmlData .= '<style>';
        //     $htmlData .= '.label-info{background-color: #17a2b8;}';
        //     $htmlData .= '.label {display: inline-block;padding: .25em .4em;font-size: 75%;font-weight: 700;line-height: 1;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}';
        //     $htmlData .= '.dropdown:hover .dropdown-menu {display: block;margin-left: 70px;}';
        //     $htmlData .= '</style>';

            // $htmlData .= '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
            // $htmlData .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />';
            // $htmlData .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />';
            // $htmlData .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>';
            // $htmlData .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>';
            // $htmlData .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>';
            // $htmpailData .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>';

            // $htmlData .= '</x-app-layout>';
            // //print_r($htmlData);
            // $rs[] = $api->posts->add([
            //     'title' => $recipes->title,
            //     'html'=> $htmlData
            // ]);
            // dump($rs);

            return redirect()->route('recipes.index')
            ->with('success',$recipes->id);
        
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
