<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strukturOrganisasi = StrukturOrganisasi::first();
        return view('Admin.organisasi', compact('strukturOrganisasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('Public.oraganisasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(StrukturOrganisasi $strukturOrganisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        //
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
            // simpan ke storage/app/public/images
            $path = $request->file('image')->store('images', 'public');
            $struktur->image = $path;
        }

        $struktur->save();

        return redirect()->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur Organisasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        //
    }
}
