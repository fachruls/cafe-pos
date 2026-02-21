<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg text-center border-t-4 border-green-500">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">👋 Selamat Datang!</h2>
        <p class="text-gray-500 mb-6">Silakan input modal awal di laci kasir untuk membuka shift.</p>

        <form wire:submit="openShift">
            <div class="mb-6">
                <label class="block text-left font-bold text-gray-700 mb-2">Uang Modal (Start Cash)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                    <input wire:model="start_cash" type="number" class="w-full pl-10 p-2 border rounded text-lg font-mono focus:ring-green-500 focus:border-green-500" placeholder="0">
                </div>
                @error('start_cash') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow transition transform hover:scale-105">
                BUKA TOKO SEKARANG 🚀
            </button>
        </form>

        <div class="mt-4 text-sm text-gray-400">
            Login sebagai: <strong>{{ auth()->user()->name }}</strong>
        </div>
    </div>
</div>