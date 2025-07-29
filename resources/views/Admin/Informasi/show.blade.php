@extends('layout.sidebar')

@section('title', 'Detail Infromasi')
@section('page-title', 'Detail Berita')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">{{ $berita->judul }}</h2>

        <p class="text-gray-600 text-sm mb-2">Penulis: <strong>{{ $berita->penulis }}</strong></p>
        <p class="text-gray-600 text-sm mb-4">Kategori: {{ $berita->kategori }}</p>

        @if ($berita->lampiran)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Lampiran Informasi:</h3>

                @php
                    $filePath = $berita->lampiran->file_path;
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <img src="{{ asset('storage/' . $filePath) }}" alt="Lampiran" class="w-full max-w-md rounded border">
                @elseif ($ext === 'pdf')
                    <embed src="{{ asset('storage/' . $filePath) }}" type="application/pdf"
                        class="w-full max-w-3xl border rounded" height="500px">
                    <p class="text-sm mt-2 text-gray-600">File: {{ $berita->lampiran->original_name }}</p>
                @else
                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                        class="inline-flex items-center space-x-2 text-blue-600 hover:underline">
                        <i class="fas fa-file text-2xl"></i>
                        <span>{{ $berita->lampiran->original_name }}</span>
                    </a>
                @endif
            </div>
        @endif

        <div class="text-gray-800 leading-relaxed">
            {!! nl2br(e($berita->deskripsi)) !!}
        </div>

        <a href="{{ route('admin.informasi.index') }}"
            class="inline-block mt-6 bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Kembali
        </a>
    </div>
@endsection
