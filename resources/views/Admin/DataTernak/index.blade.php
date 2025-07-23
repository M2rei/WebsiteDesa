@extends('layout.sidebar')

@section('title', 'Data Peternak - Sistem Informasi Data Ternak Desa')
@section('page-title', 'Data Peternak')

@section('content')
    <div class="max-w-7xl mx-auto bg-white p-6 ">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 mb-6">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.peternak.index') }}" class="flex flex-wrap gap-4 items-center">
                <input type="month" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                    class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <input type="month" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <input type="text" name="wilayah" placeholder="Wilayah" value="{{ request('wilayah') }}"
                    class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">

                <select name="limit" class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                </select>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                    Filter
                </button>

                <button type="button" onclick="openExportModal()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                    Export Excel
                </button>
            </form>

            <!-- Tombol Tambah Data -->
            <a href="{{ route('admin.peternak.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-medium flex items-center transition">
                <i class="fas fa-plus mr-2"></i>
                Tambah Data Peternak
            </a>
        </div>


        <!-- Tabel Data -->
        <table class="w-full table-auto border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">#</th>
                    <th class="border px-2 py-1">Nama</th>
                    <th class="border px-2 py-1">Alamat</th>
                    <th class="border px-2 py-1">Ternak</th>
                    <th class="border px-2 py-1">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if ($peternaks->count())
                    @foreach ($peternaks as $index => $p)
                        <tr>
                            <td class="border px-2 py-1">{{ $peternaks->firstItem() + $index }}</td>
                            <td class="border px-2 py-1">{{ $p->nama }}</td>
                            <td class="border px-2 py-1">{{ $p->alamat }}</td>
                            <td class="border px-2 py-1">
                                <ul class="list-disc pl-4">
                                    @foreach ($p->ternaks as $t)
                                        <li>{{ $t->jenis_ternak }} - {{ $t->pivot->jenis_kelamin }}
                                            ({{ $t->pivot->jumlah }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="border px-2 py-1">{{ $p->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada data ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="mt-4">
            {{ $peternaks->links() }}
        </div>
    </div>

    <!-- Modal Export -->
    <div id="exportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow p-6 w-full max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-4">Export Data Peternak</h2>
            <form action="{{ route('admin.peternak.export') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700">Bulan & Tahun Awal</label>
                    <input type="month" name="tanggal_awal" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Bulan & Tahun Akhir</label>
                    <input type="month" name="tanggal_akhir" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Wilayah</label>
                    <input type="text" name="wilayah" class="w-full border px-3 py-2 rounded"
                        placeholder="Kosongkan jika semua wilayah">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeExportModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Export</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openExportModal() {
            const modal = document.getElementById('exportModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeExportModal() {
            const modal = document.getElementById('exportModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
@endpush
