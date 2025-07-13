@extends('layout.Navbar')

@section('title', 'Informasi - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-6">Informasi Desa</h1>
                <p class="text-xl text-blue-200">Informasi terkini seputar kegiatan dan layanan Desa Ngrejo</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8 bg-white border-b">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Filter Kategori</h2>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('user.informasi') }}"
                            class="px-4 py-2 rounded-full {{ is_null($kategoriFilter) ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Semua
                        </a>
                        @foreach ($semuaKategori as $kategori)
                            <a href="{{ route('user.informasi', ['kategori' => $kategori]) }}"
                                class="px-4 py-2 rounded-full {{ $kategoriFilter === $kategori ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $kategori }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi Terbaru -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Informasi Terbaru</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($gabunganTerbaru as $item)
                        <a href="{{ $item->tipe === 'informasi' ? route('user.informasi.show', $item->id) : asset('storage/' . $item->dokumen) }}"
                            target="{{ $item->tipe === 'dokumen' ? '_blank' : '_self' }}">
                            <article
                                class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all border">
                                <div class="relative">
                                    @if ($item->tipe === 'informasi')
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}"
                                            alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded mb-4">
                                            <i class="fas fa-file-pdf text-red-600 text-6xl"></i>
                                        </div>
                                    @endif

                                    <div class="absolute top-4 left-4">
                                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $item->kategori }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                        {{ $item->tipe === 'informasi' ? $item->judul : $item->nama_document }}
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-3">
                                        {{ $item->tipe === 'informasi'
                                            ? Str::limit(strip_tags($item->deskripsi), 100)
                                            : 'Dokumen peraturan desa yang terbaru.' }}
                                    </p>
                                    <div class="mt-4 flex justify-between text-sm text-gray-500">
                                        @if ($item->tipe === 'informasi')
                                            <span><i class="fas fa-user mr-1"></i>{{ $item->penulis }}</span>
                                        @else
                                            <span><i class="fas fa-file-alt mr-1"></i>Dokumen</span>
                                        @endif
                                        <span><i
                                                class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Semua Informasi (Gabungan) -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Semua Informasi</h2>
                        <p class="text-gray-600">
                            {{ count($informasi) + count($dokumen) }} item ditemukan
                        </p>
                    </div>
                </div>

                @php
                    $semuaItem = collect();

                    // Jika filter peraturan, hanya tampil dokumen
                    if ($kategoriFilter === 'peraturan') {
                        $semuaItem = collect($dokumen)->map(function ($d) {
                            $d->tipe = 'dokumen';
                            return $d;
                        });
                    }
                    // Jika filter selain peraturan (berita, kegiatan, dll), hanya tampil informasi
                    elseif (!is_null($kategoriFilter)) {
                        $semuaItem = collect($informasi)->map(function ($i) {
                            $i->tipe = 'informasi';
                            return $i;
                        });
                    }
                    // Jika tidak ada filter, tampilkan keduanya
                    else {
                        $semuaItem = collect($informasi)
                            ->map(function ($i) {
                                $i->tipe = 'informasi';
                                return $i;
                            })
                            ->merge(
                                collect($dokumen)->map(function ($d) {
                                    $d->tipe = 'dokumen';
                                    return $d;
                                }),
                            );
                    }

                    $semuaItem = $semuaItem->sortByDesc('created_at');
                @endphp

                @if ($semuaItem->isEmpty())
                    <p class="text-center text-gray-500">Belum ada informasi yang tersedia.</p>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach ($semuaItem as $item)
                            <article
                                class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group border">
                                <div class="relative">
                                    @if ($item->tipe === 'informasi')
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}"
                                            alt="{{ $item->judul }}"
                                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded">
                                            <i class="fas fa-file-pdf text-red-600 text-6xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $item->kategori }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3
                                        class="text-xl font-bold text-gray-800 mb-3 group-hover:text-primary-600 transition-colors line-clamp-2">
                                        <a href="{{ $item->tipe === 'informasi' ? route('user.informasi.show', $item->id) : asset('storage/' . $item->dokumen) }}"
                                            target="{{ $item->tipe === 'dokumen' ? '_blank' : '_self' }}">
                                            {{ $item->tipe === 'informasi' ? $item->judul : $item->nama_document }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ $item->tipe === 'informasi'
                                            ? Str::limit(strip_tags($item->deskripsi), 120)
                                            : 'Dokumen peraturan desa yang terbaru.' }}
                                    </p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i
                                                class="fas {{ $item->tipe === 'informasi' ? 'fa-user' : 'fa-file-alt' }} mr-2"></i>
                                            <span>{{ $item->tipe === 'informasi' ? $item->penulis : 'Dokumen' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar mr-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
