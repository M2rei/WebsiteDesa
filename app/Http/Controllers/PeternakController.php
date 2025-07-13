<?php

namespace App\Http\Controllers;

use App\Exports\PeternakExport;
use App\Models\Peternak;
use App\Models\Ternak;
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

        return view('peternak.index', compact('peternaks', 'limit'));
    }
    public function export(Request $request)
    {
        // Kirim seluruh request filter ke class export
        return Excel::download(new PeternakExport($request), 'data_peternak.xlsx');
    }

    public function create()
    {
        return view('Peternak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'ternaks' => 'required|array',
            'ternaks.*.jenis_ternak' => 'required|string',
            'ternaks.*.bangsa' => 'required|string',
            'ternaks.*.jantan' => 'nullable|integer|min:0',
            'ternaks.*.betina' => 'nullable|integer|min:0',
        ]);

        $peternak = Peternak::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        foreach ($request->ternaks as $data) {
            $ternak = Ternak::firstOrCreate([
                'jenis_ternak' => $data['jenis_ternak'],
                'bangsa' => $data['bangsa'],
            ]);

            if (!empty($data['jantan']) && $data['jantan'] > 0) {
                $peternak->ternaks()->attach($ternak->id, [
                    'jenis_kelamin' => 'Jantan',
                    'jumlah' => $data['jantan'],
                    'jenis_pakan' => $data['jenis_pakan'] ?? null,
                    'penyakit' => $data['penyakit'] ?? null,
                    'sistem_pemeliharaan' => $data['sistem_pemeliharaan'] ?? null,
                ]);
            }

            // Simpan data betina jika diisi
            if (!empty($data['betina']) && $data['betina'] > 0) {
                $peternak->ternaks()->attach($ternak->id, [
                    'jenis_kelamin' => 'Betina',
                    'jumlah' => $data['betina'],
                    'jenis_pakan' => $data['jenis_pakan'] ?? null,
                    'penyakit' => $data['penyakit'] ?? null,
                    'sistem_pemeliharaan' => $data['sistem_pemeliharaan'] ?? null,
                ]);
            }
        }

        return redirect()->route('peternak.create')->with('success', 'Data berhasil disimpan');
    }
}
