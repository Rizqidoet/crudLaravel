
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
                                <h2 class="block text-sm font-medium text-gray-700">
                                    Gambar Resep
                                </h2>
                                <form method="" nctype="multipart/form-data"  id="" action="" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="file" name="file" placeholder="Choose file" id="file">
                                                    @error('file')
                                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                    @enderror
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
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </textarea>
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
                                                    <td>
                                                        <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                Input
                                                            </span>
                                                            <input type="text" name="moreFieldsIngredient[0][ingredient_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" 

                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" name="addIngredient" id="addBtnIngredient" 
                                                            class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500"
                                                        >
                                                            +
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
                                                    <td>
                                                        <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                Input
                                                            </span>
                                                            <input type="text" name="moreFieldsStepCooking[0][stepcooking_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" name="addStepCooking" id="addBtnStepCooking" 
                                                            class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500"
                                                        >
                                                            +
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
                            <div class="px-4 py-3 text-center sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 md:px-20 px-10 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan
                                </button>

                                <button type="button" class="md:ml-5 bg-white py-3 mt-2 md:px-20 px-10 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Bersihkan
                                </button>
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
            $("#dynamicAddRemoveIngredient").append('<tr><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="moreFieldsIngredient['+i+'][ingredient_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"</div</td><td><button type="button" class="remove_tr_stepcooking inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">x</td></tr>')
        });
        $(document).on('click','.remove_tr_ingredient', function(){
            $(this).parents('tr').remove();
        });

        var j = 0;
        $("#addBtnStepCooking").click(function(){
            ++j;
            $("#dynamicAddRemoveStepCooking").append('<tr><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="moreFieldsStepCooking['+j+'][stepcooking_name]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"</div</td><td><button type="button" class="remove_tr_ingredient inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">x</td></tr>')
        });
        $(document).on('click','.remove_tr_stepcooking', function(){
            $(this).parents('tr').remove();
        });

    //     $(document).ready(function(){      
    //         //var url = "{{ url('add-remove-input-fields') }}";
    //         var i=1;  
    //         $('#add_ingredient').click(function(){  
    //             var ingredient_name = $("#ingredient_name").val();
    //                 i++;  
    //                 $('#dynamic_field_ingredient').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="ingredient_name[]" placeholder="Masukan nama bahannya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" value="" /></td><td><button type="button" name="remove_ingredient_name" id="'+i+'" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500 btn_remove_ingredient_name">x</button></div></td></tr>');  
    //         });
    //         $('#add_step_cooking').click(function(){  
    //             var step_cooking = $("#step_cooking").val();
    //                 i++;  
    //                 $('#dynamic_field_step_cooking').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="step_cooking[]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" value="" /></td><td><button type="button" name="remove_step_cooking" id="'+i+'" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500 btn_remove_step_cooking">x</button></div></td></tr>');  
    //         });  
    //         $(document).on('click', '.btn_remove_ingredient_name', function(){  
    //             var button_id_ingredient_name = $(this).attr("id");   
    //             $('#row'+button_id_ingredient_name+'').remove();  
    //         });
    //         $(document).on('click', '.btn_remove_step_cooking', function(){  
    //             var button_id_step_cooking = $(this).attr("id");   
    //             $('#row'+button_id_step_cooking+'').remove();  
    //         });  
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //     // $('#submit').click(function(){            
    //     //     $.ajax({  
    //     //         //url:"{{ url('add-remove-input-fields') }}",  
    //     //         method:"POST",  
    //     //         data:$('#add_ingredient_name','#add_step_cooking').serialize(),
    //     //         type:'json',
    //     //         success:function(data)  
    //     //         {
    //     //             if(data.error){
    //     //                 display_error_messages(data.error);
    //     //             }else{
    //     //                 i=1;
    //     //                 $('.dynamic-added').remove();
    //     //                 $('#add_ingredient_name')[0].reset();
    //     //                 $('#add_name_step_cooking')[0].reset();
    //     //                 $(".show-success-message-ingredient").find("ul").html('');
    //     //                 $(".show-success-message-step-cooking").find("ul").html('');
    //     //                 $(".show-success-message-ingredient").css('display','block');
    //     //                 $(".show-success-message-step-cooking").css('display','block');
    //     //                 $(".show-error-message-ingredient").css('display','none');
    //     //                 $(".show-error-message-step-cooking").css('display','none');
    //     //                 $(".show-success-message-ingredient").find("ul").append('<li>Bahan Has Been Successfully Inserted.</li>');
    //     //                 $(".show-success-message-step-cooking").find("ul").append('<li>Bahan Has Been Successfully Inserted.</li>');
    //     //             }
    //     //         }  
    //     //     });  
    //     // });  
    //     function display_error_messages(msg) {
    //         $(".show-error-message-ingredient").find("ul").html('');
    //         $(".show-error-message-step-cooking").find("ul").html('');
    //         $(".show-error-message-ingredient").css('display','block');
    //         $(".show-error-message-step-cooking").css('display','block');
    //         $(".show-success-message-ingredient").css('display','none');
    //         $(".show-success-message-step-cooking").css('display','none');
    //         $.each( msg, function( key, value ) {
    //             $(".show-error-message-ingredient").find("ul").append('<li>'+value+'</li>');
    //             $(".show-error-message-step-cooking").find("ul").append('<li>'+value+'</li>');
    //         });
    //     }
    // });  
    </script>


</x-app-layout>

