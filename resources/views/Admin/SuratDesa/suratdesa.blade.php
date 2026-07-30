@extends('layout.sidebar')

@section('title', 'Surat Desa - Sistem Surat Desa')
@section('page-title', 'Surat Desa')

@section('content')
    <div class="space-y-6">
        <form method="GET" action="{{ route('admin.surat-desa.index') }}"
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-700">Tampilkan</span>
                    <select name="per_page" onchange="this.form.submit()"
                        class="border border-gray-300 rounded px-3 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="5" {{ $selectedPerPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="25" {{ $selectedPerPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $selectedPerPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $selectedPerPage == 100 ? 'selected' : '' }}>100</option>
                        <option value="all" {{ $selectedPerPage == 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                    <span class="text-gray-700">baris</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>
                <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Cari
                </button>
            </div>
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'jenis_surat', 'direction' => $sort === 'jenis_surat' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Jenis Surat</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'jenis_surat' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => $sort === 'nama' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Nama</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'nama' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tempat & Tgl Lahir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Tanggal Dibuat</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'created_at' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Status</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'status' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($suratdesas as $index => $suratdesa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ (method_exists($suratdesas, 'firstItem') ? $suratdesas->firstItem() : 1) + $index }}
                                </td>
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
                                            class="text-gray-600 hover:text-gray-900 p-1" title="Lihat" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="showDeleteModal({{ $suratdesa->id }})"
                                            class="text-red-600 hover:text-red-900 p-1" title="Hapus" aria-label="Hapus">
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

    <x-confirm-modal id="deleteModal" formId="deleteForm" title="Konfirmasi Hapus"
        description="Apakah Anda yakin ingin menghapus pengajuan surat ini?" confirmLabel="Hapus" color="red" />
@endsection

@push('scripts')
    <script>
        const deleteRouteTemplate = "{{ route('admin.surat-desa.destroy', ['id' => '__ID__']) }}";

        function showDeleteModal(id) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            const finalUrl = deleteRouteTemplate.replace('__ID__', id);
            deleteForm.action = finalUrl;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }
    </script>
@endpush
