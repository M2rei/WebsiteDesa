@extends('layout.Navbar')

@section('title', 'Struktur Organisasi - Desa Ngrejo Kabupaten Blitar Jawa Timur')

@section('content')
    <!-- Hero -->
    <section class="bg-primary-800 text-white py-20">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Struktur Organisasi Desa Ngrejo</h1>
            <p class="text-green-100 text-lg md:text-xl">Susunan kepengurusan dan jabatan pemerintahan Desa Ngrejo</p>
        </div>
    </section>

    <!-- Struktur Gambar & Teks -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            
            <div class="max-w-4xl mx-auto text-center">
                <!-- Gambar Struktur -->
                @if ($strukturOrganisasi && $strukturOrganisasi->image)
                    <img src="{{ asset('storage/' . $strukturOrganisasi->image) }}" alt="Struktur Organisasi Desa Ngrejo"
                        class="w-full max-w-3xl mx-auto rounded-lg shadow-lg mb-8">
                @else
                    <p class="text-gray-500 mb-8">Belum ada gambar struktur organisasi yang diunggah.</p>
                @endif
                <!-- Deskripsi -->
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Struktur Organisasi Pemerintahan Desa</h2>
                <p class="text-gray-600 leading-relaxed">
                    Struktur organisasi desa Ngrejo terdiri dari Kepala Desa, Sekretaris Desa, Kepala Urusan, dan
                    Kepala Seksi yang bekerja bersama untuk menyelenggarakan pemerintahan dan pelayanan kepada masyarakat.
                    Setiap posisi memiliki tanggung jawab yang jelas sesuai dengan tugas pokok dan fungsinya.
                </p>
            </div>
        </div>
    </section>
@endsection
