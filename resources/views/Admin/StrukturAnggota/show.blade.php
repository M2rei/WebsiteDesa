@extends('layout.sidebar')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Anggota')

@section('content')
        <h2 class="text-2xl font-bold mb-4 text-center">{{ $anggotaStruktur->nama }}</h2>
        <p class="text-gray-600 text-sm mb-6">Jabatan: {{ $anggotaStruktur->jabatan }}</p>

        @if ($anggotaStruktur->foto)
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $anggotaStruktur->foto) }}" alt="Gambar Struktur Anggota" class="w-full max-w-md mx-auto rounded shadow">
            </div>
        @endif
        <div class=" mt-6">
            <a href="{{ route('admin.struktur-organisasi.index') }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
                Kembali
            </a>
        </div>
@endsection
