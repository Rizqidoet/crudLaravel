<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Bryta - Recipes') }}
        </h2>
    </x-slot>

    <div class="md:py-4 py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-between px-5">
                    <div class="py-2 px-4 mt-2 rounded-md absolute text-xs mx-auto justify-center item-center text-green-400 text-white">
                        
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block -mt-4">
                                <strong class="hidden">{{ $message }}</strong><br>
                                <strong>Data has been created as a draft!</strong><br>
                                <span type="button" class="close" data-dismiss="alert">
                                    <a href="{{ route('recipes.show', $message) }}" class="text-red-500 underline">
                                        klik here
                                    </a>
                                    to update your recipe status to publish
                                </span>	
                            </div>
                        @endif
                    </div>
                    <div class="py-2 px-4 mt-2 rounded-md absolute text-xs mx-auto justify-center item-center text-green-400 text-white">
                        
                        @if ($message = Session::get('Updated'))
                            <div class="alert alert-success alert-block">
                                <strong>{{ $message }}</strong><br>	
                            </div>
                        @endif
                    </div>
                    <div class="md:w-2/3 w-full">
                        <h1 class="md:text-2xl  text-lg font-bold mt-12 p-3 my-3">Table Recipes</h1>
                    </div>
                    <div class="md:w-2/3 w-full text-right md:mr-20 md:mt-6 mt-10">
                        <a href="{{ route('recipes.create') }}" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm md:px-10 px-5 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Add Record
                        </a>
                    </div>
                </div>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            Recipe name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            Recipe category
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            Recipe cost
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            Difficulty level
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-md font-bold text-gray-500 tracking-wider">
                                            Recipe status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-md font-bold text-gray-500 tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                
                                    @forelse($recipes as $key => $recipe)
                                    
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            {{ $recipe->id ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            {{ $recipe->title ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            {{ $recipe->category->name ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                                
                                        @if( $recipe->budget == 1 )
                                                
                                                    5.000 - 10.000
                                                
                                            @elseif($recipe->budget == 2)
                                                
                                                    10.000 - 50.000
                                                
                                            @elseif($recipe->budget == 3)
                                                
                                                    50.000 - 100.000
                                                
                                            @elseif($recipe->budget == 4)
                                                
                                                    100.000 - 500.000
                                                
                                            @elseif($recipe->budget == 5)
                                                
                                                    500.000 - 1.000.000
                                                
                                            @else
                                                Data Tidak Sesuai
                                            
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            @if($recipe->level == 1)
                                                Belum Pernah Memasak
                                            @elseif($recipe->level == 2)
                                                Pemula
                                            @elseif($recipe->level == 3)
                                                Mahir Memasak
                                            @else
                                                Data Tidak Sesuai
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            @if($recipe->status == 0)
                                                Draft
                                            @elseif($recipe->status == 1)
                                                Publish
                                            @elseif($recipe->status == 2)
                                                Live
                                            @else
                                                Data Tidak Sesuai
                                            
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4 mr-4 transform hover:text-purple-500 hover:scale-110">
                                                        <a href="{{ route('recipes.show', $recipe->id) }}" onclick="return confirm('Publish this recipe ?')" title="Publish your ecipe">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 p-1 mr-4 text-green-600 hover:bg-green-600 hover:text-white rounded" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="w-4 mr-4 transform hover:text-purple-500 hover:scale-110">
                                                        <a href="{{ route('recipes.edit', $recipe->id) }}" title="Edit your recipe">
                                                            <svg class="w-7 h-7 p-1 mr-4 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <form action="{{ route('recipes.destroy',$recipe->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Are you sure want to delete this recipe ?')"
                                                            title="elete your recipe" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded"
                                                            >
                                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                            
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-10 text-center">
                                            <h1 class="font-semibold text-md">
                                                recipe data is still empty, 
                                                <a href="{{ route('recipes.create') }}" class="text-red-500 underline">
                                                    create it now
                                                </a>
                                            </h1>
                                        </td>
                                    </tr>
                                    
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</x-app-layout>
