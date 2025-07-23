@extends('layout.Navbar')

@section('title', $informasi->judul)

@section('content')
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $informasi->judul }}</h1>
            <div class="text-sm text-gray-500 mb-6">
                <span><i class="fas fa-user mr-1"></i>{{ $informasi->penulis }}</span> •
                <span><i class="fas fa-calendar-alt mr-1"></i>{{ $informasi->created_at->format('d M Y') }}</span>
            </div>

            @php
                $lampiran = $informasi->lampiran;
                $filePath = $lampiran?->file_path;
                $originalName = $lampiran?->original_name;
                $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isPdf = $ext === 'pdf';
            @endphp

            @if ($filePath)
                <div class="mb-6">
                    @if ($isImage)
                        <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $originalName }}" class="w-full rounded-lg">
                    @elseif ($isPdf)
                        <iframe src="{{ asset('storage/' . $filePath) }}#toolbar=1" class="w-full h-[600px] rounded-lg"
                            frameborder="0"></iframe>
                    @else
                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                            class="inline-block text-primary-600 underline">Unduh Lampiran ({{ strtoupper($ext) }})</a>
                    @endif
                </div>
            @endif

            <div class="prose max-w-none">
                {!! nl2br(e($informasi->deskripsi)) !!}
            </div>
        </div>
    </section>
@endsection
