@extends('layout.sidebar')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
    <form action="{{ route('admin.struktur-organisasi.updateStrukturOrganisasi', $anggotaStruktur->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="nama" class="block text-lg font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $anggotaStruktur->nama) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>
            <div>
                <label for="jabatan" class="block text-lg font-semibold text-gray-700 mb-2">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $anggotaStruktur->jabatan) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>
            <div>
                <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Gambar (Opsional)</label>
                @if ($anggotaStruktur->foto)
                    <img src="{{ asset('storage/' . $anggotaStruktur->foto) }}" class="w-full max-w-sm mb-4 rounded">
                @endif
                <input type="file" name="image" class="w-full">
                <p class="text-sm text-gray-500 mt-2">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.struktur-organisasi.index') }}"
                    class="ml-4 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-full">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection
