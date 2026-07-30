@extends('layout.Navbar')

@section('title', 'Struktur Organisasi - Desa Ngrejo Kabupaten Blitar Jawa Timur')
@section('meta_description', 'Susunan struktur organisasi dan jajaran perangkat Pemerintah Desa Ngrejo, Kabupaten Blitar, Jawa Timur.')

@section('content')
    <x-hero-banner title="Struktur Organisasi Desa Ngrejo"
        subtitle="Susunan kepengurusan dan jabatan pemerintahan Desa Ngrejo" image="image/background/2.JPG" />

    <!-- Bagan Struktur Organisasi -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Bagan Struktur Organisasi</h2>
            <div class="flex justify-center">
                <img src="{{ \App\Helpers\ImageHelper::url($strukturOrganisasi?->image) }}"
                    alt="Bagan Struktur Organisasi" width="1000" height="700"
                    class="w-full max-w-5xl rounded-lg shadow-md border">
            </div>
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
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @forelse ($anggotaStruktur as $anggota)
                            <div class="bg-white rounded-lg shadow text-center p-4 hover:shadow-md transition">
                                <img src="{{ \App\Helpers\ImageHelper::url($anggota->foto) }}" alt="{{ $anggota->nama }}"
                                    width="96" height="96"
                                    class="w-24 h-24 mx-auto rounded-full object-cover mb-3 border">
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
