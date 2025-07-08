@extends('layout.Navbar')

@section('title', 'Beranda - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero Section with Parallax -->
    <section class="hero-bg min-h-screen flex items-center">
        <div class="container mx-auto px-4 transform transition-transform duration-500 ease-out" id="hero-content">
            <div class="max-w-4xl ml-20">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight animate-fade-in-up">
                    Selamat Datang<br>
                    <span class="text-blue-200">Di website Pemerintahan</span><br>
                    Desa Ngrejo
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl animate-fade-in-up delay-100">
                    Portal resmi informasi dan layanan publik Desa Ngrejo, Kabupaten Blitar, Jawa Timur
                </p>
                <div class="flex space-x-4 animate-fade-in-up delay-200">
                    <a href="#"
                        class="border-2 bg-orange-400 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Layanan Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Slider Dots -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <div class="w-3 h-3 bg-white rounded-full transition-all duration-300 dot-animation"></div>
            <div class="w-3 h-3 bg-white/50 rounded-full transition-all duration-300 dot-animation delay-100"></div>
            <div class="w-3 h-3 bg-white/50 rounded-full transition-all duration-300 dot-animation delay-200"></div>
        </div>
    </section>

    <!-- Profile Section -->
    <section class="py-20 bg-white ">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="relative animate-fade-in-left">
                    <div
                        class="relative rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-shadow duration-500">
                        <img src="/placeholder.svg?height=400&width=600" alt="Profile Video"
                            class="w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <button
                                class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center hover:bg-orange-600 transition-all duration-300 transform hover:scale-110 group">
                                <i
                                    class="fas fa-play text-white text-2xl ml-1 transform group-hover:scale-125 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="animate-fade-in-right">
                    <div class="w-12 h-1 bg-orange-500 mb-6 animate-grow-width"></div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6 animate-fade-in-up">Profil Desa Ngrejo</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8 animate-fade-in-up delay-100">
                        {{ $desa->profile_desa }}
                    </p>
                    <a href="{{ route('user.profile') }}"
                        class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 animate-fade-in-up delay-200">
                        Lihat Selengkapnya
                        <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Information Section -->
    <section class="py-20 bg-gray-50 ">
        <div class="container mx-auto px-4">
            @php
                $tigaTerbaru = $informasi->sortByDesc('created_at')->take(3);
            @endphp
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Informasi Terbaru</h2>
                <p class="text-gray-600 text-lg">Berita terbaru akan selalu diupdate secara berkala</p>
            </div>

            @if ($tigaTerbaru->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($tigaTerbaru as $index => $item)
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover transition-all duration-500 ease-out animate-fade-in-up delay-{{ $index * 100 }}">
                            <div class="relative">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->judul }}"
                                        class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105">
                                @else
                                    <img src="/placeholder.svg?height=250&width=400" alt="{{ $item->judul }}"
                                        class="w-full h-48 object-cover bg-gray-200 transition-transform duration-500 hover:scale-105">
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium transition-all duration-300 hover:bg-primary-700">
                                        {{ $item->kategori }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold text-gray-800 mb-3 hover:text-primary-600 transition-colors duration-300">
                                    <a href="#">{{ $item->judul }}</a>
                                </h3>
                                <p
                                    class="text-gray-600 mb-4 line-clamp-3 transition-all duration-300 hover:line-clamp-none">
                                    {{ Str::limit(strip_tags($item->konten), 150) }}
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center mr-3 transition-all duration-300 hover:bg-gray-400">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700">{{ $item->penulis }}</p>
                                        <p>{{ $item->created_at->format('d M, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 animate-fade-in">
                    <p class="text-gray-500">Tidak ada informasi tersedia</p>
                </div>
            @endif

            <div class="text-center animate-fade-in-up delay-300">
                <a href="{{ route('user.informasi') }}"
                    class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    Selengkapnya
                    <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section with Counter Animation -->
    <section class="py-20 bg-primary-800 text-white ">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center animate-fade-in-up">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-all duration-500 hover:bg-white/30 hover:scale-110">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-2 counter" data-target="2547">0</h3>
                    <p class="text-blue-200">Total Penduduk</p>
                </div>
                <div class="text-center animate-fade-in-up delay-100">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-all duration-500 hover:bg-white/30 hover:scale-110">
                        <i class="fas fa-home text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-2 counter" data-target="847">0</h3>
                    <p class="text-blue-200">Kepala Keluarga</p>
                </div>
                <div class="text-center animate-fade-in-up delay-200">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-all duration-500 hover:bg-white/30 hover:scale-110">
                        <i class="fas fa-map text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-2 counter" data-target="12.5">0</h3>
                    <p class="text-blue-200">Luas Wilayah (km²)</p>
                </div>
                <div class="text-center animate-fade-in-up delay-300">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 transition-all duration-500 hover:bg-white/30 hover:scale-110">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-2 counter" data-target="15">0</h3>
                    <p class="text-blue-200">Dusun</p>
                </div>
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
                const hero = document.querySelector('.hero-bg');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Add counter animation for statistics
            const counters = document.querySelectorAll('.bg-primary-800 h3');
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.textContent.replace(/[^\d.]/g, ''));
                    if (target && !counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        let current = 0;
                        const increment = target / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = counter.textContent.replace(/[\d,.]+/,
                                    target.toLocaleString());
                                clearInterval(timer);
                            } else {
                                counter.textContent = counter.textContent.replace(/[\d,.]+/,
                                    Math.floor(current).toLocaleString());
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
                            statsObserver.unobserve(entry.target);
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
