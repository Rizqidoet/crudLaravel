<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resepku') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <!-- Start: Recipes Image, Title, Stories -->
            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex px-5 py-3 items-center justify-center flex-col">
                    <img class="lg:w-2/6 md:w-3/6 w-5/6 object-cover object-center rounded" alt="hero" 
                            src="{{ url('storage/ImagesRecipes/'.$recipes->path) }}"
                    />
                    <div class="text-center lg:w-2/3 w-full">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                            {{ $recipes->title }}
                        </h1>
                        <p class="mb-2 leading-relaxed">
                            {{ $recipes->stories }}
                        </p>
                    </div>
                </div>
            </section> 
            <!-- End: Recipes Image, Title, Stories -->

            <!-- Start: Recipes All -->
            <section class ="px-56">
                <div class="flex justify-center">
                    <div class="h-full bg-gray-100 px-4 py-10 mb-10 rounded w-full">
                        <div class="row">
                            <div class="px-4 w-3/12 flex justify-center items-center">    
                                <img src="https://img.icons8.com/ultraviolet/40/000000/meal.png"/> 
                                <div class="mt-20 -ml-12">
                                    <H1 class="text-sm font-semibold text-gray-600">
                                        Serving
                                    </H1>
                                </div>
                                <div class="mt-28 -ml-12">
                                <span class="text-xs text-gray-600">
                                    {{ $recipes->serving }} Orang
                                </span>
                                    
                                </div>
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/time.png"/>
                                <div class="mt-20 -ml-12">
                                    <H1 class="text-sm font-semibold text-gray-600">Prep time</H1>
                                </div>
                                <div class="mt-28 -ml-16">
                                <span class="text-xs text-gray-600">
                                    {{ $recipes->preptime }} Minutes
                                </span>
                                </div>
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/time-machine.png"/>
                                <div class="mt-20 -ml-12">
                                    <H1 class="text-sm font-semibold text-gray-600">Cook time</H1>
                                </div>
                                <div class="mt-28 -ml-16">
                                    <span class="text-xs text-gray-600">
                                        {{ $recipes->cooktime }} Minutes
                                    </span>
                                </div>
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/caloric-energy.png"/>
                                <div class="mt-20 -ml-11">
                                    <H1 class="text-sm font-semibold text-gray-600">Calories</H1>
                                </div>
                                <div class="mt-28 -ml-12">
                                    <span class="text-xs text-gray-600">
                                        {{ $recipes->calories }} Kcal
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="px-4 w-3/12 flex justify-center items-center">    
                                <img src="https://img.icons8.com/color/48/000000/cook-male--v1.png"/> 
                                <div class="mt-20 -ml-11">
                                    <H1 class="text-sm font-semibold text-gray-600">Level</H1>
                                </div>
                                <div class="mt-28 -ml-12">
                                    @if($recipes->level == 1)
                                        <span class="text-xs text-gray-600">
                                            Newbie Chef
                                        </span>
                                    @elseif($recipes->level == 2)
                                        <span class="text-xs text-gray-600">
                                            Junior Chef
                                        </span>
                                    @elseif($recipes->level == 3)
                                        <span class="text-xs text-gray-600">
                                            Master Chef
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-600">
                                            Empty value
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/expensive-2--v1.png"/>
                                <div class="mt-20 -ml-10">
                                    <H1 class="text-sm font-semibold text-gray-600">Price</H1>
                                </div>
                                @if($recipes->budget == 1)
                                    <div class="mt-28 -ml-12">
                                        <span class="text-xs text-gray-600">
                                            Idr. 10.000
                                        </span>
                                    </div>
                                @elseif($recipes->budget == 2)
                                    <div class="mt-28 -ml-12">
                                        <span class="text-xs text-gray-600">
                                            Idr. 50.000
                                        </span>
                                    </div>
                                @elseif($recipes->budget == 3)
                                    <div class="mt-28 -ml-12">
                                        <span class="text-xs text-gray-600">
                                            Idr. 100.000
                                        </span>
                                    </div>
                                @elseif($recipes->budget == 4)
                                    <div class="mt-28 -ml-12">
                                        <span class="text-xs text-gray-600">
                                            Idr. 500.000
                                        </span>
                                    </div>
                                @elseif($recipes->budget == 5)
                                    <div class="mt-28 -ml-14">
                                    <span class="text-xs text-gray-600">
                                        Idr. 1.000.000
                                    </span>    
                                </div>
                                @else
                                    <div class="mt-28 -ml-14">
                                        <span class="text-xs text-gray-600">
                                            Empty value
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/steak-rare.png"/>
                                <div class="mt-20 -ml-12">
                                    <H1 class="text-sm font-semibold text-gray-600">Halal ?</H1>
                                </div>
                                @if($recipes->ishalal == 1)
                                    <div class="mt-28 -ml-8">
                                        <span class="text-xs text-gray-600">
                                            Yes
                                        </span>
                                    </div>
                                @elseif($recipes->ishalal == 2)
                                    <div class="mt-28 -ml-8">
                                        <span class="text-xs text-gray-600">
                                            No
                                        </span>
                                    </div>
                                @else
                                    <div class="mt-28 -ml-14">
                                        <span class="text-xs text-gray-600">
                                            Empty value
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 w-3/12 flex justify-center items-center">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/organic-food.png"/>
                                <div class="mt-20 -ml-11">
                                    <H1 class="text-sm font-semibold text-gray-600">Vegan ?</H1>
                                </div>
                                @if($recipes->isvegan == 1)
                                    <div class="mt-28 -ml-10">
                                        <span class="text-xs text-gray-600">
                                            Yes
                                        </span>
                                    </div>
                                @elseif($recipes->isvegan == 2)
                                    <div class="mt-28 -ml-8">
                                        <span class="text-xs text-gray-600">
                                            No
                                        </span>
                                    </div>
                                @else
                                    <div class="mt-28 -ml-14">
                                        <span class="text-xs text-gray-600">
                                            Empty value
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section> 
            <!-- End: Recipes All -->
            
            <!-- Start: Ingredients -->
            <section class="text-gray-600 body-font overflow-hidden">
                <div class="container px-5 py-12 mx-auto">
                    <div class="lg:w-4/5 mx-auto flex flex-wrap">
                        <img class="lg:w-1/2 w-full object-cover object-center rounded"style="height: 500px" src="{{ url('storage/StaticImage/ingredients.jpg') }}"
                        />
                        <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                            <h1 class="text-gray-900 text-4xl title-font font-medium mb-1 text-center ">
                                Ingredients
                                </h1>
                            <hr>
                            <nav class="flex flex-col px-4 sm:items-start sm:text-left text-left items-center -mb-1 space-y-2.5">
                                @foreach( $ingredients as $ingredient )
                                <div class="row">
                                    <div class="w-2/12">
                                        <span class="bg-blue-100 text-blue-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                                <path d="M20 6L9 17l-5-5"></path>
                                            </svg>  
                                        </span>
                                    </div>
                                    <div class="w-10/12">
                                        <a>
                                            {{ $ingredient->ingredient_name }}  
                                        </a>
                                    </div>
                                </div> 
                                
                                            
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End: Ingredients -->

            <!-- Start: StepCooking -->
            <section class="text-gray-600 body-font px-32">
                <div class="container px-5 mx-auto flex flex-wrap">
                    <div class="flex flex-wrap w-full">
                        <div class="lg:w-3/6 md:w-1/2 px-4">
                            <h1 class="title-font sm:text-4xl text-3xl mb-8 font-medium text-gray-900">
                                Step's Cooking
                            </h1>
                            @foreach ( $cooking_steps as $cooking_step )
                                <div class="flex relative">
                                    <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
                                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                                    </div>
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500 inline-flex items-center justify-center text-white relative z-10">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                        <path d="M22 4L12 14.01l-3-3"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-grow pl-4 h-28">
                                        <h2 class="font-medium title-font text-sm text-gray-900 mb-1 mt-2 tracking-wider">STEP</h2>
                                        <p class="leading-relaxed text-sm">
                                            {{ $cooking_step->stepcooking_name }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="flex relative">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500 inline-flex items-center justify-center text-white relative z-10">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                    <path d="M22 4L12 14.01l-3-3"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow pl-4 mt-2">
                                    <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">FINISH</h2>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-3/6 md:w-1/2 px-4 rounded-lg md:mt-0 mt-12" style="height: 500px">
                            <img class="object-containt object-center h-full w-full rounded" src="{{ url('storage/StaticImage/stepcooking.jpg') }}" alt="step">
                        </div>
                    </div>
                </div>
            </section> 
            <!-- End: StepCooking -->

            <!-- Start: Tags-->
            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex px-5 py-3 mt-5 mb-10 items-center justify-center flex-col">
                    <div class="text-center lg:w-2/3 w-full">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                            Topics related with the recipe
                        </h1>
                        <input type="text" value="{{ old('tag_name', isset($recipes) ? $recipes->tag_name : '') }}" data-role="tagsinput" name="tag_name" class="tags w-full" disabled/>
                                
                    </div>
                </div>
            </section> 
            <!-- End: Tags-->
            
        </div>        
    </div>
    

    <style>
        .label-info{
            background-color: #17a2b8;

        }
        .label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,
            border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-left: 70px;
        }
</style>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>


    <script type="text/javascript">

    </script>


</x-app-layout>

