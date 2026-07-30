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
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        if (! in_array($sort, ['kategori', 'nama_potensi', 'created_at'], true)) {
            $sort = 'created_at';
        }

        $query = PotensiDesa::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_potensi', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sort, $direction);

        $potensidesas = $perPage === 'all'
            ? $query->get()
            : $query->paginate($perPage)->withQueryString();

        return view('Admin.PotensiDesa.potensidesa', [
            'potensidesas' => $potensidesas,
            'selectedPerPage' => $perPage,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $potensidesa = Desa::first();
        $kategoriOptions = PotensiDesa::KATEGORI_OPTIONS;
        return view('Admin.PotensiDesa.form', compact('potensidesa', 'kategoriOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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
        $kategoriOptions = PotensiDesa::KATEGORI_OPTIONS;
        return view('Admin.PotensiDesa.form-edit', compact('potensidesa', 'kategoriOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $potensidesa = PotensiDesa::findOrFail($id);
        $validated = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($potensidesa->image && Storage::disk('public')->exists($potensidesa->image)) {
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
