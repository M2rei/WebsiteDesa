@extends('layout.Navbar')

@section('title', 'Profile Desa - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary-800 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-6">Profil Desa Ngrejo</h1>
                <p class="text-xl text-blue-200">Mengenal lebih dekat tentang Desa Ngrejo, Kabupaten Blitar, Jawa Timur</p>
            </div>
        </div>
    </section>

    <!-- Logo & Header Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <img src="{{ asset('storage/' . $desa->logo_url) }}" alt="Logo Desa" class="mx-auto max-h-40 mb-8 ">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Desa Ngrejo</h2>
                <p class="text-xl text-gray-600">Kabupaten Blitar, Jawa Timur</p>
                <div class="w-24 h-1 bg-orange-500 mx-auto mt-6"></div>
            </div>
        </div>
    </section>

    <!-- Profile Desa Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-6">
                        <i class="fas fa-home text-2xl text-orange-600"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Tentang Desa Ngrejo</h2>
                    <div class="w-16 h-1 bg-orange-500 mx-auto"></div>
                </div>
                <div class="bg-white rounded-3xl p-10 shadow-xl">
                    <div class="text-gray-700 leading-relaxed text-lg text-justify">
                        <p>{{ $desa->profile_desa }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-6">
                        <i class="fas fa-history text-2xl text-blue-600"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Sejarah Desa</h2>
                    <div class="w-16 h-1 bg-blue-500 mx-auto"></div>
                </div>
                <div class="bg-blue-50 rounded-3xl p-10 shadow-xl">
                    <div class="text-gray-700 leading-relaxed text-lg text-justify">
                        <p>{{ $desa->sejarah }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Visi & Misi</h2>
                    <p class="text-xl text-gray-600">Arah dan tujuan pembangunan Desa Ngrejo</p>
                    <div class="w-24 h-1 bg-purple-500 mx-auto mt-6"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12">
                    <!-- Visi -->
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 h-full">
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-eye text-white text-3xl"></i>
                                </div>
                                <h3 class="text-3xl font-bold text-gray-800">Visi</h3>
                                <div class="w-12 h-1 bg-green-500 mx-auto mt-4"></div>
                            </div>
                            <div class="text-gray-700 leading-relaxed text-lg text-center">
                                <div class="bg-green-50 rounded-2xl p-6 italic font-medium">
                                    <p>{{ $desa->visi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Misi -->
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 h-full">
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 bg-purple-500 rounded-full mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-target text-white text-3xl"></i>
                                </div>
                                <h3 class="text-3xl font-bold text-gray-800">Misi</h3>
                                <div class="w-12 h-1 bg-purple-500 mx-auto mt-4"></div>
                            </div>
                            <div class="text-gray-700 leading-relaxed text-lg">
                                <div class="bg-purple-50 rounded-2xl p-6">
                                    <div class="space-y-4">
                                        @php
                                            $misiItems = preg_split('/\r\n|\r|\n/', $desa->misi);
                                            $misiItems = array_filter($misiItems, function ($item) {
                                                return trim($item) !== '';
                                            });
                                        @endphp

                                        @foreach ($misiItems as $misi)
                                            <div class="flex">
                                                <div class="font-semibold mr-2">{{ Str::before(trim($misi), ' ') }}</div>
                                                <div>{{ Str::after(trim($misi), ' ') }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-orange-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">Mari Bersama Membangun Desa</h2>
                <p class="text-xl text-orange-100 mb-8">
                    Dengan semangat gotong royong dan kerja sama, mari kita wujudkan Desa Ngrejo yang maju, mandiri, dan
                    sejahtera
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href=""
                        class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Layanan Surat
                    </a>
                    <a href=""
                        class="border-2 border-white text-white hover:bg-white hover:text-orange-600 px-8 py-4 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
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
