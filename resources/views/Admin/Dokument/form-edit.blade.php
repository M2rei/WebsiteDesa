@extends('layout.sidebar')

@section('title', 'Edit Dokumen - Sistem Informasi Desa')
@section('page-title', 'Edit Dokumen')

@section('content')
    <form action="{{ route('admin.dokumen-desa.update', $dokumendesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Hidden ID Desa -->
            <input type="hidden" name="desa_id" value="{{ $dokumendesa->desa_id }}">

            <!-- Nama Dokumen -->
            <div>
                <label for="nama_document" class="block text-lg font-semibold text-gray-700 mb-2">Nama Dokumen</label>
                <input type="text" id="nama_document" name="nama_document"
                    value="{{ old('nama_document', $dokumendesa->nama_document) }}"
                    class="w-full px-4 py-3 border rounded-lg @error('nama_document') border-red-500 @enderror"
                    placeholder="Contoh: Surat Pengantar, Surat Keterangan..." required>
                @error('nama_document')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-lg font-semibold text-gray-700 mb-2">Kategori Dokumen</label>
                <select id="kategori" name="kategori"
                    class="w-full px-4 py-3 border rounded-lg @error('kategori') border-red-500 @enderror" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Surat" {{ old('kategori', $dokumendesa->kategori) == 'Surat' ? 'selected' : '' }}>Surat
                    </option>
                    <option value="Legalitas"
                        {{ old('kategori', $dokumendesa->kategori) == 'Legalitas' ? 'selected' : '' }}>Legalitas</option>
                    <option value="Formulir" {{ old('kategori', $dokumendesa->kategori) == 'Formulir' ? 'selected' : '' }}>
                        Formulir</option>
                    <option value="Lainnya" {{ old('kategori', $dokumendesa->kategori) == 'Lainnya' ? 'selected' : '' }}>
                        Lainnya</option>
                </select>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="field-container-wrapper" class="hidden">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Placeholder Field</label>

                <div id="field-container" class="space-y-2">
                    @php
                        $fieldArray = json_decode($dokumendesa->fields ?? '[]', true);
                    @endphp

                    @if (!empty($fieldArray))
                        @foreach ($fieldArray as $field)
                            <div class="flex items-center gap-2">
                                <input type="text" name="fields[]" value="{{ $field }}"
                                    class="w-full px-4 py-2 border rounded-lg" placeholder="Contoh: nama_lengkap" required>
                                <button type="button" onclick="removeField(this)"
                                    class="text-red-500 hover:text-red-700 text-xl font-bold">&times;</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" onclick="addField()"
                    class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm font-medium">
                    + Tambah Field
                </button>

                @error('fields')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Dokumen Baru -->
            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Ganti File Dokumen (.docx)</label>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('dokumen-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-file-word text-5xl text-blue-600"></i>
                        <i class="fas fa-file-pdf text-5xl text-red-600"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Klik untuk memilih file dokumen baru</p>
                    <p class="text-gray-500 text-sm">Format: DOCX, PDF. Maksimum 2MB</p>
                    <input type="file" id="dokumen-input" name="dokumen" accept=".docx" class="hidden">
                    <p id="file-name" class="text-sm text-gray-700 mt-2"></p>
                </div>
                @error('dokumen')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($dokumendesa->dokumen)
                    <div class="mt-4 text-sm">
                        <p class="text-gray-600">File Saat Ini:</p>

                        @php
                            $extension = pathinfo($dokumendesa->dokumen, PATHINFO_EXTENSION);
                        @endphp

                        @if ($extension === 'pdf')
                            <iframe src="{{ asset('storage/' . $dokumendesa->dokumen) }}"
                                class="w-full h-96 border mt-2 rounded-lg"></iframe>
                            <a href="{{ asset('storage/' . $dokumendesa->dokumen) }}" target="_blank"
                                class="text-blue-600 underline block mt-2">
                                Unduh PDF
                            </a>
                        @elseif ($extension === 'docx')
                            <a href="{{ asset('storage/' . $dokumendesa->dokumen) }}" download
                                class="text-blue-600 underline">
                                Unduh File Word
                            </a>
                        @else
                            <p class="text-red-500">Format file tidak dikenali.</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Tombol Aksi -->
            <div class="flex space-x-4 pt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Dokumen
                </button>
                <a href="{{ route('admin.dokumen-desa.index') }}"
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
        const kategoriSelect = document.getElementById('kategori');
        const fieldWrapper = document.getElementById('field-container-wrapper');
        const fileInput = document.getElementById('dokumen-input');
        const fileNameDisplay = document.getElementById('file-name');
        const uploadArea = document.querySelector('.upload-area');

        kategoriSelect.addEventListener('change', function() {
            if (this.value === 'Surat') {
                fieldWrapper.classList.remove('hidden');
            } else {
                fieldWrapper.classList.add('hidden');
                document.getElementById('field-container').innerHTML = '';
            }
        });

        function addField() {
            const container = document.getElementById('field-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-2');
            div.innerHTML = `
            <input type="text" name="fields[]" class="w-full px-4 py-2 border rounded-lg" placeholder="Contoh: alamat" required>
            <button type="button" onclick="removeField(this)" class="text-red-500 hover:text-red-700 text-xl font-bold">&times;</button>
        `;
            container.appendChild(div);
        }

        function removeField(button) {
            button.parentElement.remove();
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (kategoriSelect.value === 'Surat') {
                fieldWrapper.classList.remove('hidden');
            } else {
                fieldWrapper.classList.add('hidden');
            }
        });
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        });

        // Drag & Drop
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
                fileInput.files = files;
                fileNameDisplay.textContent = files[0].name;
            }
        });
    </script>
@endpush
