<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resepku') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('recipes.store') }}" id="form-create-recipe" name="form-create-recipe" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 md:px-16 bg-white space-y-6 sm:p-6">
                            <div class="px-4 sm:px-6">
                                <h2 class="text-lg leading-6 font-medium text-gray-900">
                                    Buat Resep Baru
                                </h2>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Dapatkan pendapatan tambahan dengan resep mu sendiri.
                                </p>
                            </div>
                            <hr>
                            <!--Start: Upload Gambar-->
                            <div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <form action="" id="formImage" runat="server">
                                                    <strong>Image:</strong>
                                                    <div class="w-72 h-64 rounded-lg linline-flex items-center justify-center bg-gray-100 text-gray-400 mb-2 p-2">
                                                        <img src="storage/app/public/bucketuang.jpg" id="preview-img" alt="your recipe imege" class="w-full h-full object-center object-contain">
                                                    </div>
                                                    <input type="file" name="path" id="pick-img" placeholder="path">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                            <!--End: Upload Gambar-->

                            <!--Start: Nama Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <h2 for="title" class="block text-sm font-medium text-gray-700">Nama Resepmu<h2>
                                <input type="text" name="title" id="title" placeholder="Nasi goreng gila" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <!--End: Nama Resep-->

                            <!--Start: biaya Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <h2 for="budget" class="block text-sm font-medium text-gray-700">Biaya Resep (Dalam Rupiah)</h2>
                                <select id="budget" name="budget" autocomplete="budget" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>-- Pilih --</option>
                                    @foreach ($budgetLists as $budgetList)
                                        <option value="{{ $budgetList['id'] }}">
                                            {{ $budgetList['name'] }}
                                        </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <!--End: biaya Resep-->

                            <!--Start: Kategori Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <h2 for="category_id" class="block text-sm font-medium text-gray-700">Kategori Resep</h2>
                                <select id="category_id" name="category_id" autocomplete="category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>-- Pilih --</option>
                                    @foreach ($recipeCategories as $recipeCategory)
                                        <option value="{{ $recipeCategory['id'] }}">
                                            {{ $recipeCategory['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--End: Kategori Resep-->

                            <!--Start: Cerita Resep-->
                            <div>
                                <h2 for="stories" class="block text-sm font-medium text-gray-700">
                                    Ceritakan tentang resepmu
                                </h2>
                                <div class="mt-1">
                                    <textarea id="stories" name="stories" rows="5" value="" placeholder="Resepku ini tercipta dari enyak ku ketika sedang menjadi juru masak di australia"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                            <!--End: biaya Resep-->

                            <!--End: Porsi & kalori Resep-->
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <h2 for="serving" class="block text-sm font-medium text-gray-700">Porsi sajian (Orang)</h2>
                                    <input type="number" name="serving" id="serving" placeholder="4" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <h2 for="calories" class="block text-sm font-medium text-gray-700">Kalori / Energi (Gram)</h2>
                                    <input type="number" name="calories" id="calories" placeholder="100" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>  
                            <!--End: Porsi & kalori Resep-->

                            <!--Start: Persiapan & Memasak Resep-->
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <h2 for="preptime" class="block text-sm font-medium text-gray-700">Lama persiapan (Menit)</h2>
                                    <input type="number" name="preptime" id="preptime" placeholder="15" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <h2 for="cooktime" class="block text-sm font-medium text-gray-700">Lama memasak (Menit)</h2>
                                    <input type="number" name="cooktime" id="cooktime" placeholder="30" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <!--End: Porsi & kalori Resep-->

                            <!--Start: Tingkat Kesulitan, Halal & Vegan Resep-->
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <h2 for="level" class="block text-sm font-medium text-gray-700">Tingkat kesulitan</h2>
                                    <select id="level" name="level" autocomplete="level" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        @foreach ($levelLists as $levelList)
                                            <option value="{{ $levelList['id'] }}">
                                                {{ $levelList['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-span-6 sm:col-span-2">
                                    <h2 for="ishalal" class="block text-sm font-medium text-gray-700">Resepnan halal ?</h2>
                                    <select id="ishalal" name="ishalal" autocomplete="ishalal" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        @foreach ($halalLists as $halalList)
                                            <option value="{{ $halalList['id'] }}">
                                                {{ $halalList['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <h2 for="isvegan" class="block text-sm font-medium text-gray-700">Resep vegetarian ?</h2>
                                    <select id="isvegan" name="isvegan" autocomplete="isvegan" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        @foreach ($vegetarianLists as $vegetarianList)
                                            <option value="{{ $vegetarianList['id'] }}">
                                                {{ $vegetarianList['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>
                            <!--End: Tingkat Kesulitan, Halal & Vegan Resep-->

                            <!--Start: Tags Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <label class="label-tag">Tags : <span class="text-red-600">*</span></label>
                                <br>
                                <input type="text" data-role="tagsinput" name="tag_name" class="form-control tags w-full">
                                <br>
                                @if ($errors->has('tag_name'))
                                    <span class="text-danger">{{ $errors->first('tag_name') }}</span>
                                @endif
                            </div>
                            <!--End: Tags Resep-->

                            <!--Start: Bahan & Cara Memasak-->
                            <div class="grid grid-cols-6 gap-6">
                                <!--Start: Bahan Resep-->
                                <div class="col-span-6 sm:col-span-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <table class="md:w-full" id="dynamicAddRemoveIngredient">
                                                <tr>
                                                    <th>
                                                        <h2 class="font_semibold text-sm"> Bahan Masak - Resep</h2>
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <!-- <td>
                                                        <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                Input
                                                            </span>
                                                            <input type="text" name="moreFieldsIngredient[0][ingredient_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" 

                                                            />
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <button type="button" name="addIngredient" id="addBtnIngredient" 
                                                            class="inline-flex justify-center mt-1 md:py-2 md:px-2 px-2 border border-transparent shadow-sm md:text-xs font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500"
                                                        >
                                                            Tambah Bahan
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End: Bahan Masak -->

                                <!-- Start: Cara Masak -->
                                <div class="col-span-6 sm:col-span-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <table class="md:w-full" id="dynamicAddRemoveStepCooking">
                                                <tr>
                                                    <th>
                                                    <h2 class="font_semibold text-sm"> Cara Masak - Resep</h2>
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <!-- <td>
                                                        <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                Input
                                                            </span>
                                                            <input type="text" name="moreFieldsStepCooking[0][stepcooking_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                                            />
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <button type="button" name="addStepCooking" id="addBtnStepCooking" 
                                                            class="inline-flex justify-center mt-1 md:py-2 md:px-2 px-2 border border-transparent shadow-sm md:text-xs font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500"
                                                        >
                                                            Tambah Cara Masak
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End: Cara Masak -->
                            </div>
                            <!--End: Bahan & Cara Memasak-->

                            <!-- Start: Button Simpan & Bersihkan -->
                            <div class="px-10 py-3 text-center sm:px-6 md:w-full">
                                <div class="md:w-full pb-16 flex row mx-auto justify-center items-center">
                                    <div class="col text-right">
                                        <div class="dropdownnih inline-block relative">
                                            <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-20 rounded-md inline-flex items-center">
                                                <span class="mr-1">Save</span>
                                                <!-- <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg> -->
                                            </button>
                                            <ul class="dropdown-menunih absolute hidden pt-1 ml-10 text-left">
                                                <li class="bg-gray-100">
                                                    <a class="rounded-t hover:bg-indigo-600 hover:text-white text-indigo-600 py-2 px-10 block whitespace-no-wrap no-underline hover:no-underline" href="#">
                                                        Draft
                                                    </a>
                                                </li>
                                                <li class="bg-gray-100">
                                                    <a class="rounded-b hover:bg-indigo-600 hover:text-white text-indigo-600 py-2 px-10 block whitespace-no-wrap no-underline hover:no-underline" href="#">
                                                        Publish
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-left -mt-3.5">
                                            <a href="{{ route('recipes.index') }}" type="button" class="md:w-64 mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm md:px-10 px-5 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Back to menu
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End: Button Simpan & Bersihkan -->
                        </div>
                    </div>
                </form>     
                
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

        var i = 0;
        $("#addBtnIngredient").click(function(){
            ++i;
            $("#dynamicAddRemoveIngredient").append('<tr><td><div class="mt-1 flex rounded-md shadow-sm"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="moreFieldsIngredient['+i+'][ingredient_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"</div></td><td><button type="button" class="remove_tr_ingredient inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">x</button></td></tr>')
        });

        $(document).on('click','.remove_tr_ingredient', function(){
            $(this).parents('tr').remove();
        });

        var j = 0;
        $("#addBtnStepCooking").click(function(){
            ++j;
            $("#dynamicAddRemoveStepCooking").append('<tr><td><div class="mt-1 flex rounded-md shadow-sm"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="moreFieldsStepCooking['+j+'][stepcooking_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"</div></td><td><button type="button" class="remove_tr_stepcooking inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">x</button></td></tr>')
        });
        $(document).on('click','.remove_tr_stepcooking', function(){
            $(this).parents('tr').remove();
        });

        function readURL(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#preview-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#pick-img").change(function(){
            readURL(this);
        });

        $('form input').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
        

    
    </script>


</x-app-layout>

