<?php

namespace App\Http\Controllers;

use App\Models\DokumenDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $dokumendesas = $perPage === 'all'
            ? DokumenDesa::latest()->get()
            : DokumenDesa::latest()->paginate($perPage);

        return view('Admin.Dokument.dokumen', compact('dokumendesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Dokument.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'nama_document' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'fields' => $request->kategori === 'Surat' ? 'required|array' : 'nullable|array',
            'dokumen' => 'required|mimes:docx,pdf|max:2048',
        ]);

        if ($request->kategori === 'Surat') {
            $validated['fields'] = json_encode($validated['fields']);
        } else {
            $validated['fields'] = json_encode([]);
        }

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('document', 'public');
        }


        DokumenDesa::create($validated);

        return redirect()->route('admin.dokumen-desa.index')->with('success', 'Dokumen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumendesa = DokumenDesa::findOrFail($id);
        return view('Admin.Dokument.show', compact('dokumendesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dokumendesa = DokumenDesa::findOrFail($id);
        return view('Admin.Dokument.form-edit', compact('dokumendesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dokumendesa = DokumenDesa::findOrFail($id);

        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'nama_document' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'fields' => $request->kategori === 'Surat' ? 'required|array' : 'nullable|array',
            'dokumen' => 'nullable|mimes:docx,pdf|max:2048',
        ]);

        if ($request->kategori === 'Surat') {
            $validated['fields'] = json_encode($validated['fields']);
        } else {
            $validated['fields'] = json_encode([]);
        }

        if ($request->hasFile('dokumen')) {
            if ($dokumendesa->dokumen) {
                Storage::disk('public')->delete($dokumendesa->dokumen);
            }

            $validated['dokumen'] = $request->file('dokumen')->store('document', 'public');
        }

        $dokumendesa->update($validated);

        return redirect()->route('admin.dokumen-desa.index')->with('success', 'Dokumen berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dokumendesa = DokumenDesa::findOrFail($id);
        if ($dokumendesa->dokumen) {
            Storage::disk('public')->delete($dokumendesa->dokumen);
        }

        $dokumendesa->delete();

        return redirect()->route('admin.dokumen-desa.index')->with('success', 'Dokumen berhasil dihapus');
    }
}
