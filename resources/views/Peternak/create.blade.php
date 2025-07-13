<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data Peternak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10 px-6">

    {{-- Notifikasi Berhasil --}}
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

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Peternak</h1>

        <form action="{{ route('peternak.store') }}" method="POST">
            @csrf

            <!-- Nama Peternak -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-1">Nama Peternak</label>
                <input type="text" name="nama" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Alamat -->
            <div class="mb-6">
                <label class="block font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Form Ternak -->
            <div id="ternak-form-list" class="space-y-6">
                <div class="ternak-form bg-blue-50 p-4 rounded-lg border">
                    <h3 class="font-semibold text-lg mb-4">Ternak #1</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>Jenis Ternak</label>
                            <input type="text" name="ternaks[0][jenis_ternak]"
                                class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label>Bangsa</label>
                            <input type="text" name="ternaks[0][bangsa]" class="w-full px-4 py-2 border rounded-lg"
                                required>
                        </div>
                        <div>
                            <label>Jumlah Jantan</label>
                            <input type="number" name="ternaks[0][jantan]" class="w-full px-4 py-2 border rounded-lg"
                                min="0">
                        </div>
                        <div>
                            <label>Jumlah Betina</label>
                            <input type="number" name="ternaks[0][betina]" class="w-full px-4 py-2 border rounded-lg"
                                min="0">
                        </div>
                        <div>
                            <label>Jenis Pakan</label>
                            <input type="text" name="ternaks[0][jenis_pakan]"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label>Penyakit</label>
                            <input type="text" name="ternaks[0][penyakit]"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label>Sistem Pemeliharaan</label>
                            <input type="text" name="ternaks[0][sistem_pemeliharaan]"
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>
                    <button type="button" onclick="removeTernak(this)"
                        class="mt-4 text-red-500 hover:text-red-700 font-medium">Hapus Ternak</button>
                </div>
            </div>

            <!-- Tambah Ternak -->
            <button type="button" onclick="addTernak()"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold">
                + Tambah Ternak
            </button>

            <!-- Tombol Simpan -->
            <div class="mt-8">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

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
                    <div><label>Bangsa</label><input type="text" name="ternaks[${ternakIndex}][bangsa]" class="w-full px-4 py-2 border rounded-lg" required></div>
                    <div><label>Jumlah Jantan</label><input type="number" name="ternaks[${ternakIndex}][jantan]" class="w-full px-4 py-2 border rounded-lg" min="0"></div>
                    <div><label>Jumlah Betina</label><input type="number" name="ternaks[${ternakIndex}][betina]" class="w-full px-4 py-2 border rounded-lg" min="0"></div>
                    <div><label>Jenis Pakan</label><input type="text" name="ternaks[${ternakIndex}][jenis_pakan]" class="w-full px-4 py-2 border rounded-lg"></div>
                    <div><label>Penyakit</label><input type="text" name="ternaks[${ternakIndex}][penyakit]" class="w-full px-4 py-2 border rounded-lg"></div>
                    <div class="md:col-span-2"><label>Sistem Pemeliharaan</label><input type="text" name="ternaks[${ternakIndex}][sistem_pemeliharaan]" class="w-full px-4 py-2 border rounded-lg"></div>
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
</body>

</html>
