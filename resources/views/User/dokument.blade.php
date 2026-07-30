@extends('layout.Navbar')

@section('title', 'Ajukan Surat Desa')
@section('meta_description', 'Ajukan surat keterangan desa secara online di Desa Ngrejo, Kabupaten Blitar — domisili, usaha, kematian, kelahiran, dan jenis surat lainnya tanpa perlu antre ke kantor desa.')

@section('content')
    <x-hero-banner title="Ajukan Surat Desa" image="image/background/2.JPG" />

    <div class="container mx-auto mt-10 px-4">

        <form id="form-pengajuan" action="{{ route('user.surat.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 md:p-8 rounded shadow max-w-4xl mx-auto">
            @csrf

            <p class="text-sm text-gray-500 mb-6">
                Field bertanda <span class="text-red-500">*</span> wajib diisi.
            </p>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Ada data yang perlu diperbaiki:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <input type="hidden" name="desa_id" value="{{ $desa->id }}">

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Data Surat</h3>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Jenis Surat yang Diajukan <span
                            class="text-red-500">*</span></label>
                    <select name="jenis_surat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                        required>
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
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-2 pb-2 border-b">Data Pribadi</h3>
                <p class="text-sm text-gray-500 mb-4">
                    <i class="fas fa-info-circle text-primary-500 mr-1"></i>
                    NIK akan diverifikasi langsung dari fotokopi KTP/KK yang Anda bawa saat datang ke Kantor Desa.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            placeholder="Contoh: Ahmad Setiawan" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tempat, Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="tempat_tgl_lahir" value="{{ old('tempat_tgl_lahir') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            placeholder="Contoh: Blitar, 21 Juli 2000" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin <span
                                class="text-red-500">*</span></label>
                        <select name="jenis_kelamin"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Agama <span
                                class="text-red-500">*</span></label>
                        <select name="agama"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Pekerjaan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            placeholder="Contoh: Petani, Karyawan Swasta, Pelajar" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">No Telepon <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                            placeholder="Contoh: 085xxxxxx" required>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">Alamat <span
                            class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                        placeholder="Tulis alamat lengkap sesuai KTP" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">Catatan Pemohon</label>
                    <textarea name="catatan_pemohon" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                        placeholder="Tambahkan catatan tambahan jika ada">{{ old('catatan_pemohon') }}</textarea>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Dokumen Pendukung</h3>

                <div class="mb-4 flex items-start gap-3 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg p-4">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mt-0.5"></i>
                    <p class="text-sm leading-relaxed">
                        Dokumen pendukung (KTP, KK, dan data pribadi lainnya) diserahkan langsung dengan datang ke
                        Kantor Desa, bukan melalui form pengajuan online ini. Mohon tidak mengirimkan salinan dokumen
                        tersebut kepada pihak atau instansi lain di luar layanan resmi desa.
                    </p>
                </div>

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
