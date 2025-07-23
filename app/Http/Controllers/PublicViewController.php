<?php

namespace App\Http\Controllers;

use App\Models\AnggotaStruktur;
use App\Models\DokumenDesa;
use App\Models\Informasi;
use App\Models\PotensiDesa;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class PublicViewController extends Controller
{
    public function index()
    {
        $anggotaStruktur = AnggotaStruktur::all();
        return view('User.dashboard', compact('anggotaStruktur'));
    }
    public function indexProfileDesa()
    {
        return view('user.profiledesa');
    }
    public function indexInformasi(Request $request)
    {
        $kategoriFilter = $request->query('kategori');
        $search = $request->query('search');
        $daftarKategori = Informasi::select('kategori')->distinct()->pluck('kategori');

        $query = Informasi::with('lampiran')->latest();

        if ($kategoriFilter) {
            $query->where('kategori', $kategoriFilter);
        }

        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        $informasi = $query->paginate(6);
        $informasi->appends($request->query());

        $informasiTerbaru = Informasi::with('lampiran')->latest()->take(6)->get();

        return view('user.informasi', compact(
            'informasi',
            'informasiTerbaru',
            'kategoriFilter',
            'daftarKategori'
        ));
    }

    public function show_informasi($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('User.Informasi.show', compact('informasi'));
    }
    public function indexPotensiDesa(Request $request)
    {
        $kategoriFilter = $request->query('kategori');
        $search = $request->query('search');

        $semuaKategori = PotensiDesa::select('kategori')->distinct()->pluck('kategori');

        $query = PotensiDesa::query();

        if ($kategoriFilter) {
            $query->where('kategori', $kategoriFilter);
        }

        if ($search) {
            $query->where('nama_potensi', 'like', '%' . $search . '%');
        }

        $potensi = $query->latest()->paginate(6)->appends($request->query());

        return view('user.potensidesa', compact('potensi', 'semuaKategori', 'kategoriFilter', 'search'));
    }
    public function show_potensidesa($id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        return view('User.PotensiDesa.show', compact('potensidesa'));
    }
    public function indexStrukturOrganisasi()
    {
        $strukturOrganisasi = StrukturOrganisasi::first();
        $anggotaStruktur = AnggotaStruktur::all();
        return view('user.organisasi', compact('strukturOrganisasi', 'anggotaStruktur'));
    }
}
