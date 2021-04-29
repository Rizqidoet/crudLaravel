<?php

namespace App\Listeners;




use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\RecipesCreated;

use App\Models\Recipes;
use App\Models\Category;
use App\Models\RecipesImage;
use App\Models\TagableTag;
use App\Models\Ingredients;
use App\Models\CookingStep;

class SendRecipesCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  =RecipesCreated  $event
     * @return void
     */
    public function handle(RecipesCreated $event)
    {
        $recipes = Recipes::find($event->recipesId);
        
        $recipesdata=[];
        $recipesdata['data']=$recipes;
        $recipesdata['category']=$recipes->category;
        $recipesdata['ingredients']=$recipes->ingredients;
        $recipesdata['cooking_steps']=$recipes->cooking_steps; 
        $recipesdata['recipes_image']=$recipes->recipes_image;
        //dd($recipesdata);

        $response = Http::post('https://bryta.io/ghost/api/{version}/admin/', [
            'name' => 'Rizqi',
            'role' => 'Administrator',
        ]);

        log::debug("Tester Recipes",$recipesdata);
    }
}
