@extends('layout.Navbar')

@section('title', $potensidesa->nama_potensi)

@section('content')
    <x-hero-banner :title="$potensidesa->nama_potensi" subtitle="Potensi Desa Ngrejo" image="image/background/2.JPG" />

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">{{ $potensidesa->nama_potensi }}</h1>
            <div class="text-sm text-gray-500 mb-6">
                <span><i class="fas fa-tag mr-1"></i>{{ $potensidesa->kategori }}</span> •
                <span><i class="fas fa-calendar-alt mr-1"></i>{{ $potensidesa->created_at->format('d M Y') }}</span>
            </div>

            <img src="{{ \App\Helpers\ImageHelper::url($potensidesa->image) }}" alt="Gambar" width="800" height="450"
                class="w-full rounded-lg mb-6">

            <div class="prose max-w-none">
                {!! nl2br(e($potensidesa->deskripsi)) !!}
            </div>
        </div>
    </section>
@endsection
