@extends('layout.sidebar')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">{{ $berita->judul }}</h2>

        <p class="text-gray-600 text-sm mb-2">Penulis: <strong>{{ $berita->penulis }}</strong></p>
        <p class="text-gray-600 text-sm mb-4">Kategori: {{ $berita->kategori }}</p>

        @if ($berita->image)
            <img src="{{ asset('storage/' . $berita->image) }}" alt="Gambar Berita" class="w-full max-w-lg rounded mb-4">
        @endif

        <div class="text-gray-800 leading-relaxed">
            {!! nl2br(e($berita->deskripsi)) !!}
        </div>

        <a href="{{ route('admin.informasi.index') }}"
            class="inline-block mt-6 bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Kembali
        </a>
    </div>
@endsection
