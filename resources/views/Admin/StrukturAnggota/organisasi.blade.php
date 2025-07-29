@extends('layout.sidebar')

@section('title', 'Struktur Organisasi - Sistem Informasi Desa')
@section('page-title', 'Struktur Organisasi')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-700">Tampilkan</span>
                    <select
                        class="border border-gray-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>
                    <span class="text-gray-700">baris</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Cari"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>

                <a href="{{ route('admin.struktur-organisasi.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Struktur Anggota Desa
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Gambar</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Nama</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Jabatan</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($anggotaStrukturs as $index => $anggotaStruktur)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($anggotaStruktur->foto)
                                        <img src="{{ asset('storage/' . $anggotaStruktur->foto) }}"
                                            alt="Gambar Struktur Perangkat Desa" class="w-16 h-12 object-cover rounded">
                                    @else
                                        <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $anggotaStruktur->nama }}-100 text-{{ $anggotaStruktur->nama }}-800">
                                        {{ $anggotaStruktur->nama }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $anggotaStruktur->jabatan }}-100 text-{{ $anggotaStruktur->jabatan }}-800">
                                        {{ $anggotaStruktur->jabatan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.struktur-organisasi.show', $anggotaStruktur->id) }}"
                                            class="text-gray-600 hover:text-gray-900 p-1" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.struktur-organisasi.edit', $anggotaStruktur->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="showDeleteModal({{ $anggotaStruktur->id }})"
                                            class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data Potensi Desa ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($anggotaStrukturs->hasPages())
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $anggotaStrukturs->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $anggotaStrukturs->lastItem() }}</span> dari
                    <span class="font-medium">{{ $anggotaStrukturs->total() }}</span> hasil
                </div>

                <div class="flex items-center space-x-2">
                    @if ($anggotaStrukturs->onFirstPage())
                        <button disabled
                            class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Sebelumnya
                        </button>
                    @else
                        <a href="{{ $anggotaStrukturs->previousPageUrl() }}"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Sebelumnya
                        </a>
                    @endif

                    <div class="flex items-center space-x-1">
                        @foreach ($anggotaStrukturs->getUrlRange(1, $anggotaStrukturs->lastPage()) as $page => $url)
                            @if ($page == $anggotaStrukturs->currentPage())
                                <span
                                    class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if ($anggotaStrukturs->hasMorePages())
                        <a href="{{ $anggotaStrukturs->nextPageUrl() }}"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Selanjutnya
                        </a>
                    @else
                        <button disabled
                            class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Selanjutnya
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus informasi ini?</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-6 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
            <i class="fas fa-sitemap text-blue-500"></i>
            Update Struktur Organisasi
        </h2>
        <form action="{{ route('admin.struktur-organisasi.update', $strukturOrganisasi->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center
                        bg-blue-50 hover:bg-blue-100 cursor-pointer"
                    onclick="document.getElementById('image-input').click()">
                    <div class="text-blue-500 mb-4">
                        <i class="fas fa-cloud-upload-alt text-5xl"></i>
                    </div>
                    <p class="text-gray-700 font-medium mb-2">Unggah gambar struktur</p>
                    <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>

                    <input type="file" id="image-input" name="image" accept="image/*" class="hidden"
                        onchange="previewImage(this)">
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if (!empty($strukturOrganisasi->image))
                    <div class="text-center mt-6">
                        <img src="{{ asset('storage/' . $strukturOrganisasi->image) }}" alt="Struktur Organisasi"
                            class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                        <p class="text-gray-500 text-sm mt-2">Gambar saat ini</p>
                    </div>
                @endif

                <div id="image-preview" class="text-center mt-6 hidden">
                    <img id="preview-image" src="/placeholder.svg" alt="Preview gambar"
                        class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 300px;">
                    <p class="text-gray-500 text-sm mt-2">Preview gambar baru</p>
                </div>
            </div>
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
    </div>
@endsection

@push('scripts')
    <script>
        const deleteRouteTemplate = "{{ route('admin.struktur-organisasi.destroy', ['id' => '__ID__']) }}";

        function showDeleteModal(id) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            const finalUrl = deleteRouteTemplate.replace('__ID__', id);
            deleteForm.action = finalUrl;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }

        function closeDeleteModal() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }
        document.querySelector('input[placeholder="Cari"]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.querySelector('select').addEventListener('change', function(e) {
            const value = e.target.value;
            if (value === 'all') {
                window.location.href = "{{ route('admin.struktur-organisasi.index') }}?per_page=all";
            } else {
                window.location.href = "{{ route('admin.struktur-organisasi.index') }}?per_page=" + value;
            }
        });
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
