@extends('layout.Navbar')

@section('title', 'Ajukan Surat Desa')

@section('content')
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold">Ajukan Surat Desa</h1>
        </div>
    </section>

    <div class="container mx-auto mt-10 px-4">

        {{-- Pesan sukses + tombol download PDF --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded bg-green-100 text-green-800">
                {{ session('success') }}

                @if (session('file_url'))
                    <div class="mt-3">
                        <a href="{{ session('file_url') }}" target="_blank"
                            class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Unduh Surat
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('user.surat.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
            @csrf

            <input type="hidden" name="desa_id" value="{{ $desa->id }}">

            <!-- Pilih Surat -->
            <div class="mb-6">
                <label for="pilih-surat" class="block mb-2 font-semibold text-gray-700">Pilih Jenis Surat:</label>
                <select name="dokumen_desa_id" id="pilih-surat" class="w-full border rounded p-2"
                    onchange="loadDocContent(this)">
                    <option value="">-- Pilih Surat --</option>
                    @foreach ($dokumenSurat as $dokumen)
                        <option value="{{ $dokumen->id }}">{{ $dokumen->nama_document }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Field Dinamis -->
            <div id="field-dinamis" class="mb-6 space-y-4 hidden">
                <p class="text-gray-800 font-semibold">Isian Surat:</p>
                <div id="field-container"></div>
            </div>

            <!-- Upload Lampiran -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Lampiran (opsional)</label>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('lampiran-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Unggah Lampiran Gambar</p>
                    <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>
                    <p class="text-gray-400 text-xs mt-2">Format: JPEG, PNG, JPG, GIF (maks. 2MB per gambar)</p>
                    <input type="file" id="lampiran-input" name="images[]" accept="image/*" multiple class="hidden"
                        onchange="previewLampiran(this)">
                </div>
                <div id="lampiran-preview" class="f flex-wrap gap-4 mt-4 h"></div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Ajukan Surat
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function loadDocContent(selectElement) {
            const docId = selectElement.value;
            const fieldWrapper = document.getElementById('field-dinamis');
            const fieldContainer = document.getElementById('field-container');

            fieldContainer.innerHTML = '';
            fieldWrapper.classList.add('hidden');

            if (!docId) return;

            fetch(`/user/dokumen/${docId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Gagal memuat field');
                    return res.json();
                })
                .then(data => {
                    const fields = JSON.parse(data.fields || '[]');
                    if (fields.length === 0) return;

                    fields.forEach(field => {
                        const label = field.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                        const html = `
                        <div>
                            <label class="block text-gray-700 mb-1">${label}</label>
                            <input type="text" name="${field}" class="w-full border rounded px-3 py-2" required>
                        </div>`;
                        fieldContainer.insertAdjacentHTML('beforeend', html);
                    });

                    fieldWrapper.classList.remove('hidden');
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data surat.');
                });
        }

        // ✅ Download otomatis PDF setelah redirect
        @if (session('file_url'))
            window.onload = function() {
                window.open("{{ session('file_url') }}", '_blank');
            };
        @endif

        function previewLampiran(input) {
            const previewContainer = document.getElementById('lampiran-preview');
            previewContainer.innerHTML = '';
            previewContainer.classList.add('hidden');

            if (input.files && input.files.length > 0) {
                previewContainer.classList.remove('hidden');

                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-32 h-32 object-cover rounded border';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Drag and drop
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
