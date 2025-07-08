@extends('layout.sidebar')

@section('title', 'Struktur Organisasi - Sistem Informasi Desa')
@section('page-title', 'Struktur Organisasi')

@section('content')
    <form action="{{ route('admin.struktur-organisasi.update', $strukturOrganisasi->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Upload Struktur Organisasi -->
        <div>
            <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center
                        bg-blue-50 hover:bg-blue-100 cursor-pointer"
                onclick="document.getElementById('image-input').click()">
                <div class="text-blue-500 mb-4">
                    <i class="fas fa-cloud-upload-alt text-5xl"></i>
                </div>
                <p class="text-gray-700 font-medium mb-2">Unggah gambar struktur</p>
                <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>

                <!-- gunakan name="image" -->
                <input type="file" id="image-input" name="image" accept="image/*" class="hidden"
                    onchange="previewImage(this)">
            </div>
            @error('image')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- tampilkan gambar saat ini --}}
            @if (!empty($strukturOrganisasi->image))
                <div class="text-center mt-6">
                    <img src="{{ asset('storage/' . $strukturOrganisasi->image) }}" alt="Struktur Organisasi"
                        class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                    <p class="text-gray-500 text-sm mt-2">Gambar saat ini</p>
                </div>
            @endif

            {{-- preview gambar baru --}}
            <div id="image-preview" class="text-center mt-6 hidden">
                <img id="preview-image" src="/placeholder.svg" alt="Preview gambar"
                    class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                <p class="text-gray-500 text-sm mt-2">Preview gambar baru</p>
            </div>
        </div>

        <!-- Tombol aksi -->
        <div class="flex space-x-4 pt-6">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.struktur-organisasi.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag & drop
        const area = document.querySelector('.upload-area');
        area.addEventListener('dragover', e => {
            e.preventDefault();
            area.classList.replace('bg-blue-50', 'bg-blue-100');
        });
        area.addEventListener('dragleave', e => {
            e.preventDefault();
            area.classList.replace('bg-blue-100', 'bg-blue-50');
        });
        area.addEventListener('drop', e => {
            e.preventDefault();
            area.classList.replace('bg-blue-100', 'bg-blue-50');
            const files = e.dataTransfer.files;
            if (files.length) {
                document.getElementById('image-input').files = files;
                previewImage(document.getElementById('image-input'));
            }
        });
    </script>
@endpush
