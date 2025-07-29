@extends('layout.sidebar')

@section('title', 'Data Peternak - Sistem Informasi Data Ternak Desa')
@section('page-title', 'Data Peternak')

@section('content')
    <div class="max-w-7xl mx-auto bg-white p-6 ">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 mb-6">
            <form method="GET" action="{{ route('admin.peternak.index') }}" class="flex flex-wrap gap-4 items-center">
                <select name="periode" class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Periode --</option>
                    @foreach ($periodeList as $periode)
                        <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                            {{ $periode }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun" class="px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
                <select name="wilayah" class="w-48 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach ($daftarWilayah as $wilayah)
                        <option value="{{ $wilayah }}" {{ request('wilayah') == $wilayah ? 'selected' : '' }}>
                            {{ $wilayah }}</option>
                    @endforeach
                </select>
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

            <a href="{{ route('admin.peternak.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md font-medium flex items-center transition">
                <i class="fas fa-plus mr-2"></i>
                Tambah Data Peternak
            </a>
        </div>

        <table class="w-full table-auto border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border">No</th>
                    <th class="border px-2 py-1">Nama</th>
                    <th class="border px-2 py-1">Alamat</th>
                    <th class="px-2 py-1 border">Periode</th>
                    <th class="px-2 py-1 border">Tahun</th>
                    <th class="px-2 py-1 border">Jenis Ternak</th>
                    <th class="px-2 py-1 border">Jumlah</th>
                    <th class="px-2 py-1 border">Total Ternak</th>
                    <th class="border px-2 py-1">Riwayat Penyakit</th>
                    <th class="border px-2 py-1">Keterangan</th>
                </tr>
            </thead>
            @php
                $shownTotalJenis = [];
            @endphp
            <tbody>
                @forelse ($groupedPeternaks as $index => $peternak)
                    @php
                        $groupedTernak = $peternak->ternaks->groupBy('jenis_ternak');
                        $totalTernak = $peternak->ternaks->count();
                    @endphp
                    @for ($i = 0; $i < $totalTernak; $i++)
                        <tr>
                            @if ($i === 0)
                                <td class="border px-2 py-1" rowspan="{{ $totalTernak }}">{{ $loop->iteration }}</td>
                                <td class="border px-2 py-1" rowspan="{{ $totalTernak }}">{{ $peternak->nama }}</td>
                                <td class="border px-2 py-1" rowspan="{{ $totalTernak }}">{{ $peternak->alamat }}</td>
                                <td class="border px-2 py-1" rowspan="{{ $totalTernak }}">{{ $peternak->periode }}</td>
                                <td class="border px-2 py-1" rowspan="{{ $totalTernak }}">{{ $peternak->tahun }}</td>
                            @endif

                            @php
                                $ternak = $peternak->ternaks[$i];
                            @endphp
                            <td class="border px-2 py-1">• {{ $ternak->jenis_ternak }} ({{ $ternak->jenis_kelamin }})</td>
                            <td class="border px-2 py-1">• {{ $ternak->jumlah }}</td>
                            <td class="border px-2 py-1">
                                @php
                                    $key = $ternak->peternak_id . '_' . $ternak->jenis_ternak;
                                @endphp
                                @if (!in_array($key, $shownTotalJenis))
                                    • {{ $ternak->total_jumlah }}
                                    @php
                                        $shownTotalJenis[] = $key;
                                    @endphp
                                @endif
                            </td>
                            <td class="border px-2 py-1">• {{ $ternak->riwayat_penyakit ?? '-' }}</td>
                            <td class="border px-2 py-1">• {{ $ternak->keterangan ?? '-' }}</td>
                        </tr>
                    @endfor
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $peternaks->links() }}
        </div>
    </div>

    <div id="exportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow p-6 w-full max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-4">Export Data Peternak</h2>
            <form action="{{ route('admin.peternak.export') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700">Pilih Periode</label>
                    <select name="periode" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode }}">{{ $periode }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Pilih Tahun</label>
                    <select name="tahun" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Wilayah</label>
                    <select name="wilayah" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Semua Wilayah --</option>
                        @foreach ($daftarWilayah as $wilayah)
                            <option value="{{ $wilayah }}">{{ $wilayah }}</option>
                        @endforeach
                    </select>
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
