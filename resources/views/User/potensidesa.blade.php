@extends('layout.Navbar')

@section('title', 'Potensi Desa - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero -->
    <section class="relative bg-primary-800 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-50"
            style="background-image: url('{{ asset('image/background/1.JPG') }}')">
        </div>
        <div class="relative z-10 container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mt-6">
                <h1 class="text-5xl font-bold mb-4">Potensi Desa Ngrejo</h1>
                <p class="text-xl text-blue-200">Mengenal kekayaan dan potensi untuk kemajuan bersama</p>
            </div>
        </div>
    </section>

    <!-- Filter -->
    <section class="py-10 bg-white border-b">
        <div class="container mx-auto px-4">
            <form action="{{ route('user.potensidesa') }}" method="GET"
                class="w-full max-w-4xl mx-auto grid gap-4 md:grid-cols-3 items-end">

                <!-- Dropdown Kategori -->
                <div x-data="{ open: false }" class="relative w-full">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <button @click="open = !open" type="button"
                        class="flex justify-between items-center w-full px-4 py-2 text-sm border rounded-lg bg-white">
                        {{ request('kategori') ? ucfirst(request('kategori')) : 'Semua Kategori' }}
                        <i class="fas fa-chevron-down ml-2 text-gray-500 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute z-10 mt-1 w-full bg-white border rounded-lg shadow-md py-1">
                        <a href="{{ route('user.potensidesa') }}"
                            class="block px-4 py-2 hover:bg-gray-50 {{ !request('kategori') ? 'font-medium text-blue-600' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach ($semuaKategori as $kategori)
                            <a href="{{ route('user.potensidesa', ['kategori' => $kategori]) }}"
                                class="block px-4 py-2 hover:bg-gray-50 {{ request('kategori') == $kategori ? 'font-medium text-blue-600' : '' }}">
                                {{ ucfirst($kategori) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Input Pencarian -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Pencarian Judul</label>
                    <div class="flex rounded-lg shadow-sm">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-l-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 px-4 py-2"
                            placeholder="Ketik nama potensi...">
                        <button type="submit"
                            class="bg-primary-600 text-white px-4 py-2 rounded-r-lg hover:bg-primary-700 transition flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span class="hidden sm:inline">Cari</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Potensi Desa -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Semua Informasi</h2>
                        <p class="text-gray-600">
                            {{ $potensi->total() }} item ditemukan
                        </p>
                    </div>
                </div>

                @if ($potensi->isEmpty())
                    <p class="text-center text-gray-500">Belum ada informasi yang tersedia.</p>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach ($potensi as $item)
                            <a href="{{ route('user.potensidesa.show', $item->id) }}">
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

                    <!-- Pagination -->
                    <div class="flex flex-col sm:flex-row items-center justify-between mt-8">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $potensi->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $potensi->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $potensi->total() }}</span>
                                hasil
                            </p>
                        </div>

                        <div class="flex items-center space-x-1">
                            <!-- Previous Button -->
                            @if ($potensi->onFirstPage())
                                <span class="px-3 py-1 rounded border text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $potensi->previousPageUrl() }}"
                                    class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            <!-- Page Numbers -->
                            @foreach ($potensi->getUrlRange(1, $potensi->lastPage()) as $page => $url)
                                @if ($page == $potensi->currentPage())
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

                            <!-- Next Button -->
                            @if ($potensi->hasMorePages())
                                <a href="{{ $potensi->nextPageUrl() }}"
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
        // Smooth scrolling animation
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
            // Add initial styles for animation
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(50px)';
                section.style.transition =
                    `opacity 0.8s ease ${index * 0.1}s, transform 0.8s ease ${index * 0.1}s`;
                observer.observe(section);
            });

            // Add parallax effect to hero section
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('section');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Add counter animation for statistics
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

            // Trigger counter animation when statistics section is visible
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
