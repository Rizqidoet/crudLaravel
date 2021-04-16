
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
                            <div class="px-4 py-5 sm:px-6">
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
                                <label class="block text-sm font-medium text-gray-700">
                                    Gambar Resep
                                </label>
                                <!-- <div class="mt-1 flex items-center">
                                    <span class="inline-block md:h-40 md:w-40 h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                    <input type="file" name="file_image" id="file_image" placeholder="Choose file image"
                                            class="md:px-4"/>
                                    @error('file_image')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div> -->
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
                                            
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                        </div>
                                    </div>     
                                </form>
                            </div>
                            <!--End: Upload Gambar-->

                            <!--Start: Nama Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">Nama Resepmu<label>
                                <input type="text" name="title" id="title" placeholder="Nasi goreng gila" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <!--End: Nama Resep-->

                            <!--Start: biaya Resep-->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="budget" class="block text-sm font-medium text-gray-700">Biaya Resep (Dalam Rupiah)</label>
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
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Resep</label>
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
                                <label for="stories" class="block text-sm font-medium text-gray-700">
                                    Ceritakan tentang resepmu
                                </label>
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
                                    <label for="serving" class="block text-sm font-medium text-gray-700">Porsi sajian (Orang)</label>
                                    <input type="number" name="serving" id="serving" placeholder="4" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="calories" class="block text-sm font-medium text-gray-700">Kalori / Energi (Gram)</label>
                                    <input type="number" name="calories" id="calories" placeholder="100" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>  
                            <!--End: Porsi & kalori Resep-->

                            <!--Start: Persiapan & Memasak Resep-->
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="preptime" class="block text-sm font-medium text-gray-700">Lama persiapan (Menit)</label>
                                    <input type="number" name="preptime" id="preptime" placeholder="15" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="cooktime" class="block text-sm font-medium text-gray-700">Lama memasak (Menit)</label>
                                    <input type="number" name="cooktime" id="cooktime" placeholder="30" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <!--End: Porsi & kalori Resep-->

                            <!--Start: Tingkat Kesulitan, Halal & Vegan Resep-->
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="level" class="block text-sm font-medium text-gray-700">Tingkat kesulitan</label>
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
                                    <label for="ishalal" class="block text-sm font-medium text-gray-700">Resepnan halal ?</label>
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
                                    <label for="isvegan" class="block text-sm font-medium text-gray-700">Resep vegetarian ?</label>
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
                                <label for="tag_name" class="block text-sm font-medium text-gray-700">Tags<label>
                                <input type="text" name="tag_name" id="tag_name" placeholder="Makan Enak" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <!--End: Tags Resep-->

                            <!--Start: Bahan & Cara Memasak-->
                            <div class="grid grid-cols-6 gap-6">
                                <!--Start: Bahan Resep-->
                                <div class="col-span-6 sm:col-span-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="text-success">Bahan-bahan</h2>
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        <form name="add_ingredient_name" id="add_ingredient_name">  
                                                            <div class="alert alert-danger show-error-message-ingredient" style="display:none">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="alert alert-success show-success-message-ingredient" style="display:none">
                                                            <ul></ul>
                                                            </div>
                                                            <div class="">  
                                                                <table class="md:w-full" id="dynamic_field_ingredient"> 
                                                                    <tr>  
                                                                        <td>
                                                                            <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                                    Input
                                                                                </span>
                                                                                <input type="text" name="ingredient_name[]" id="ingredient_name" placeholder="Masukan nama bahannya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" />

                                                                            </di>
                                                                        </td>  
                                                                        <td>
                                                                            <button type="button" name="add_ingredient" id="add_ingredient" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
                                                                                +
                                                                            </button>
                                                                        </td>  
                                                                    </tr>  
                                                                </table>    
                                                            </div>
                                                        </form>  
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End: Bahan Masak -->

                                <!-- Start: Cara Masak -->
                                <div class="col-span-6 sm:col-span-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="text-success">Cara Masak</h2>
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        <form name="add_name_step_cooking" id="add_name_step_cooking">  
                                                            <div class="alert alert-danger show-error-message-step-cooking" style="display:none">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="alert alert-success show-success-message-step-cooking" style="display:none">
                                                            <ul></ul>
                                                            </div>
                                                            <div class="">  
                                                                <table class="md:w-full" id="dynamic_field_step_cooking"> 
                                                                    <tr>  
                                                                        <td>
                                                                            <div class="mt-1 flex rounded-md shadow-sm py-1">
                                                                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                                                    Input
                                                                                </span>
                                                                                <input type="text" name="step_cooking[]" id="step_cooking" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" />

                                                                            </di>
                                                                        </td>  
                                                                        <td>
                                                                            <button type="button" name="add_step_cooking" id="add_step_cooking" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
                                                                                +
                                                                            </button>
                                                                        </td>  
                                                                    </tr>  
                                                                </table>    
                                                            </div>
                                                        </form>  
                                                    </div> 
                                                </div>
                                            </div>
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
                            <!-- End: Button Simpan & BErsihkan -->
                        </div>
                    </div>
                </form>     
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){      
            //var url = "{{ url('add-remove-input-fields') }}";
            var i=1;  
            $('#add_ingredient').click(function(){  
                var ingredient_name = $("#ingredient_name").val();
                    i++;  
                    $('#dynamic_field_ingredient').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="ingredient_name[]" placeholder="Masukan nama bahannya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" value="" /></td><td><button type="button" name="remove_ingredient_name" id="'+i+'" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500 btn_remove_ingredient_name">x</button></div></td></tr>');  
            });
            $('#add_step_cooking').click(function(){  
                var step_cooking = $("#step_cooking").val();
                    i++;  
                    $('#dynamic_field_step_cooking').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="mt-1 flex rounded-md shadow-sm py-1"><span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Input</span><input type="text" name="step_cooking[]" placeholder="Jelaskan cara memasaknya" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" value="" /></td><td><button type="button" name="remove_step_cooking" id="'+i+'" class="inline-flex justify-center mt-1 md:py-1 md:px-2 px-2 border border-transparent shadow-sm md:text-lg font-bold text-xs rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500 btn_remove_step_cooking">x</button></div></td></tr>');  
            });  
            $(document).on('click', '.btn_remove_ingredient_name', function(){  
                var button_id_ingredient_name = $(this).attr("id");   
                $('#row'+button_id_ingredient_name+'').remove();  
            });
            $(document).on('click', '.btn_remove_step_cooking', function(){  
                var button_id_step_cooking = $(this).attr("id");   
                $('#row'+button_id_step_cooking+'').remove();  
            });  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        // $('#submit').click(function(){            
        //     $.ajax({  
        //         //url:"{{ url('add-remove-input-fields') }}",  
        //         method:"POST",  
        //         data:$('#add_ingredient_name','#add_step_cooking').serialize(),
        //         type:'json',
        //         success:function(data)  
        //         {
        //             if(data.error){
        //                 display_error_messages(data.error);
        //             }else{
        //                 i=1;
        //                 $('.dynamic-added').remove();
        //                 $('#add_ingredient_name')[0].reset();
        //                 $('#add_name_step_cooking')[0].reset();
        //                 $(".show-success-message-ingredient").find("ul").html('');
        //                 $(".show-success-message-step-cooking").find("ul").html('');
        //                 $(".show-success-message-ingredient").css('display','block');
        //                 $(".show-success-message-step-cooking").css('display','block');
        //                 $(".show-error-message-ingredient").css('display','none');
        //                 $(".show-error-message-step-cooking").css('display','none');
        //                 $(".show-success-message-ingredient").find("ul").append('<li>Bahan Has Been Successfully Inserted.</li>');
        //                 $(".show-success-message-step-cooking").find("ul").append('<li>Bahan Has Been Successfully Inserted.</li>');
        //             }
        //         }  
        //     });  
        // });  
        function display_error_messages(msg) {
            $(".show-error-message-ingredient").find("ul").html('');
            $(".show-error-message-step-cooking").find("ul").html('');
            $(".show-error-message-ingredient").css('display','block');
            $(".show-error-message-step-cooking").css('display','block');
            $(".show-success-message-ingredient").css('display','none');
            $(".show-success-message-step-cooking").css('display','none');
            $.each( msg, function( key, value ) {
                $(".show-error-message-ingredient").find("ul").append('<li>'+value+'</li>');
                $(".show-error-message-step-cooking").find("ul").append('<li>'+value+'</li>');
            });
        }
    });  
    </script>


</x-app-layout>

