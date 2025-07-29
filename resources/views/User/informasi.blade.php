@extends('layout.Navbar')

@section('title', 'Informasi - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <section class="relative bg-primary-800 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-50"
            style="background-image: url('{{ asset('image/background/1.JPG') }}')">
        </div>
        <div class="relative z-10 container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mt-6">
                <h1 class="text-5xl font-bold mb-6">Informasi Desa</h1>
                <p class="text-xl text-blue-200">Informasi terkini seputar kegiatan dan layanan Desa Ngrejo</p>
            </div>
        </div>
    </section>

    <!-- Informasi Terbaru -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Informasi Terbaru</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($informasiTerbaru as $item)
                        <article
                            class="relative bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all border group">
                            <a href="{{ route('user.informasi.show', $item->id) }}" class="absolute inset-0 z-10"></a>

                            @php
                                $lampiran = $item->lampiran;
                                $filePath = $lampiran?->file_path;
                                $originalName = $lampiran?->original_name;
                                $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isPdf = $ext === 'pdf';
                            @endphp

                            <div class="relative z-0">
                                @if ($filePath)
                                    @if ($isImage)
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $originalName }}"
                                            class="w-full h-48 object-cover">
                                    @elseif ($isPdf)
                                        <div class="w-full h-48 bg-red-100 flex items-center justify-center rounded">
                                            <i class="fas fa-file-pdf text-red-600 text-5xl"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded">
                                            <i class="fas fa-file text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-file text-gray-400 text-4xl"></i>
                                    </div>
                                @endif

                                <div class="absolute top-4 left-4">
                                    <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $item->kategori }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 relative z-0">
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-primary-600">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 100) }}
                                </p>
                                <div class="mt-4 flex justify-between text-sm text-gray-500">
                                    <span><i class="fas fa-user mr-1"></i>{{ $item->penulis }}</span>
                                    <span><i
                                            class="fas fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="py-10 bg-white border-b">
        <div class="container mx-auto px-4">
            <form action="{{ route('user.informasi') }}" method="GET"
                class="w-full max-w-4xl mx-auto grid gap-4 md:grid-cols-3 items-end">
                <div x-data="{ open: false }" class="relative w-full">
                    <button @click="open = !open" type="button"
                        class="flex justify-between items-center w-full px-4 py-2 text-sm border rounded-lg bg-white">
                        {{ request('kategori') ? ucfirst(request('kategori')) : 'Semua Kategori' }}
                        <i class="fas fa-chevron-down ml-2 text-gray-500 transition-transform duration-200"
                            :class="{ 'transform rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute z-10 mt-1 w-full bg-white border rounded-lg shadow-md py-1">
                        <a href="{{ route('user.informasi') }}"
                            class="block px-4 py-2 hover:bg-gray-50 {{ !request('kategori') ? 'font-medium text-blue-600' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach ($daftarKategori as $kategori)
                            <a href="{{ route('user.informasi', ['kategori' => $kategori]) }}"
                                class="block px-4 py-2 hover:bg-gray-50 {{ request('kategori') == $kategori ? 'font-medium text-blue-600' : '' }}">
                                {{ ucfirst($kategori) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Pencarian Judul</label>
                    <div class="flex rounded-lg shadow-sm">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-l-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 px-4 py-2"
                            placeholder="Ketik judul informasi...">
                        <button type="submit"
                            class="bg-primary-600 text-white px-4 py-2 rounded-r-lg hover:bg-primary-700 transition flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span class="hidden sm:inline">Cari</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Semua Informasi -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Semua Informasi</h2>
                        <p class="text-gray-600">
                            {{ $informasi->count() }} item ditemukan
                        </p>
                    </div>
                </div>

                @if ($informasi->isEmpty())
                    <p class="text-center text-gray-500">Belum ada informasi yang tersedia.</p>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach ($informasi as $item)
                            <article class="relative bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all border group">
                                <a href="{{ route('user.informasi.show', $item->id) }}" class="absolute inset-0 z-10"></a>
                                <div class="relative">
                                    @php
                                        $lampiran = $item->lampiran;
                                        $filePath = $lampiran?->file_path;
                                        $originalName = $lampiran?->original_name;
                                        $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        $isPdf = $ext === 'pdf';
                                    @endphp

                                    @if ($filePath)
                                        @if ($isImage)
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $originalName }}"
                                                    class="w-full h-48 object-cover">
                                            </a>
                                        @elseif ($isPdf)
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                <div
                                                    class="w-full h-48 bg-red-100 flex items-center justify-center rounded">
                                                    <i class="fas fa-file-pdf text-red-600 text-5xl"></i>
                                                </div>
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                <div
                                                    class="w-full h-48 bg-gray-100 flex items-center justify-center rounded">
                                                    <i class="fas fa-file text-gray-400 text-4xl"></i>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded">
                                            <i class="fas fa-file text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif

                                    <div class="absolute top-4 left-4">
                                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $item->kategori }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                        <a href="{{ route('user.informasi.show', $item->id) }}">
                                            {{ $item->judul }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 120) }}
                                    </p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div><i class="fas fa-user mr-2"></i>{{ $item->penulis }}</div>
                                        <div><i class="fas fa-calendar mr-2"></i>{{ $item->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-between mt-8">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $informasi->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $informasi->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $informasi->total() }}</span>
                                hasil
                            </p>
                        </div>

                        <div class="flex items-center space-x-1">
                            @if ($informasi->onFirstPage())
                                <span class="px-3 py-1 rounded border text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $informasi->previousPageUrl() }}"
                                    class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            @foreach ($informasi->getUrlRange(1, $informasi->lastPage()) as $page => $url)
                                @if ($page == $informasi->currentPage())
                                    <span class="px-3 py-1 rounded bg-primary-600 text-white">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            @if ($informasi->hasMorePages())
                                <a href="{{ $informasi->nextPageUrl() }}"
                                    class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-3 py-1 rounded border text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(50px)';
                section.style.transition =
                    `opacity 0.8s ease ${index * 0.1}s, transform 0.8s ease ${index * 0.1}s`;
                observer.observe(section);
            });

            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('section');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            const counters = document.querySelectorAll('h3');
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                    if (target && !counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        let current = 0;
                        const increment = target / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = counter.textContent.replace(/[\d,]+/,
                                    target.toLocaleString());
                                clearInterval(timer);
                            } else {
                                counter.textContent = counter.textContent.replace(/[\d,]+/, Math
                                    .floor(current).toLocaleString());
                            }
                        }, 30);
                    }
                });
            };

            const statsSection = document.querySelector('.bg-primary-800');
            if (statsSection) {
                const statsObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                        }
                    });
                }, {
                    threshold: 0.5
                });

                statsObserver.observe(statsSection);
            }
        });
    </script>
@endpush
