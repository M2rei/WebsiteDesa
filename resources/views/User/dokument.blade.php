@extends('layout.Navbar')

@section('title', 'Ajukan Surat Desa')

@section('content')
    <section class="bg-primary-800 text-white py-16">
        <div class="container mx-auto text-center mt-6">
            <h1 class="text-4xl font-bold">Ajukan Surat Desa</h1>
        </div>
    </section>

    <div class="container mx-auto mt-10 px-4">

        <form action="{{ route('user.surat.store') }}" method="POST" enctype="multipart/form-data"
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
            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: Ahmad Setiawan" required>
            </div>

            <!-- NIK -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: 357xxxxxxx" required>
            </div>

            <!-- Tempat, Tanggal Lahir -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tempat, Tanggal Lahir</label>
                <input type="text" name="tempat_tgl_lahir" value="{{ old('tempat_tgl_lahir') }}"
                    class="w-full px-4 py-2 border rounded" placeholder="Contoh: Blitar, 21 Juli 2000" required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Agama -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Agama</label>
                <input type="text" name="agama" value="{{ old('agama') }}" class="w-full px-4 py-2 border rounded"
                    placeholder="Contoh: Islam, Kristen, Hindu, Budha" required>
            </div>

            <!-- Pekerjaan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                    class="w-full px-4 py-2 border rounded" placeholder="Contoh: Petani, Karyawan Swasta, Pelajar" required>
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-4 py-2 border rounded"
                    placeholder="Tulis alamat lengkap sesuai KTP" required>{{ old('alamat') }}</textarea>
            </div>

            <!-- Catatan Pemohon -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Catatan Pemohon</label>
                <textarea name="catatan_pemohon" rows="2" class="w-full px-4 py-2 border rounded"
                    placeholder="Tambahkan catatan tambahan jika ada">{{ old('catatan_pemohon') }}</textarea>
            </div>

            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">Data Pendukung:</h4>
                <p class="text-sm text-gray-600">
                    Silakan siapkan dan unggah dokumen sesuai ketentuan berikut:
                </p>
                <ul class="list-disc pl-5 text-sm text-gray-600 mt-2 space-y-1">
                    <li>Fotokopi KTP</li>
                    <li>Fotokopi Kartu Keluarga (KK)</li>
                    <li>Surat Pengantar dari Ketua RT</li>
                    <li>Dokumen lain-lain (jika diperlukan sesuai jenis surat)</li>
                </ul>
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
                <div id="lampiran-preview" class="flex flex-row flex-wrap gap-4 mt-4"></div>
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
        function previewLampiran(input) {
            const previewContainer = document.getElementById('lampiran-preview');
            previewContainer.innerHTML = ""; // Bersihkan preview lama

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = "w-32 h-32 object-cover rounded border border-gray-300";
                            previewContainer.appendChild(img);
                        }

                        reader.readAsDataURL(file);
                    }
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

@push('scripts')
    <script>
        // Smooth scrolling animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            // Add initial styles for animation
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(50px)';
                section.style.transition =
                    `opacity 0.8s ease ${index * 0.1}s, transform 0.8s ease ${index * 0.1}s`;
                observer.observe(section);
            });

            // Add parallax effect to hero section
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('section');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Add counter animation for statistics
            const counters = document.querySelectorAll('h3');
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                    if (target && !counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        let current = 0;
                        const increment = target / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                counter.textContent = counter.textContent.replace(/[\d,]+/,
                                    target.toLocaleString());
                                clearInterval(timer);
                            } else {
                                counter.textContent = counter.textContent.replace(/[\d,]+/, Math
                                    .floor(current).toLocaleString());
                            }
                        }, 30);
                    }
                });
            };

            // Trigger counter animation when statistics section is visible
            const statsSection = document.querySelector('.bg-primary-800');
            if (statsSection) {
                const statsObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                        }
                    });
                }, {
                    threshold: 0.5
                });

                statsObserver.observe(statsSection);
            }
        });
    </script>
@endpush
