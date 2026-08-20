<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Data Makanan</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('foods.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded mb-4 inline-block">+ Tambah Makanan</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white border mt-4">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-2">Gambar</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Kategori</th>
                    <th class="p-2">Harga</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($foods as $food)
                <tr class="border-b text-center">
                    <td class="p-2">
                        @if($food->image)
                            <img src="{{ asset('storage/' . $food->image) }}" class="w-16 h-16 object-cover mx-auto">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td class="p-2">{{ $food->name }}</td>
                    <td class="p-2">{{ $food->category }}</td>
                    <td class="p-2">Rp {{ number_format($food->price) }}</td>
                    <td class="p-2">
                        <a href="{{ route('foods.edit', $food->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('foods.destroy', $food->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus data ini?')" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>