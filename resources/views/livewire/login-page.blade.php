<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Login Kasir</h1>

        <form wire:submit="login" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input wire:model="username" type="text" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-blue-500" placeholder="Masukan username...">
                @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input wire:model="password" type="password" class="mt-1 block w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-blue-500" placeholder="********">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Login
                <div wire:loading wire:target="login" class="inline-block ml-2 animate-spin">⌛</div>
            </button>
        </form>
    </div>
</div>