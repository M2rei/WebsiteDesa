@extends('layout.sidebar')

@section('title', 'Tambah Informasi - Sistem Informasi Desa')
@section('page-title', 'Tambah Informasi Baru')

@section('content')
    <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="judul" class="block text-lg font-semibold text-gray-700 mb-2">Judul Berita</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('judul') border-red-500 @enderror"
                    placeholder="Masukkan judul berita" required>
                @error('judul')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-lg font-semibold text-gray-700 mb-2">Isi Berita</label>
                <textarea id="deskripsi" name="deskripsi"
                    class="w-full px-4 py-3 border rounded-lg @error('deskripsi') border-red-500 @enderror" rows="8"
                    placeholder="Tulis isi informasi disini" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="penulis" class="block text-lg font-semibold text-gray-700 mb-2">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}"
                    class="w-full px-4 py-3 border rounded-lg @error('penulis') border-red-500 @enderror"
                    placeholder="Nama penulis" required>
                @error('penulis')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori" class="block text-lg font-semibold text-gray-700 mb-2">Kategori</label>
                <select id="kategori" name="kategori"
                    class="w-full px-4 py-3 border rounded-lg @error('kategori') border-red-500 @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="Berita" {{ old('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                    <option value="Kegiatan" {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="Layanan" {{ old('kategori') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                    <option value="Peraturan" {{ old('kategori') == 'Peraturan' ? 'selected' : '' }}>Peraturan
                    </option>
                </select>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Lampiran Informasi</label>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('lampiran-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Unggah Lampiran Informasi</p>
                    <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>
                    <p class="text-gray-400 text-xs mt-2">Format: JPEG, PNG, JPG, Pdf (Maks. 2MB)</p>
                    <input type="file" id="lampiran-input" name="lampiran" accept="image/*,application/pdf"
                        class="hidden" onchange="previewImage(this)">
                </div>
                @error('lampiran')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div id="preview-container" class="text-center mt-6 hidden">
                    <img id="preview-image" class="mx-auto rounded-lg border border-gray-200 shadow-sm"
                        style="max-height: 300px; display: none;">
                    <embed id="preview-pdf" type="application/pdf" class="mx-auto border border-gray-200 shadow-sm"
                        width="100%" height="400px" style="display: none; max-width: 600px;" />

                    <p class="text-gray-500 text-sm mt-2">Preview Lampiran</p>
                </div>
            </div>
            <div class="flex space-x-4 pt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Informasi
                </button>
                <a href="{{ route('admin.informasi.index') }}"
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
        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const previewPdf = document.getElementById('preview-pdf');

            previewImage.style.display = 'none';
            previewPdf.style.display = 'none';
            previewContainer.classList.add('hidden');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;

                const reader = new FileReader();

                reader.onload = function(e) {
                    if (fileType.startsWith('image/')) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewContainer.classList.remove('hidden');
                    } else if (fileType === 'application/pdf') {
                        previewPdf.src = e.target.result;
                        previewPdf.style.display = 'block';
                        previewContainer.classList.remove('hidden');
                    }
                };

                reader.readAsDataURL(file);
            }
        }

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
                document.getElementById('lampiran-input').files = files;
                previewImage(document.getElementById('lampiran-input'));
            }
        });
    </script>
@endpush
