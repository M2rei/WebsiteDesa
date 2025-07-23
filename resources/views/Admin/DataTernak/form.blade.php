@extends('layout.sidebar')

@section('title', 'Informasi - Sistem Informasi Desa')
@section('page-title', 'Informasi')

@section('content')
    @if (session('success'))
        <div id="toast-success"
            class="fixed top-6 right-6 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-md animate-fade-in-down">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('toast-success')?.remove();
            }, 4000);
        </script>
    @endif

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Peternak</h1>

        <form action="{{ route('admin.peternak.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nama Peternak</label>
                <input type="text" name="nama" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
            </div>

            <div id="ternak-form-list" class="space-y-6">
                <!-- Ternak Awal -->
                <div class="ternak-form bg-blue-50 p-4 rounded-lg border">
                    <h3 class="font-semibold text-lg mb-4">Ternak #1</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>Jenis Ternak</label>
                            <input type="text" name="ternaks[0][jenis_ternak]" class="w-full px-4 py-2 border rounded-lg"
                                required>
                        </div>
                        <div>
                            <label>Jumlah Jantan</label>
                            <input type="number" name="ternaks[0][jantan]" min="0"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label>Jumlah Betina</label>
                            <input type="number" name="ternaks[0][betina]" min="0"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label>Riwayat Penyakit</label>
                            <input type="text" name="ternaks[0][riwayat_penyakit]"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label>tgl Terakhir Vitamin</label>
                            <input type="date" name="ternaks[0][vitamin]" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label>Keterangan</label>
                            <textarea name="ternaks[0][keterangan]" class="w-full px-4 py-2 border rounded-lg"></textarea>
                        </div>
                    </div>
                    <button type="button" onclick="removeTernak(this)"
                        class="mt-4 text-red-500 hover:text-red-700 font-medium">Hapus Ternak</button>
                </div>
            </div>

            <button type="button" onclick="addTernak()"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold">
                + Tambah Ternak
            </button>

            <div class="mt-8">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let ternakIndex = 1;

        function addTernak() {
            const container = document.getElementById('ternak-form-list');
            const div = document.createElement('div');
            div.classList.add('ternak-form', 'bg-blue-50', 'p-4', 'rounded-lg', 'border', 'space-y-4');
            div.innerHTML = `
            <h3 class="font-semibold text-lg mb-4">Ternak #${ternakIndex + 1}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label>Jenis Ternak</label><input type="text" name="ternaks[${ternakIndex}][jenis_ternak]" class="w-full px-4 py-2 border rounded-lg" required></div>
                <div><label>Jumlah Jantan</label><input type="number" name="ternaks[${ternakIndex}][jantan]" class="w-full px-4 py-2 border rounded-lg" min="0"></div>
                <div><label>Jumlah Betina</label><input type="number" name="ternaks[${ternakIndex}][betina]" class="w-full px-4 py-2 border rounded-lg" min="0"></div>
                <div><label>Riwayat Penyakit</label><input type="text" name="ternaks[${ternakIndex}][riwayat_penyakit]" class="w-full px-4 py-2 border rounded-lg"></div>
                <div><label>Vitamin</label><input type="text" name="ternaks[${ternakIndex}][vitamin]" class="w-full px-4 py-2 border rounded-lg"></div>
                <div class="md:col-span-2"><label>Keterangan</label><textarea name="ternaks[${ternakIndex}][keterangan]" class="w-full px-4 py-2 border rounded-lg"></textarea></div>
            </div>
            <button type="button" onclick="removeTernak(this)" class="mt-4 text-red-500 hover:text-red-700 font-medium">Hapus Ternak</button>
        `;
            container.appendChild(div);
            ternakIndex++;
        }

        function removeTernak(button) {
            button.closest('.ternak-form').remove();
        }
    </script>
@endpush
