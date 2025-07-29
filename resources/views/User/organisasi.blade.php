@extends('layout.Navbar')

@section('title', 'Struktur Organisasi - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <section class="relative bg-primary-800 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-50"
            style="background-image: url('{{ asset('image/background/1.JPG') }}')">
        </div>
        <div class="relative z-10 container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mt-6">
                <h1 class="text-5xl font-bold mb-6">Struktur Organisasi Desa Ngrejo</h1>
                <p class="text-xl text-blue-200">Susunan kepengurusan dan jabatan pemerintahan Desa Ngrejo</p>
            </div>
        </div>
    </section>

    <!-- Bagan Struktur Organisasi -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Bagan Struktur Organisasi</h2>
            @if ($strukturOrganisasi && $strukturOrganisasi->image)
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $strukturOrganisasi->image) }}" alt="Bagan Struktur Organisasi"
                        class="w-full max-w-5xl rounded-lg shadow-md border">
                </div>
            @else
                <p class="text-gray-500">Belum ada bagan struktur organisasi yang diunggah.</p>
            @endif
        </div>
    </section>

    <!-- Deskripsi & Anggota Struktur -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">

            <div class="text-center mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Anggota Struktur Organisasi</h3>
            </div>

            <div class="flex justify-center">
                <div class="w-full max-w-6xl px-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 justify-items-center">
                        @forelse ($anggotaStruktur as $anggota)
                            <div
                                class="bg-white shadow hover:shadow-lg transition rounded-lg p-4 text-center border border-gray-200">
                                <img src="{{ asset('storage/' . $anggota->foto) }}" alt="{{ $anggota->nama }}"
                                    class="w-24 h-24 object-cover rounded-full mx-auto mb-3 border-2 border-gray-300">
                                <h3 class="text-md font-semibold text-gray-800">{{ $anggota->nama }}</h3>
                                <p class="text-sm text-gray-500">{{ $anggota->jabatan }}</p>
                            </div>
                        @empty
                            <p class="col-span-5 text-center text-gray-500">Belum ada anggota struktur organisasi yang
                                ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
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
