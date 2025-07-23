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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><strong>Jenis Surat:</strong> {{ $suratdesa->jenis_surat }}</p>
                    <p><strong>Nama:</strong> {{ $suratdesa->nama }}</p>
                    <p><strong>NIK:</strong> {{ $suratdesa->nik }}</p>
                    <p><strong>Tempat & Tgl Lahir:</strong> {{ $suratdesa->tempat_tgl_lahir }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $suratdesa->jenis_kelamin }}</p>
                </div>
                <div>
                    <p><strong>Agama:</strong> {{ $suratdesa->agama }}</p>
                    <p><strong>Pekerjaan:</strong> {{ $suratdesa->pekerjaan }}</p>
                    <p><strong>Alamat:</strong> {{ $suratdesa->alamat }}</p>
                    <p><strong>Catatan Pemohon:</strong> {{ $suratdesa->catatan_pemohon ?? '-' }}</p>
                    <p><strong>Tanggal Dibuat:</strong> {{ $suratdesa->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Lampiran Gambar --}}
        @if ($suratdesa->dataPendukung->count())
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Lampiran Gambar</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($suratdesa->dataPendukung as $lampiran)
                        <img src="{{ route('admin.surat-desa.gambar.show', basename($lampiran->image)) }}"
                            alt="Lampiran Surat" class="w-full max-w-md rounded shadow">
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Aksi --}}
        <div class="flex flex-wrap gap-3 mt-4">
            <!-- Tombol Ubah Status -->
            @if ($suratdesa->status === 'diproses')
                <form action="{{ route('admin.surat-desa.update-status', $suratdesa->id) }}" method="POST"
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
