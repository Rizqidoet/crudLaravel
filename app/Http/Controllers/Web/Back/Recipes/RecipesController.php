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
        
        return view('recipes.create')->with(
            [
                'recipeCategories' => $recipeCategories,
                'budgetLists' => $this->budgetList($model),
                'levelLists'=>$this->levelList($model),
                'halalLists'=>$this->halalList($model),
                'vegetarianLists'=>$this->vegetarianList($model)
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
        $data['user_id'] = Auth::user()->id;
        print_r($data);
        $recipes = Recipes::create($data);

        //save image
        $validatedData = $request->validate([
            'file.*' => 'image|max:1024',
    
        ]);
        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->store('public/files');
        $save = new RecipesImage;
        $save->name = $name;
        $save->path = $path;

        $recipes->recipes_image()->create([
            'name' => $name,
            'path' => $path,
            'user_id' => auth()->user()->id,
        ]);

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
        //
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
