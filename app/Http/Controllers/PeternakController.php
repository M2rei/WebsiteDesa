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

        if ($request->filled('periode') && $request->filled('tahun')) {
            $query->where('periode', $request->periode)
                ->where('tahun', $request->tahun);
        }

        if ($request->filled('wilayah')) {
            $query->where('alamat', 'like', '%' . $request->wilayah . '%');
        }

        $limit = $request->input('limit', 10);
        $peternaksPaginated = $query->latest()->paginate($limit)->withQueryString();

        $groupedPeternaks = collect($peternaksPaginated->items())
            ->groupBy(function ($item) {
                return $item->nama . '|' . $item->alamat . '|' . $item->periode . '|' . $item->tahun;
            })->map(function ($group) {
                $first = $group->first();
                $allTernaks = $group->flatMap->ternaks;

                return (object)[
                    'nama' => $first->nama,
                    'alamat' => $first->alamat,
                    'periode' => $first->periode,
                    'tahun' => $first->tahun,
                    'ternaks' => $allTernaks,
                ];
            });

        $periodeList = Peternak::select('periode')->distinct()->pluck('periode');
        $daftarWilayah = Peternak::select('alamat')->distinct()->pluck('alamat');
        $tahunList = Peternak::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('Admin.DataTernak.index', [
            'groupedPeternaks' => $groupedPeternaks,
            'peternaks' => $peternaksPaginated,
            'limit' => $limit,
            'periodeList' => $periodeList,
            'daftarWilayah' => $daftarWilayah,
            'tahunList' => $tahunList,
        ]);
    }
    public function export(Request $request)
    {
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
            'periode' => 'required|string',
            'tahun' => 'required|string',
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
            'periode' => $request->periode,
            'tahun' => $request->tahun,
        ]);

        foreach ($request->ternaks as $data) {
            $jumlah_jantan = $data['jantan'] ?? 0;
            $jumlah_betina = $data['betina'] ?? 0;
            $total_jumlah = $jumlah_jantan + $jumlah_betina;

            if ($jumlah_jantan > 0) {
                $peternak->ternaks()->create([
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
                $peternak->ternaks()->create([
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
