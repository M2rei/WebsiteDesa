@extends('layout.sidebar')

@section('title', 'Potensi Desa - Sistem Informasi Desa')

@section('page-title', ' Potensi Desa')

@section('content')
    <div class="space-y-6">
        <form method="GET" action="{{ route('admin.potensi-desa.index') }}"
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-700">Tampilkan</span>
                    <select name="per_page" onchange="this.form.submit()"
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
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>
                <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Cari
                </button>

                <a href="{{ route('admin.potensi-desa.create') }}"
                    class="bg-orange-700 hover:bg-orange-800 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Potensi Desa
                </a>
            </div>
        </form>

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
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'kategori', 'direction' => $sort === 'kategori' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Kategori</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'kategori' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_potensi', 'direction' => $sort === 'nama_potensi' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Nama Potensi</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'nama_potensi' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>Deskripsi</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Tanggal</span>
                                    <i
                                        class="fas fa-sort{{ $sort === 'created_at' ? ($direction === 'asc' ? '-up' : '-down') : '' }} text-gray-400"></i>
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($potensidesas as $index => $potensidesa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ (method_exists($potensidesas, 'firstItem') ? $potensidesas->firstItem() : 1) + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ \App\Helpers\ImageHelper::url($potensidesa->image) }}" alt="Gambar Potensi Desa"
                                        class="w-16 h-12 object-cover rounded">
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
                                    <p class="line-clamp-2">{!! nl2br(e($potensidesa->deskripsi)) !!}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $potensidesa->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.potensi-desa.show', $potensidesa->id) }}"
                                            class="text-gray-600 hover:text-gray-900 p-1" title="Lihat" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.potensi-desa.edit', $potensidesa->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1" title="Edit" aria-label="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="showDeleteModal({{ $potensidesa->id }})"
                                            class="text-red-600 hover:text-red-900 p-1" title="Hapus" aria-label="Hapus">
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

        @if ($potensidesas->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-medium">{{ $potensidesas->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $potensidesas->lastItem() }}</span> dari
                    <span class="font-medium">{{ $potensidesas->total() }}</span> data
                </div>

                <div class="flex items-center space-x-1">
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

    <x-confirm-modal id="deleteModal" formId="deleteForm" title="Konfirmasi Hapus"
        description="Apakah Anda yakin ingin menghapus data potensi desa ini?" confirmLabel="Hapus" color="red" />
@endsection

@push('scripts')
    <script>
        const deleteRouteTemplate = "{{ route('admin.potensi-desa.destroy', ['id' => '__ID__']) }}";

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
