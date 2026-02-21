<div class="h-screen flex bg-gray-50 overflow-hidden">
    
    <div class="flex-1 flex flex-col h-full relative">
        <div class="bg-white p-4 shadow-sm z-10 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">🏪 Kafe POS</h1>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="🔍 Cari menu..." class="border rounded-full px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="p-4 flex gap-2 overflow-x-auto bg-gray-100 border-b">
            <button wire:click="$set('category_id', null)" class="px-4 py-1 rounded-full text-sm font-semibold {{ is_null($category_id) ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                Semua
            </button>
            @foreach($categories as $cat)
                <button wire:click="$set('category_id', {{ $cat->id }})" class="px-4 py-1 rounded-full text-sm font-semibold {{ $category_id == $cat->id ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-200' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <div wire:click="addToCart({{ $product->id }})" class="bg-white rounded-lg shadow hover:shadow-lg cursor-pointer transition transform hover:-translate-y-1 overflow-hidden border">
                        <div class="h-32 bg-gray-200 flex items-center justify-center text-gray-400">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-4xl">☕</span>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                            <p class="text-blue-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="w-96 bg-white shadow-2xl flex flex-col h-full border-l z-20">
        <div class="p-4 bg-gray-800 text-white flex justify-between items-center shadow">
            <h2 class="font-bold text-lg">🛒 Pesanan</h2>
            <span class="bg-red-500 text-xs px-2 py-1 rounded-full">{{ count($cartItems) }} Item</span>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            @if($cartItems->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <span class="text-4xl mb-2">🧾</span>
                    <p>Keranjang Kosong</p>
                </div>
            @else
                @foreach($cartItems as $item)
                    <div class="flex flex-col border-b pb-2">
                        <div class="flex justify-between items-start mb-1">
                            <div class="flex-1">
                                <span class="font-bold text-gray-800 block">{{ $item->name }}</span>
                                <span class="text-xs text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} / porsi</span>
                            </div>
                            <span class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-1">
                            <input type="text" wire:blur="updateNote({{ $item->id }}, $event.target.value)" value="{{ $item->note }}" placeholder="Catatan (ex: Pedas)" class="text-xs border-b border-gray-300 focus:outline-none focus:border-blue-500 w-1/2 bg-transparent text-gray-600">

                            <div class="flex items-center bg-gray-100 rounded">
                                <button wire:click="updateQty({{ $item->id }}, -1)" class="px-2 py-1 text-red-600 hover:bg-red-200 rounded-l">-</button>
                                <span class="px-2 font-bold text-sm">{{ $item->qty }}</span>
                                <button wire:click="updateQty({{ $item->id }}, 1)" class="px-2 py-1 text-green-600 hover:bg-green-200 rounded-r">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="bg-gray-50 p-4 border-t space-y-3">
            <div class="flex justify-between text-xl font-bold text-gray-800">
                <span>Total</span>
                <span>Rp {{ number_format($cartItems->sum('subtotal'), 0, ',', '.') }}</span>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <input wire:model="customer_name" type="text" placeholder="Nama Pelanggan" class="w-full text-sm p-2 border rounded">
                <select wire:model="payment_method" class="w-full text-sm p-2 border rounded bg-white">
                    <option value="cash">💵 Tunai</option>
                    <option value="qris">📱 QRIS</option>
                </select>
            </div>

            <button wire:click="checkout" 
                    wire:loading.attr="disabled"
                    {{ $cartItems->isEmpty() ? 'disabled' : '' }}
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-3 rounded-lg shadow-lg transition flex justify-center items-center">
                <span wire:loading.remove>BAYAR SEKARANG</span>
                <span wire:loading>Memproses... 🔄</span>
            </button>
        </div>
    </div>
</div>