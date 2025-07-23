@extends('layout.sidebar')

@section('title', 'Informasi - Sistem Informasi Desa')

@section('page-title', 'Informasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <!-- Show entries dropdown -->
                <div class="flex items-center space-x-2">
                    <span class="text-gray-700">Tampilkan</span>
                    <select
                        class="border border-gray-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ $selectedPerPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $selectedPerPage == 10 ? 'selected' : '' }}>25</option>
                        <option value="25" {{ $selectedPerPage == 25 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $selectedPerPage == 100 ? 'selected' : '' }}>100</option>
                        <option value="all" {{ $selectedPerPage == 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                    <span class="text-gray-700">baris</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Cari"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>

                <!-- Add Data Button -->
                <a href="{{ route('admin.potensi-desa.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Potensi Desa
                </a>
            </div>
        </div>

        <!-- Data Table -->
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
                                    <span>Kategori</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Nama Potensi</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Deskripsi</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Tanggal</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($potensidesas as $index => $potensidesa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($potensidesa->image)
                                        <img src="{{ asset('storage/' . $potensidesa->image) }}" alt="Gambar Potensi Desa"
                                            class="w-16 h-12 object-cover rounded">
                                    @else
                                        <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $potensidesa->kategori }}-100 text-{{ $potensidesa->kategori }}-800">
                                        {{ $potensidesa->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $potensidesa->kategori }}-100 text-{{ $potensidesa->kategori }}-800">
                                        {{ $potensidesa->nama_potensi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    <p class="line-clamp-2">{{ $potensidesa->deskripsi }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $potensidesa->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.potensi-desa.show', $potensidesa->id) }}"
                                            class="text-gray-600 hover:text-gray-900 p-1" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.potensi-desa.edit', $potensidesa->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="showDeleteModal({{ $potensidesa->id }})"
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

        <!-- Pagination -->
        @if ($potensidesas->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-medium">{{ $potensidesas->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $potensidesas->lastItem() }}</span> dari
                    <span class="font-medium">{{ $potensidesas->total() }}</span> data
                </div>

                <div class="flex items-center space-x-1">
                    {{-- Previous Button --}}
                    @if ($potensidesas->onFirstPage())
                        <span class="px-3 py-1 rounded border text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $potensidesas->appends(['per_page' => request('per_page')])->previousPageUrl() }}"
                            class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($potensidesas->getUrlRange(1, $potensidesas->lastPage()) as $page => $url)
                        @if ($page == $potensidesas->currentPage())
                            <span class="px-3 py-1 rounded bg-blue-600 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $potensidesas->appends(['per_page' => request('per_page')])->url($page) }}"
                                class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($potensidesas->hasMorePages())
                        <a href="{{ $potensidesas->appends(['per_page' => request('per_page')])->nextPageUrl() }}"
                            class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-3 py-1 rounded border text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
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
@endsection

@push('scripts')
    <script>
        function updatePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);

            // Reset ke halaman pertama ketika mengubah jumlah item per halaman
            url.searchParams.set('page', 1);

            window.location.href = url.toString();
        }
        // Delete functionality
        const deleteRouteTemplate = "{{ route('admin.potensi-desa.destroy', ['id' => '__ID__']) }}";

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

        // Search functionality
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

        // Entries per page functionality
        document.querySelector('select').addEventListener('change', function(e) {
            const value = e.target.value;
            if (value === 'all') {
                window.location.href = "{{ route('admin.potensi-desa.index') }}?per_page=all";
            } else {
                window.location.href = "{{ route('admin.potensi-desa.index') }}?per_page=" + value;
            }
        });
    </script>
@endpush
