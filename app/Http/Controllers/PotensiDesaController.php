<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\PotensiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotensiDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $potensidesas = $perPage === 'all'
            ? PotensiDesa::latest()->get()
            : PotensiDesa::latest()->paginate($perPage);
        return view('Admin.PotensiDesa.potensidesa', compact('potensidesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $potensidesa = Desa::first();
        return view('Admin.PotensiDesa.form', compact('potensidesa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'nama_potensi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('potensidesa', 'public');
        }

        PotensiDesa::create($validated);

        return redirect()->route('admin.potensi-desa.index')->with('success', 'Potensi Desa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        return view('Admin.PotensiDesa.show', compact('potensidesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        return view('Admin.PotensiDesa.form-edit', compact('potensidesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'nama_potensi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($id->image) {
                Storage::disk('public')->delete($potensidesa->image);
            }
            $validated['image'] = $request->file('image')->store('potensidesa', 'public');
        }

        $potensidesa->update($validated);

        return redirect()->route('admin.potensi-desa.index')->with('success', 'Potensi Desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        if ($potensidesa->image) {
            Storage::disk('public')->delete($potensidesa->image);
        }

        $potensidesa->delete();

        return redirect()->route('admin.potensi-desa.index')->with('success', 'Potensi Desa berhasil dihapus');
    }
}
