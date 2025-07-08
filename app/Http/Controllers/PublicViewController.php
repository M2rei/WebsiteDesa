<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\PotensiDesa;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class PublicViewController extends Controller
{
    public function index()
    {
        return view('User.dashboard');
    }
    public function indexProfileDesa()
    {
        return view('user.profiledesa');
    }
    public function indexInformasi(Request $request)
    {
        $kategoriFilter = $request->query('kategori');
        $semuaKategori = Informasi::select('kategori')->distinct()->pluck('kategori');

        $informasi = Informasi::when($kategoriFilter, function ($query, $kategori) {
            return $query->where('kategori', $kategori);
        })->latest()->get();

        $informasiTerbaru = Informasi::latest()->take(3)->get();

        return view('user.informasi', compact('informasi', 'semuaKategori', 'kategoriFilter', 'informasiTerbaru'));
    }
    public function show_informasi($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('User.Informasi.show', compact('informasi'));
    }
    public function indexPotensiDesa(Request $request)
    {
        $kategoriFilter = $request->query('kategori');

        $query = PotensiDesa::query();
        if ($kategoriFilter) {
            $query->where('kategori', $kategoriFilter);
        }

        $potensi = $query->latest()->paginate(6);
        $semuaKategori = PotensiDesa::select('kategori')->distinct()->pluck('kategori');

        return view('user.potensidesa', compact('potensi', 'semuaKategori', 'kategoriFilter'));
    }
    public function show_potensidesa($id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        return view('User.PotensiDesa.show', compact('potensidesa'));
    }
    public function indexStrukturOrganisasi()
    {
        $strukturOrganisasi = StrukturOrganisasi::first();
        return view('user.organisasi', compact('strukturOrganisasi'));
    }
}
