<?php

namespace App\Http\Controllers;

use App\Models\AnggotaStruktur;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $strukturOrganisasi = StrukturOrganisasi::first();
        $perPage = $request->input('per_page', 5);
        $anggotaStrukturs = $perPage === 'all'
            ? AnggotaStruktur::latest()->get()
            : AnggotaStruktur::latest()->paginate($perPage);
        return view('Admin.StrukturAnggota.organisasi', compact('strukturOrganisasi', 'anggotaStrukturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.StrukturAnggota.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('struktur_anggota', 'public');
        }

        AnggotaStruktur::create($validated);
        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anggotaStruktur = AnggotaStruktur::findOrFail($id);
        return view('Admin.StrukturAnggota.show', compact('anggotaStruktur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $anggotaStruktur = AnggotaStruktur::findOrFail($id);
        return view('Admin.StrukturAnggota.form-edit', compact('anggotaStruktur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $struktur = StrukturOrganisasi::find($id);
        if (!$struktur) {
            return redirect()->route('admin.struktur-organisasi.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $struktur->image = $path;
        }

        $struktur->save();

        return redirect()->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur Organisasi berhasil diperbarui');
    }

    public function updateStrukturOrganisasi(Request $request, $id)
    {
        $anggotaStruktur = AnggotaStruktur::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

    if ($request->hasFile('foto')) {
        if ($anggotaStruktur->foto && Storage::disk('public')->exists($anggotaStruktur->foto)) {
            Storage::disk('public')->delete($anggotaStruktur->foto);
        }

        $validated['foto'] = $request->file('foto')->store('struktur_anggota', 'public');
    }

        $anggotaStruktur->update($validated);
        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Anggota berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggotaStruktur = AnggotaStruktur::findOrFail($id);
        if ($anggotaStruktur->foto) {
            Storage::disk('public')->delete($anggotaStruktur->foto);
        }

        $anggotaStruktur->delete();

        return redirect()->route('admin.struktur-organisasi.index')->with('success', 'Struktur Anggota berhasil dihapus');
    }
}
