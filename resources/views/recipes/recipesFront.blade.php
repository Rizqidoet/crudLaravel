<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resepku') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-col text-center w-full mb-20">
                            <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">
                                Bryta - Recipes
                            </h2>
                            <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">
                                All Recipes From Chef Bryta
                            </h1>
                        </div>
                        <div class="flex flex-wrap -m-4">
                            @forelse($recipesImages as $key => $recipe)
                            
                                <div class="p-4 md:w-1/3">
                                    <div class="flex rounded-lg h-full bg-gray-100 flex-col px-2">
                                        <div class="rounded-lg linline-flex items-center justify-center bg-gray-100 text-gray-400 mb-2 h-48">
                                            <img src="{{ url('storage/ImagesRecipes/'.$recipesImages[$key]['path']) }}" id="preview-img" name="path" alt="your recipe imege" class="w-full h-full object-center object-contain" >
                                        </div>
                                        <hr class="px-4">
                                        <div class="flex items-center px-2">
                                            <div class="w-8 h-8 mr-1 inline-flex items-center justify-center rounded-lg text-white flex-shrink-0">
                                                <img src="https://img.icons8.com/wired/64/000000/chef-hat.png" class="-mt-3"/>
                                            </div>
                                            <h2 class="text-gray-900 text-base font-semibold title-font">
                                                {{ $recipes[$key]['title'] }}
                                            </h2>
                                        </div>
                                        <div class="flex-grow ml-3 mb-3">
                                            <a href="{{ route('recipes.index') }}" class="mt-1 text-sm text-indigo-500 inline-flex items-center">
                                                See Detail's
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full text-base font-semibold text-gray-500 p-5 text-left">
                                    <span>
                                        No more recipes..
                                        <a href="{{ route('recipes.create') }}" class="text-red underline">
                                            klik here
                                        </a>
                                        to create your own
                                    </span>
                                </div>
                            @endforelse
                            
                            
                        </div>
                    </div>
                </section>       
            </div>        
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

