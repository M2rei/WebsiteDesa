@extends('layout.Navbar')

@section('title', 'Beranda - Desa Ngrejo Kabupaten Blitar Jawa Timur')
@section('meta_description', 'Portal resmi Desa Ngrejo, Kecamatan Bakung, Kabupaten Blitar, Jawa Timur. Informasi terkini, profil desa, potensi desa, struktur organisasi, dan layanan surat menyurat online.')

@push('styles')
    <style>
        .hero-kenburns {
            transform-origin: center;
            animation: kenburns 18s ease-in-out infinite alternate;
            will-change: transform;
            background-position: 60% 15%;
        }

        @keyframes kenburns {
            0% {
                transform: scale(1) translate(0, 0);
            }

            100% {
                transform: scale(1.08) translate(-1%, -1%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-kenburns {
                animation: none;
            }
        }

        @media (min-width: 768px) {
            .hero-kenburns {
                background-position: center 30%;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-20" id="hero-content">
            <div class="max-w-4xl ml-0 md:ml-20">
                <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white mb-6 leading-tight animate-fade-in-up">
                    Selamat Datang<br>
                    <span class="text-blue-200">di Website Pemerintahan</span><br>
                    Desa Ngrejo
                </h1>
                <p class="text-xl text-white md:text-blue-100 mb-8 max-w-2xl [text-shadow:0_2px_4px_rgb(0_0_0_/_60%)] md:[text-shadow:none] animate-fade-in-up delay-100">
                    Portal resmi informasi dan layanan publik Desa Ngrejo, Kabupaten Blitar, Jawa Timur
                </p>
                <div class="flex space-x-4 animate-fade-in-up delay-200">
                    <a href="{{ route('user.surat.create') }}"
                        class="inline-flex items-center bg-orange-700 hover:bg-orange-800 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Layanan Surat
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute inset-0 z-0 hero-kenburns"
            style="background-image: url('{{ asset('image/background/1.JPG') }}'); background-size: cover;">
        </div>

        <!-- Mobile contrast scrim -->
        <div class="absolute inset-0 z-10 bg-black/45 md:hidden"></div>
    </section>

    <!-- Profile Section -->
    <section class="py-20 bg-white ">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="relative animate-fade-in-left">
                    <div
                        class="relative rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-shadow duration-500">
                        <img src="{{ asset('image/background/1.JPG') }}" alt="Desa Ngrejo" width="1500" height="1000"
                            class="w-full h-80 object-cover">
                    </div>
                </div>

                <div class="animate-fade-in-right">
                    <div class="w-12 h-1 bg-orange-500 mb-6 animate-grow-width"></div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6 animate-fade-in-up">Profil Desa Ngrejo</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8 animate-fade-in-up delay-100">
                        {!! nl2br(e(\Illuminate\Support\Str::limit($desa->profile_desa, 200))) !!}
                    </p>
                    <a href="{{ route('user.profile') }}"
                        class="inline-flex items-center bg-orange-700 hover:bg-orange-800 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 animate-fade-in-up delay-200">
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
                $tigaTerbaru = $informasiTerbaru ?? ($informasi->sortByDesc('created_at')->take(3) ?? collect());
            @endphp
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Informasi Terbaru</h2>
            </div>

            @if ($tigaTerbaru->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($tigaTerbaru as $index => $item)
                        <article class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all border">
                            <div class="relative">
                                <a href="{{ route('user.informasi.show', $item->id) }}" class="absolute inset-0 z-10"></a>
                                @php
                                    $lampiran = $item->lampiran;
                                    $filePath = $lampiran?->file_path;
                                    $originalName = $lampiran?->original_name;
                                    $fileExists = $filePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($filePath);
                                    $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $isPdf = $ext === 'pdf';
                                @endphp

                                @if ($fileExists)
                                    @if ($isImage)
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $originalName }}"
                                                width="400" height="192" class="w-full h-48 object-cover">
                                        </a>
                                    @elseif ($isPdf)
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                            <div class="w-full h-48 bg-red-100 flex items-center justify-center rounded">
                                                <i class="fas fa-file-pdf text-red-600 text-5xl"></i>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded">
                                                <i class="fas fa-file text-gray-400 text-4xl"></i>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" alt="Tidak ada gambar"
                                        width="400" height="192" class="w-full h-48 object-cover">
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
            @else
                <div class="text-center py-12 animate-fade-in">
                    <p class="text-gray-500">Tidak ada informasi tersedia</p>
                </div>
            @endif

            <div class="text-center animate-fade-in-up delay-300">
                <a href="{{ route('user.informasi') }}"
                    class="inline-flex items-center bg-orange-700 hover:bg-orange-800 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    Selengkapnya
                    <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Struktur Organisasi Desa</h2>

            @if ($anggotaStruktur && $anggotaStruktur->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8">
                    @foreach ($anggotaStruktur as $anggota)
                        <div class="bg-white rounded-lg shadow text-center p-4 hover:shadow-md transition">
                            <img src="{{ \App\Helpers\ImageHelper::url($anggota->foto) }}" alt="{{ $anggota->nama }}"
                                width="96" height="96" class="w-24 h-24 mx-auto rounded-full object-cover mb-3 border">
                            <h3 class="text-md font-semibold text-gray-800">{{ $anggota->nama }}</h3>
                            <p class="text-sm text-gray-500">{{ $anggota->jabatan }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada anggota struktur organisasi yang tersedia.</p>
            @endif
        </div>
    </section>

    <!-- Peta Desa Ngrejo -->
    <section class="py-20 bg-white border-t">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Peta Satelit Desa Ngrejo</h2>
            <div id="map-container" onclick="loadDesaMap()"
                class="w-full h-[500px] rounded-lg overflow-hidden shadow-lg relative bg-gray-100 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors">
                <div class="text-center p-6">
                    <i class="fas fa-map-marked-alt text-5xl text-primary-600 mb-4"></i>
                    <p class="text-gray-700 font-semibold mb-1">Klik untuk memuat peta</p>
                    <p class="text-gray-500 text-sm">Peta interaktif dimuat dari Google Maps</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function loadDesaMap() {
            const container = document.getElementById('map-container');
            container.removeAttribute('onclick');
            container.classList.remove('cursor-pointer', 'hover:bg-gray-200');
            container.innerHTML = `<iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21109.271763216202!2d112.06310166530442!3d-8.243581464319378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78c31f13afc33d%3A0x4a2a96a0c82e2486!2sNgrejo%2C%20Kec.%20Bakung%2C%20Kabupaten%20Blitar%2C%20Jawa%20Timur!5e1!3m2!1sid!2sid!4v1752248904378!5m2!1sid!2sid"></iframe>`;
        }

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = '';
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
