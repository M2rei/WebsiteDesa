@extends('layout.sidebar')

@section('title', 'Detail Surat Desa')
@section('page-title', 'Detail Surat')

@section('content')
    <div class="space-y-6">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Informasi Surat --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Informasi Surat</h2>
            <p><strong>Status:</strong> {{ ucfirst($suratdesa->status) }}</p>
            <p><strong>Tanggal Diajukan:</strong> {{ $suratdesa->created_at->format('d/m/Y') }}</p>
            <p><strong>File Dokumen:</strong>
                <a href="{{ asset('storage/' . $suratdesa->dokumen) }}" target="_blank" class="text-blue-600 underline">
                    Lihat Dokumen
                </a>
            </p>
        </div>

        {{-- Data Pendukung --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Data Pendukung</h2>
            @if ($suratdesa->dataPendukung->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($suratdesa->dataPendukung as $lampiran)
                        <div class="border p-2 rounded">
                            <img src="{{ asset('storage/' . $lampiran->image) }}" alt="Lampiran"
                                class="w-full h-48 object-cover rounded">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Tidak ada lampiran gambar.</p>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-wrap gap-3 mt-4">
            <!-- Tombol Download Dokumen Word -->
            <a href="{{ asset('storage/' . $suratdesa->dokumen) }}" download
                class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                <i class="fas fa-file-word mr-2"></i>Download Dokumen Word
            </a>

            <!-- Tombol Download Lampiran PDF -->
            <a href="{{ route('admin.surat-desa.admin.surat-desa.download-pdf', $suratdesa->id) }}"
                class="inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                <i class="fas fa-file-pdf mr-2"></i>Download Data Pendukung PDF
            </a>

            <!-- Tombol Ubah Status -->
            @if ($suratdesa->status === 'diproses')
                <form action="{{ route('admin.surat-desa.admin.surat-desa.update-status', $suratdesa->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin mengubah status menjadi selesai?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                        Tandai Selesai
                    </button>
                </form>
            @else
                <span class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md">
                    Status: Selesai
                </span>
            @endif
            <a href="{{ route('admin.surat-desa.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
