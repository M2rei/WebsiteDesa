@extends('layout.Navbar')

@section('title', 'Potensi Desa - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero -->
    <section class="bg-primary-800 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-4">Potensi Desa Ngrejo</h1>
            <p class="text-xl text-green-100">Mengenal kekayaan dan potensi untuk kemajuan bersama</p>
        </div>
    </section>

    <!-- Filter Kategori -->
    <section class="py-8 bg-white border-b">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold text-gray-800">Filter Kategori</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.potensidesa') }}"
                        class="px-4 py-2 rounded-full {{ is_null($kategoriFilter) ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach ($semuaKategori as $kategori)
                        <a href="{{ route('user.potensidesa', ['kategori' => $kategori]) }}"
                            class="px-4 py-2 rounded-full {{ $kategoriFilter === $kategori ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Potensi Desa -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="mb-6 text-gray-700 text-lg text-center">
                @if (is_null($kategoriFilter))
                    Semua potensi desa ditampilkan.
                @else
                    Menampilkan potensi desa dalam bidang <strong>{{ ucfirst($kategoriFilter) }}</strong>.
                @endif
            </div>
            @if ($potensi->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($potensi as $item)
                        <a href="{{ route('user.potensidesa.show', $item->id) }}">
                            <h3 class="text-xl font-bold">{{ $item->nama_potensi }}</h3>
                            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                                <div class="relative">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x250?text=Potensi' }}"
                                        class="w-full h-48 object-cover" alt="{{ $item->nama_potensi }}">
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm">
                                            {{ $item->kategori }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">
                                        {{ $item->nama_potensi }}
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-3">
                                        {{ $item->deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $potensi->withQueryString()->links() }}
                </div>
            @else
                <p class="text-center text-gray-600 mt-12">Tidak ada potensi desa ditemukan.</p>
            @endif
        </div>
    </section>
@endsection
