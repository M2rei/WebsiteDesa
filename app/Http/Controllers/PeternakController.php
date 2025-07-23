<?php

namespace App\Http\Controllers;

use App\Exports\PeternakExport;
use App\Models\Peternak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PeternakController extends Controller
{
    public function index(Request $request)
    {
        $query = Peternak::with('ternaks');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $start = Carbon::parse($request->tanggal_awal);
            $end = Carbon::parse($request->tanggal_akhir);
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($request->filled('wilayah')) {
            $query->where('alamat', 'like', '%' . $request->wilayah . '%');
        }

        $limit = $request->input('limit', 10);
        $peternaks = $query->latest()->paginate($limit)->withQueryString();

        return view('Admin.DataTernak.index', compact('peternaks', 'limit'));
    }
    public function export(Request $request)
    {
        // Kirim seluruh request filter ke class export
        return Excel::download(new PeternakExport($request), 'data_peternak.xlsx');
    }

    public function create()
    {
        return view('Admin.DataTernak.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_mulai' => 'required|string',
            'tanggal_selesai' => 'required|string',
            'ternaks' => 'required|array',
            'ternaks.*.jenis_ternak' => 'required|string',
            'ternaks.*.jumlah' => 'nullable|integer|min:0',
            'ternaks.*.riwayat_penyakit' => 'nullable|string|min:0',
            'ternaks.*.vitamin' => 'nullable|string|min:0',
            'ternaks.*.keterangan' => 'nullable|string|min:0',
        ]);

        $peternak = Peternak::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        foreach ($request->ternaks as $data) {
            $jumlah_jantan = $data['jantan'] ?? 0;
            $jumlah_betina = $data['betina'] ?? 0;
            $total_jumlah = $jumlah_jantan + $jumlah_betina;

            if ($jumlah_jantan > 0) {
                $peternak->ternakPeternaks()->create([
                    'jenis_ternak' => $data['jenis_ternak'],
                    'jenis_kelamin' => 'Jantan',
                    'jumlah' => $jumlah_jantan,
                    'total_jumlah' => $total_jumlah,
                    'riwayat_penyakit' => $data['riwayat_penyakit'] ?? null,
                    'vitamin' => $data['vitamin'] ?? null,
                    'keterangan' => $data['keterangan'] ?? null,
                ]);
            }

            if ($jumlah_betina > 0) {
                $peternak->ternakPeternaks()->create([
                    'jenis_ternak' => $data['jenis_ternak'],
                    'jenis_kelamin' => 'Betina',
                    'jumlah' => $jumlah_betina,
                    'total_jumlah' => $total_jumlah,
                    'riwayat_penyakit' => $data['riwayat_penyakit'] ?? null,
                    'vitamin' => $data['vitamin'] ?? null,
                    'keterangan' => $data['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.peternak.index')->with('success', 'Data berhasil disimpan');
    }
}
