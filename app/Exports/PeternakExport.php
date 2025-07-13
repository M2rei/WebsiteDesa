<?php

namespace App\Exports;

use App\Models\Peternak;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PeternakExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Peternak::with('ternaks');


        if ($this->request->filled('tanggal_awal') && $this->request->filled('tanggal_akhir')) {
            $start = Carbon::parse(str_replace('T', ' ', $this->request->tanggal_awal));
            $end = Carbon::parse(str_replace('T', ' ', $this->request->tanggal_akhir));
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($this->request->filled('wilayah')) {
            $query->where('alamat', 'like', '%' . $this->request->wilayah . '%');
        }

        $peternaks = $query->latest()->get();

        Log::info('Data peternak export', ['nama' => $peternaks->pluck('nama')->toArray()]);

        return view('Peternak.export_excel', compact('peternaks'));
    }
}
