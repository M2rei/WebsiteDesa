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
            ? Informasi::with('lampiran')->latest()->get()
            : Informasi::with('lampiran')->latest()->paginate($perPage);

        return view('Admin.Informasi.informasi', [
            'beritas' => $beritas,
            'selectedPerPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Informasi.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $informasi = Informasi::create($validated);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $path = $file->store('lampiran', 'public');

            $informasi->lampiran()->create([
                'file_path'     => $path,
                'file_type'     => $file->extension(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }
        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $berita = Informasi::with('lampiran')->findOrFail($id);
        return view('Admin.Informasi.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Informasi::with('lampiran')->findOrFail($id);
        return view('Admin.Informasi.form-edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Informasi::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);


        $berita->update($validated);
        if ($request->hasFile('lampiran')) {
            if ($berita->lampiran) {
                Storage::disk('public')->delete($berita->lampiran->file_path);
                $berita->lampiran()->delete();
            }

            $file = $request->file('lampiran');
            $path = $file->store('lampiran', 'public');

            $berita->lampiran()->create([
                'file_path'     => $path,
                'file_type'     => $file->extension(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Informasi::findOrFail($id);
        if (Storage::disk('public')->exists($berita->lampiran->file_path)) {
            Storage::disk('public')->delete($berita->lampiran->file_path);
        }
        $berita->delete();

        return redirect()->route('admin.informasi.index')->with('success', 'Berita berhasil dihapus');
    }
}
