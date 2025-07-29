@extends('layout.Navbar')

@section('title', 'Ajukan Surat Desa')

@section('content')
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto text-center mt-6">
            <h1 class="text-4xl font-bold">Ajukan Surat Desa</h1>
        </div>
    </section>

    <div class="container mx-auto mt-10 px-4">

        <form id="form-pengajuan" action="{{ route('user.surat.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jenis Surat yang Diajukan</label>
                <select name="jenis_surat" class="w-full px-4 py-2 border rounded" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="SURAT KETERANGAN DOMISILI">SURAT KETERANGAN DOMISILI</option>
                    <option value="SURAT KETERANGAN USAHA">SURAT KETERANGAN USAHA</option>
                    <option value="SURAT KETERANGAN TINGGAL SEMENTARA">SURAT KETERANGAN TINGGAL SEMENTARA</option>
                    <option value="SURAT KETERANGAN">SURAT KETERANGAN</option>
                    <option value="SURAT KETERANGAN KEHILANGAN">SURAT KETERANGAN KEHILANGAN</option>
                    <option value="SURAT KETERANGAN PINDAH">SURAT KETERANGAN PINDAH</option>
                    <option value="SURAT KETERANGAN KELAKUAN BAIK">SURAT KETERANGAN KELAKUAN BAIK</option>
                    <option value="SURAT KETERANGAN KEMATIAN">SURAT KETERANGAN KEMATIAN</option>
                    <option value="SURAT KETERANGAN KELAHIRAN">SURAT KETERANGAN KELAHIRAN</option>
                    <option value="SURAT KETERANGAN AHLI WARIS">SURAT KETERANGAN AHLI WARIS</option>
                    <option value="SURAT KETERANGAN BEPERGIAN (BORO)">SURAT KETERANGAN BEPERGIAN (BORO)</option>
                    <option value="SURAT KETERANGAN TIDAK MAMPU">SURAT KETERANGAN TIDAK MAMPU</option>
                </select>
            </div>

            <input type="hidden" name="desa_id" value="{{ $desa->id }}">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: Ahmad Setiawan" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: 357xxxxxxx" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tempat, Tanggal Lahir</label>
                <input type="text" name="tempat_tgl_lahir" value="{{ old('tempat_tgl_lahir') }}"
                    class="w-full px-4 py-2 border rounded" placeholder="Contoh: Blitar, 21 Juli 2000" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Agama</label>
                <input type="text" name="agama" value="{{ old('agama') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: Islam, Kristen, Hindu, Budha" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                    class="w-full px-4 py-2 border rounded" placeholder="Contoh: Petani, Karyawan Swasta, Pelajar" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                    class="w-full px-4 py-2 border rounded" placeholder="Contoh: 085xxxxxx" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-4 py-2 border rounded"
                    placeholder="Tulis alamat lengkap sesuai KTP" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Catatan Pemohon</label>
                <textarea name="catatan_pemohon" rows="2" class="w-full px-4 py-2 border rounded"
                    placeholder="Tambahkan catatan tambahan jika ada">{{ old('catatan_pemohon') }}</textarea>
            </div>

            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">Data Pendukung:</h4>
                <ul class="list-disc pl-5 text-sm text-gray-600 mt-2 space-y-1">
                    <li>Fotokopi KTP</li>
                    <li>Fotokopi Kartu Keluarga (KK)</li>
                    <li>Surat Pengantar dari Ketua RT</li>
                    <li>Dokumen lain-lain (jika diperlukan sesuai jenis surat)</li>
                </ul>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Lampiran (opsional)</label>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('lampiran-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Unggah Lampiran Gambar</p>
                    <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>
                    <input type="file" id="lampiran-input" accept="image/*" multiple class="hidden"
                        onchange="handleFileSelect(this)">
                </div>
                <div id="lampiran-preview" class="flex flex-row flex-wrap gap-4 mt-4"></div>
            </div>

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
        let selectedFiles = [];

        function handleFileSelect(input) {
            const newFiles = Array.from(input.files);
            selectedFiles = [...selectedFiles, ...newFiles];
            renderPreview();
            input.value = '';
        }

        function renderPreview() {
            const previewContainer = document.getElementById('lampiran-preview');
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = "w-32 h-32 object-cover rounded border border-gray-300";

                        const removeBtn = document.createElement('button');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.className = "absolute top-0 right-0 bg-red-600 text-white rounded-full px-2";
                        removeBtn.onclick = function() {
                            selectedFiles.splice(index, 1);
                            renderPreview();
                        };

                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        document.getElementById('form-pengajuan').addEventListener('submit', function(e) {
            if (selectedFiles.length > 0) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                selectedFiles.forEach(file => formData.append('images[]', file));

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                }).then(response => {
                    if (response.ok) {
                        alert('Surat berhasil diajukan!');
                        window.location.reload();
                    } else {
                        alert('Gagal mengajukan surat.');
                    }
                }).catch(() => alert('Terjadi kesalahan saat mengirim.'));
            }
        });
    </script>
@endpush
