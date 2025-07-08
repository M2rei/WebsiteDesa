@extends('layout.sidebar')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
    <form action="{{ route('admin.informasi.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="desa_id" value="{{ $berita->desa_id }}">

        <div class="space-y-6">
            <div>
                <label for="judul" class="block text-lg font-semibold text-gray-700 mb-2">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label for="deskripsi" class="block text-lg font-semibold text-gray-700 mb-2">Isi Berita</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" class="w-full px-4 py-3 border rounded-lg">{{ old('deskripsi', $berita->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="penulis" class="block text-lg font-semibold text-gray-700 mb-2">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label for="kategori" class="block text-lg font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-3 border rounded-lg">
                    <option value="Pengumuman" {{ $berita->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="Berita" {{ $berita->kategori == 'Berita' ? 'selected' : '' }}>Berita</option>
                    <option value="Kegiatan" {{ $berita->kategori == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="Layanan" {{ $berita->kategori == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                    <option value="Pembangunan" {{ $berita->kategori == 'Pembangunan' ? 'selected' : '' }}>Pembangunan
                    </option>
                </select>
            </div>

            <div>
                <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Gambar (Opsional)</label>
                @if ($berita->image)
                    <img src="{{ asset('storage/' . $berita->image) }}" class="w-full max-w-sm mb-4 rounded">
                @endif
                <input type="file" name="image" class="w-full">
                <p class="text-sm text-gray-500 mt-2">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.informasi.index') }}"
                    class="ml-4 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-full">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection
