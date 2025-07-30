<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiledesa = Desa::first();
        return view('Admin.profiledesa', compact('profiledesa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show() {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $desa = Desa::find($id);

        if (!$desa) {
            return redirect()->route('admin.profile.index')->with('error', 'Data desa tidak ditemukan');
        }

        $validated = $request->validate([
            'profile_desa' => 'required|string',
            'sejarah' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'nomor_telepon' => 'required|string',
            'email' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($desa->logo_url && Storage::disk('public')->exists($desa->logo_url)) {
                Storage::disk('public')->delete($desa->logo_url);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo_url'] = $logoPath;
        }

        $desa->update($validated);

        return redirect()->route('admin.profile.index')->with('success', 'Data desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
