@extends('layout.sidebar')

@section('title', 'Detail Potensi Desa')
@section('page-title', 'Detail  Potensi Desa')

@section('content')
        <h2 class="text-2xl font-bold mb-4 text-center">{{ $potensidesa->nama_potensi }}</h2>
        <p class="text-gray-600 text-sm mb-6">Kategori: {{ $potensidesa->kategori }}</p>

        @if ($potensidesa->image)
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $potensidesa->image) }}" alt="Gambar Potensi" class="w-full max-w-md mx-auto rounded shadow">
            </div>
        @endif

        <div class="text-gray-800 leading-relaxed whitespace-pre-line">
            {!! nl2br(e($potensidesa->deskripsi)) !!}
        </div>

        <div class=" mt-6">
            <a href="{{ route('admin.potensi-desa.index') }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
                Kembali
            </a>
        </div>
@endsection
