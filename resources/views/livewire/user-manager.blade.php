<div class="p-8 max-w-4xl mx-auto space-y-8">
    <h1 class="text-3xl font-bold text-gray-800">Sistem Manajemen Pegawai</h1>

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500">
        <h2 class="text-xl font-bold mb-4">Formulir Rekrut Karyawan Baru</h2>
        @if (session()->has('success')) <div class="text-green-600 mb-4 font-bold">{{ session('success') }}</div> @endif
        
        <form wire:submit="saveUser" class="space-y-4">
            <input wire:model="name" type="text" placeholder="Nama Lengkap Karyawan" class="w-full border-gray-300 p-2 rounded shadow-sm">
            <input wire:model="username" type="text" placeholder="Username untuk Akses Masuk" class="w-full border-gray-300 p-2 rounded shadow-sm">
            <input wire:model="password" type="password" placeholder="Kata Sandi (Wajib minimal 6 huruf)" class="w-full border-gray-300 p-2 rounded shadow-sm">
            <select wire:model="role" class="w-full border-gray-300 p-2 rounded shadow-sm font-bold text-gray-700">
                <option value="cashier">Kasir Area Depan</option>
                <option value="kitchen">Kru Area Dapur</option>
                <option value="admin">Administrator Bisnis</option>
            </select>
            <button type="submit" class="w-full bg-purple-600 text-white p-2 rounded font-bold hover:bg-purple-700 transition">Daftarkan Pegawai Sekarang</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Daftar Kru Kafe Aktif</h2>
        <table class="w-full text-left border-collapse">
            <tr class="bg-gray-50 border-b-2">
                <th class="p-3">Identitas Nama</th>
                <th class="p-3">Username Akses</th>
                <th class="p-3">Posisi Jabatan</th>
            </tr>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 font-medium">{{ $user->name }}</td>
                <td class="p-3 text-blue-600">{{ $user->username }}</td>
                <td class="p-3 font-bold uppercase text-xs text-purple-700">{{ $user->role }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>