<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Makanan</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block font-medium">Nama Makanan</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Kategori</label>
                <select name="category" class="w-full border p-2 rounded" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Cemilan">Cemilan</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Harga</label>
                <input type="number" name="price" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Deskripsi</label>
                <textarea name="description" class="w-full border p-2 rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Gambar Makanan</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
            </div>
            <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>