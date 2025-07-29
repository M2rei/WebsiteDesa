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
        $query = Peternak::query();

        if ($this->request->filled('periode') && $this->request->filled('tahun')) {
            $query->where('periode', $this->request->periode)
                ->where('tahun', $this->request->tahun);
        }

        if ($this->request->filled('wilayah')) {
            $query->where('alamat', 'like', '%' . $this->request->wilayah . '%');
        }

        $groupedPeternaks = collect($query->get())
            ->groupBy(function ($item) {
                return $item->nama . '|' . $item->alamat . '|' . $item->periode . '|' . $item->tahun;
            })
            ->map(function ($group) {
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

        return view('Admin.DataTernak.export', [
            'groupedPeternaks' => $groupedPeternaks,
        ]);
    }
}
