<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recipes By Rizqi') }}
        </h2>
    </x-slot>

    <div class="md:py-4 py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-between px-5" justify-between">
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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Resep
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori Resep
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Biaya Resep
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kesulitan Resep
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status Resep
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                               
                                    @if( $recipe->budget == 1 ){
                                            
                                                5.000 - 10.000
                                            
                                        }@elseif($recipe->budget == 2){
                                            
                                                10.000 - 50.000
                                            
                                        } @elseif($recipe->budget == 3){
                                            
                                                50.000 - 100.000
                                            
                                        } @elseif($recipe->budget == 4){
                                            
                                                100.000 - 500.000
                                            
                                        } @elseif($recipe->budget == 5){
                                            
                                                500.000 - 1.000.000
                                            
                                        } @else{
                                            Data Tidak Sesuai
                                        }
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        @if($recipe->level == 1){
                                            Belum Pernah Memasak
                                        }@elseif($recipe->level == 2){
                                            Pemula
                                        }@elseif($recipe->level == 3){
                                            Mahir Memasak
                                        }@else{
                                            Data Tidak Sesuai
                                        }@endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        @if($recipe->status == 1){
                                            Draft
                                        }@elseif($recipe->status == 2){
                                            Publish
                                        }@elseif($recipe->status == 3){
                                            Live
                                        }@else{
                                            Data Tidak Sesuai
                                        }
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>

                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                
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
