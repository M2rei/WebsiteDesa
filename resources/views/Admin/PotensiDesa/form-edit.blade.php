@extends('layout.sidebar')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
    <form action="{{ route('admin.potensi-desa.update', $potensidesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="desa_id" value="{{ $potensidesa->desa_id }}">

        <div class="space-y-6">
            <div>
                <label for="nama_potensi" class="block text-lg font-semibold text-gray-700 mb-2">Nama Potensi</label>
                <input type="text" id="nama_potensi" name="nama_potensi"
                    value="{{ old('nama_potensi', $potensidesa->nama_potensi) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label for="kategori" class="block text-lg font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-3 border rounded-lg">
                    <option value="">Pilih Kategori</option>
                    <option value="Pertanian"
                        {{ old('kategori', $potensidesa->kategori) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                    <option value="Peternakan"
                        {{ old('kategori', $potensidesa->kategori) == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                    <option value="Pariwisata"
                        {{ old('kategori', $potensidesa->kategori) == 'Pariwisata' ? 'selected' : '' }}>Pariwisata</option>
                    <option value="Perdagangan"
                        {{ old('kategori', $potensidesa->kategori) == 'Perdagangan' ? 'selected' : '' }}>Perdagangan
                    </option>
                </select>
            </div>


            <div>
                <label for="deskripsi" class="block text-lg font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" class="w-full px-4 py-3 border rounded-lg">{{ old('deskripsi', $potensidesa->deskripsi) }}</textarea>
            </div>


            <div>
                <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Gambar (Opsional)</label>
                @if ($potensidesa->image)
                    <img src="{{ asset('storage/' . $potensidesa->image) }}" class="w-full max-w-sm mb-4 rounded">
                @endif
                <input type="file" name="image" class="w-full">
                <p class="text-sm text-gray-500 mt-2">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.potensi-desa.index') }}"
                    class="ml-4 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-full">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection
