@extends('layout.sidebar')

@section('title', 'Edit Informasi')
@section('page-title', 'Edit Informasi')

@section('content')
    <form action="{{ route('admin.informasi.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="space-y-6">
            <div>
                <label for="judul" class="block text-lg font-semibold text-gray-700 mb-2">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label for="deskripsi" class="block text-lg font-semibold text-gray-700 mb-2">Isi Berita</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" class="w-full px-4 py-3 border rounded-lg">{{ old('deskripsi', $berita->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="penulis" class="block text-lg font-semibold text-gray-700 mb-2">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}"
                    class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label for="kategori" class="block text-lg font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-3 border rounded-lg">
                    <option value="Pengumuman" {{ $berita->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="Berita" {{ $berita->kategori == 'Berita' ? 'selected' : '' }}>Berita</option>
                    <option value="Kegiatan" {{ $berita->kategori == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="Layanan" {{ $berita->kategori == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                    <option value="Peraturan" {{ $berita->kategori == 'Peraturan' ? 'selected' : '' }}>Peraturan
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Unggah Lampiran Baru</label>

                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('lampiran-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Klik untuk memilih file atau drag & drop</p>
                    <p class="text-gray-400 text-xs mt-2">Format: JPEG, PNG, JPG, PDF (Maks. 2MB)</p>
                    <input type="file" id="lampiran-input" name="lampiran" accept="image/*,application/pdf"
                        class="hidden" onchange="previewLampiran(this)">
                </div>
                @error('lampiran')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($berita->lampiran)
                    <div class="mb-6">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Lampiran Sebelumnya</label>
                        @php
                            $filePath = $berita->lampiran->file_path;
                            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $filePath) }}" alt="Lampiran"
                                class="w-full max-w-sm rounded border">
                        @elseif ($ext === 'pdf')
                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                class="inline-flex items-center space-x-2 text-red-600 hover:underline">
                                <i class="fas fa-file-pdf text-2xl"></i>
                                <span>{{ $berita->lampiran->original_name }}</span>
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                class="inline-flex items-center space-x-2 text-gray-600 hover:underline">
                                <i class="fas fa-file text-2xl"></i>
                                <span>{{ $berita->lampiran->original_name }}</span>
                            </a>
                        @endif
                    </div>
                @endif

                <div id="preview-container" class="text-center mt-6 hidden">
                    <img id="preview-image" class="mx-auto rounded-lg border border-gray-200 shadow-sm"
                        style="max-height: 300px; display: none;">
                    <embed id="preview-pdf" type="application/pdf" class="mx-auto border border-gray-200 shadow-sm"
                        width="100%" height="400px" style="display: none; max-width: 600px;" />
                    <p class="text-gray-500 text-sm mt-2">Preview Lampiran Baru</p>
                </div>
            </div>
            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.informasi.index') }}"
                    class="ml-4 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-full">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function previewLampiran(input) {
            const file = input.files[0];
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const previewPdf = document.getElementById('preview-pdf');

            previewImage.style.display = 'none';
            previewPdf.style.display = 'none';
            previewContainer.classList.add('hidden');

            if (file) {
                const reader = new FileReader();
                const fileType = file.type;

                previewContainer.classList.remove('hidden');

                if (fileType.startsWith('image/')) {
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewPdf.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    const url = URL.createObjectURL(file);
                    previewPdf.src = url;
                    previewPdf.style.display = 'block';
                    previewImage.style.display = 'none';
                } else {
                    previewContainer.classList.add('hidden');
                    alert("Format file tidak didukung");
                }
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
                previewLampiran(document.getElementById('lampiran-input'));
            }
        });
    </script>
@endpush
