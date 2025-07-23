@extends('layout.sidebar')

@section('title', 'Tambah Berita - Sistem Informasi Desa')
@section('page-title', 'Tambah Berita Baru')

@section('content')
    <form action="{{ route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            <!-- nama -->
            <div>
                <label for="nama" class="block text-lg font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nama') border-red-500 @enderror"
                    placeholder="Masukkan nama" required>
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- jabatan -->
            <div>
                <label for="jabatan" class="block text-lg font-semibold text-gray-700 mb-2">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nama') border-red-500 @enderror"
                    placeholder="Masukkan jabanta" required>
                @error('jabanta')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Upload Gambar -->
            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Foto Anggota</label>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('image-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Unggah Foto</p>
                    <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>
                    <p class="text-gray-400 text-xs mt-2">Format: JPEG, PNG, JPG, GIF (Maks. 2MB)</p>
                    <input type="file" id="image-input" name="foto" accept="foto/*" class="hidden"
                        onchange="previewImage(this)">
                </div>
                @error('foto')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview Gambar Baru -->
                <div id="image-preview" class="text-center mt-6 hidden">
                    <img id="preview-image" src="{{ asset('image/Landing Page.png') }}" alt="Preview Gambar"
                        class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                    <p class="text-gray-500 text-sm mt-2">Preview gambar</p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex space-x-4 pt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Berita
                </button>
                <a href="{{ route('admin.struktur-organisasi.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Preview gambar
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag and drop functionality
        const uploadArea = document.querySelector('.upload-area');
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-50', 'bg-blue-100');
        });
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-100', 'bg-blue-50');
        });
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-100', 'bg-blue-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('image-input').files = files;
                previewImage(document.getElementById('image-input'));
            }
        });
    </script>
@endpush
