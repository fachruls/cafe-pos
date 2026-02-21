<div class="min-h-screen bg-slate-50 p-6 lg:p-10">
    <div class="max-w-7xl mx-auto space-y-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Produk</h1>
                <p class="text-slate-500 mt-1">Kelola daftar menu dan kategori restoran Anda secara *real-time*</p>
            </div>
            <div class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
                <span class="text-sm font-medium text-slate-600">Sistem Aktif</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-800">Buat Kategori Baru</h2>
                    </div>
                    <div class="p-6">
                        @if (session()->has('success_cat')) 
                            <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 text-sm rounded-xl border border-emerald-100 font-medium">
                                {{ session('success_cat') }}
                            </div> 
                        @endif
                        <form wire:submit="saveCategory" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Kategori</label>
                                <input wire:model="cat_name" type="text" placeholder="Contoh: Kopi Susu" class="w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tipe</label>
                                <select wire:model="cat_type" class="w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all">
                                    <option value="food">Makanan</option>
                                    <option value="drink">Minuman</option>
                                    <option value="snack">Camilan</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 text-white py-2.5 rounded-xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-200">Simpan Kategori</button>
                        </form>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-800">Detail Produk</h2>
                    </div>
                    <div class="p-6">
                        @if (session()->has('success_prod')) 
                            <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 text-sm rounded-xl border border-emerald-100 font-medium">
                                {{ session('success_prod') }}
                            </div> 
                        @endif
                        <form wire:submit="saveProduct" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Menu</label>
                                <input wire:model="name" type="text" placeholder="Nama hidangan..." class="w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga Jual</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-slate-400 font-medium text-sm">Rp</span>
                                    <input wire:model="price" type="number" class="w-full pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</label>
                                <select wire:model="category_id" class="w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all text-sm">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Foto Menu</label>
                                <div class="mt-2 flex items-center justify-center border-2 border-dashed border-slate-200 rounded-2xl p-4 hover:border-blue-400 transition-colors group cursor-pointer relative">
                                    <input wire:model="image" type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                                    <div class="text-center">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-xl mx-auto shadow-md">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-slate-300 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Unggah Foto (JPG/PNG)</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Publikasikan Menu</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-800">Daftar Menu Aktif</h2>
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ $products->count() }} Item</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-widest font-bold">
                                    <th class="p-6">Produk</th>
                                    <th class="p-6">Kategori</th>
                                    <th class="p-6 text-right">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($products as $prod)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-6">
                                        <div class="flex items-center space-x-4">
                                            @if($prod->image_path)
                                                <img src="{{ asset('storage/' . $prod->image_path) }}" class="h-14 w-14 object-cover rounded-xl shadow-sm ring-2 ring-white">
                                            @else
                                                <div class="h-14 w-14 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $prod->name }}</p>
                                                <p class="text-xs text-slate-400">ID: PRD-{{ $prod->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6 text-sm">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-semibold text-xs border border-slate-200 uppercase">
                                            {{ $prod->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <span class="text-blue-600 font-extrabold text-base">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($products->isEmpty())
                            <div class="p-20 text-center">
                                <p class="text-slate-400 font-medium">Belum ada produk yang dipajang di etalase.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>