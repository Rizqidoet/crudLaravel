<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resepku') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container mx-auto px-5">
            <div class="mt-5 md:mt-0 md:col-span-2 px-20">
                <form action="#" method="POST">
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Gambar Resep
                                </label>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-block md:h-40 md:w-40 h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                    <button type="button" class="md:ml-5 ml-2 bg-white py-2 md:px-10 px-2 border border-gray-300 rounded-md shadow-sm md:text-sm text-xs leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Upload gambar
                                    </button>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">Nama Resepmu<label>
                                <input type="text" name="title" id="title" placeholder="Nasi goreng gila" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Biaya Resep (Dalam Rupiah)</label>
                                <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>-- Pilih --</option>
                                    <option>5.000 - 10.000</option>
                                    <option>10.000 - 50.000</option>
                                    <option>50.000 - 100.000</option>
                                    <option>100.000 - 500.000</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Kategori Resep</label>
                                <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>-- Pilih --</option>
                                    <option>Cemilan</option>
                                    <option>Makanan Pembuka</option>
                                    <option>Makanan Utama</option>
                                    <option>Makanan Penutup</option>
                                    <option>Minuman</option>
                                </select>
                            </div>

                            <div>
                                <label for="about" class="block text-sm font-medium text-gray-700">
                                    Ceritakan tentang resepmu
                                </label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="5" value="" placeholder="Resepku ini tercipta dari enyak ku ketika sedang menjadi juru masak di australia"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">Porsi sajian (Orang)</label>
                                    <input type="number" name="first_name" id="first_name" placeholder="4" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Kalori / Energi (Gram)</label>
                                    <input type="number" name="last_name" id="last_name" placeholder="100" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">Lama persiapan (Menit)</label>
                                    <input type="number" name="first_name" id="first_name" placeholder="15" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Lama memasak (Menit)</label>
                                    <input type="number" name="last_name" id="last_name" placeholder="30" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Tingkat kesulitan</label>
                                    <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        <option>Makanan Pembuka</option>
                                        <option>Makanan Utama</option>
                                        <option>Makanan Penutup</option>
                                        <option>Minuman</option>
                                    </select>
                                </div>
                                
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Resepnan halal ?</label>
                                    <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        <option>Ya</option>
                                        <option>Tidak</option>
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Resep vegetarian ?</label>
                                    <select id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>-- Pilih --</option>
                                        <option>Ya</option>
                                        <option>Tidak</option>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">Tags<label>
                                <input type="text" name="title" id="title" placeholder="Makan Enak" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Bahan-bahan<label>
                                    
                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            1
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Beras">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            2
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Cabe rawit">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            3
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Bawang merah">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            4
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Garem">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            5
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Merica bubuk">
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Cara memasak<label>
                                    
                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            1
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Masak beras hingga matang">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            2
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Masukan bawang merah">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            3
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Tambahkan garam">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            4
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Aduk semua bumbu">
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm py-1">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            5
                                        </span>
                                        <input type="text" name="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Sajikan selagi hangat">
                                    </div>
                                </div>
                            </div>

                        <div class="px-4 py-3 text-center sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 md:px-20 px-10 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan
                            </button>

                            <button type="submit" class="md:ml-5 bg-white py-3 mt-2 md:px-20 px-10 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Bersihkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
