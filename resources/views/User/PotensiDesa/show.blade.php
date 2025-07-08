@extends('layout.Navbar')

@section('title', $potensidesa->nama_potensi)

@section('content')
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">{{ $potensidesa->nama_potensi }}</h1>
            <div class="text-sm text-gray-500 mb-6">
                <span><i class="fas fa-tag mr-1"></i>{{ $potensidesa->kategori }}</span> •
                <span><i class="fas fa-calendar-alt mr-1"></i>{{ $potensidesa->created_at->format('d M Y') }}</span>
            </div>

            @if ($potensidesa->image)
                <img src="{{ asset('storage/' . $potensidesa->image) }}" alt="Gambar" class="w-full rounded-lg mb-6">
            @endif

            <div class="prose max-w-none">
                {!! nl2br(e($potensidesa->deskripsi)) !!}
            </div>
        </div>
    </section>
@endsection
