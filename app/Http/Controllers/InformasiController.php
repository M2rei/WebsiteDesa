<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $beritas = $perPage === 'all'
            ? Informasi::latest()->get()
            : Informasi::latest()->paginate($perPage);

        return view('Admin.Informasi.informasi', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Desa::first();
        return view('Admin.Informasi.form', compact('desa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        Informasi::create($validated);

        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $berita = Informasi::findOrFail($id);
        return view('Admin.Informasi.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Informasi::findOrFail($id);
        return view('Admin.Informasi.form-edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Informasi::findOrFail($id);
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        $berita->update($validated);

        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Informasi::findOrFail($id);
        // Hapus gambar jika ada
        if ($berita->image) {
            Storage::disk('public')->delete($berita->image);
        }

        $berita->delete();

        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil dihapus');
    }
}
