@extends('layout.sidebar')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">{{ $dokumendesa->nama_document }}</h2>
        <p class="text-gray-600 text-sm mb-4">
            Kategori: <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-800 text-sm">
                {{ $dokumendesa->kategori }}
            </span>
        </p>

        @php
            $ext = pathinfo($dokumendesa->dokumen, PATHINFO_EXTENSION);
        @endphp

        @if ($ext === 'pdf')
            <iframe src="{{ asset('storage/' . $dokumendesa->dokumen) }}" class="w-full h-[600px] border rounded-lg"></iframe>
        @else
            <a href="{{ asset('storage/' . $dokumendesa->dokumen) }}" target="_blank" class="text-blue-600 underline">
                Unduh Dokumen ({{ strtoupper($ext) }})
            </a>
            <p class="text-sm text-gray-500 mt-1">Preview hanya tersedia untuk file PDF.</p>
        @endif

        <a href="{{ route('admin.dokumen-desa.index') }}"
            class="inline-block mt-6 bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Kembali
        </a>
    </div>
@endsection
