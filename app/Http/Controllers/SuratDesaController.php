<?php

namespace App\Http\Controllers;

use App\Models\DataPendukung;
use App\Models\Desa;
use App\Models\SuratDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $suratdesas = $perPage === 'all'
            ? SuratDesa::latest()->get()
            : SuratDesa::latest()->paginate($perPage);

        return view('Admin.SuratDesa.suratdesa', compact('suratdesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Desa::first();
        return view('User.dokument', compact('desa'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'tempat_tgl_lahir' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'catatan_pemohon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan data surat
        $surat = SuratDesa::create([
            'jenis_surat' => $request->jenis_surat,
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'tempat_tgl_lahir' => $validated['tempat_tgl_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'agama' => $validated['agama'],
            'pekerjaan' => $validated['pekerjaan'],
            'alamat' => $validated['alamat'],
            'catatan_pemohon' => $validated['catatan_pemohon'] ?? null,
            'status' => 'diproses',
        ]);

        // Simpan gambar-gambar (jika ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('data_pendukung');

                DataPendukung::create([
                    'surat_desa_id' => $surat->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('user.surat.create')
            ->with('success', 'Surat berhasil diajukan dan gambar berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $suratdesa = SuratDesa::with('dataPendukung')->findOrFail($id);
        foreach ($suratdesa->dataPendukung as $lampiran) {
            $lampiran->private_url = route('admin.surat-desa.gambar.show', ['filename' => basename($lampiran->image)]);
        }
        return view('Admin.SuratDesa.show', compact('suratdesa'));
    }

    public function showImage($filename)
    {
        $path = storage_path('app/private/data_pendukung/' . $filename);

        $isAuthorized = DataPendukung::where('image', 'data_pendukung/' . $filename)->exists();
        if (!file_exists($path)|| !$isAuthorized) {
            abort(404);
        }

        return response()->file($path);
    }

    public function updateStatus($id)
    {
        $suratdesa = SuratDesa::findOrFail($id);

        if ($suratdesa->status === 'diproses') {
            $suratdesa->update([
                'status' => 'selesai',
            ]);
        }

        return redirect()->route('admin.surat-desa.show', $id)->with('success', 'Status berhasil diperbarui menjadi selesai.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratDesa $suratDesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratDesa $suratDesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratdesa = SuratDesa::with('dataPendukung')->findOrFail($id);

        foreach ($suratdesa->dataPendukung as $lampiran) {
            if ($lampiran->image && Storage::exists($lampiran->image)) {
                Storage::delete($lampiran->image);
            }
            $lampiran->delete();
        }
        $suratdesa->delete();
        return redirect()->route('admin.surat-desa.index')->with('success', 'Surat dan data terkait berhasil dihapus.');
    }
}
