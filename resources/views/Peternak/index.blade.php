<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Peternak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Data Peternak</h1>

        <!-- Filter Form -->
        <form class="flex flex-wrap gap-4 mb-4" method="GET" action="{{ route('peternak.index') }}">
            <input type="datetime-local" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                class="px-3 py-2 border rounded">
            <input type="datetime-local" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                class="px-3 py-2 border rounded">
            <input type="text" name="wilayah" placeholder="Wilayah" value="{{ request('wilayah') }}"
                class="px-3 py-2 border rounded">
            <select name="limit" class="px-3 py-2 border rounded">
                <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>

            <!-- Tombol Export Excel -->
            <button type="button" onclick="openExportModal()" class="bg-green-600 text-white px-4 py-2 rounded">Export
                Excel</button>
        </form>

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
            <form action="{{ route('peternak.export') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Awal</label>
                    <input type="datetime-local" name="tanggal_awal" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Akhir</label>
                    <input type="datetime-local" name="tanggal_akhir" class="w-full border px-3 py-2 rounded">
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
</body>

</html>
