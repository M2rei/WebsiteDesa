@extends('layout.sidebar')

@section('title', 'Pengajuan Surat Desa - Sistem Surat Desa')
@section('page-title', 'Pengajuan Surat')

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
                        <option value="5">5</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">Semua</option>
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
                    <input type="text" placeholder="Cari..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tempat & Tgl Lahir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($suratdesas as $index => $suratdesa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $suratdesa->jenis_surat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $suratdesa->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $suratdesa->alamat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $suratdesa->tempat_tgl_lahir }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($suratdesa->created_at)->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = strtolower($suratdesa->status);
                                        $statusColor = match ($status) {
                                            'diproses' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                            'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                                        {{ ucfirst($suratdesa->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.surat-desa.show', $suratdesa->id) }}"
                                            class="text-gray-600 hover:text-gray-900 p-1" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="showDeleteModal({{ $suratdesa->id }})"
                                            class="text-red-600 hover:text-red-900 p-1" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($suratdesas->hasPages())
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $suratdesas->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $suratdesas->lastItem() }}</span> dari
                    <span class="font-medium">{{ $suratdesas->total() }}</span> hasil
                </div>

                <div class="flex items-center space-x-2">
                    @if ($suratdesas->onFirstPage())
                        <button disabled
                            class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Sebelumnya
                        </button>
                    @else
                        <a href="{{ $suratdesas->previousPageUrl() }}"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Sebelumnya
                        </a>
                    @endif

                    <div class="flex items-center space-x-1">
                        @foreach ($suratdesas->getUrlRange(1, $suratdesas->lastPage()) as $page => $url)
                            @if ($page == $suratdesas->currentPage())
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

                    @if ($suratdesas->hasMorePages())
                        <a href="{{ $suratdesas->nextPageUrl() }}"
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus berita ini?</p>
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
        // Delete functionality
        const deleteRouteTemplate = "{{ route('admin.surat-desa.destroy', ['id' => '__ID__']) }}";

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
        document.querySelector('input[placeholder="Cari berita..."]').addEventListener('input', function(e) {
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
                window.location.href = "{{ route('admin.surat-desa.index') }}?per_page=all";
            } else {
                window.location.href = "{{ route('admin.surat-desa.index') }}?per_page=" + value;
            }
        });
    </script>
@endpush
