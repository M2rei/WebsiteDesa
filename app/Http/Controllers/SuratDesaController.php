<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteSuratDesa;
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
        $search = $request->input('search');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        if (! in_array($sort, ['jenis_surat', 'nama', 'status', 'created_at'], true)) {
            $sort = 'created_at';
        }

        $query = SuratDesa::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jenis_surat', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sort, $direction);

        $suratdesas = $perPage === 'all'
            ? $query->get()
            : $query->paginate($perPage)->withQueryString();

        return view('Admin.SuratDesa.suratdesa', [
            'suratdesas' => $suratdesas,
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
            'nik' => 'nullable|string|max:255',
            'tempat_tgl_lahir' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'pekerjaan' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'catatan_pemohon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $surat = SuratDesa::create([
            ...$validated,
            'status' => 'diproses',
        ]);

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
    public function show(int $id)
    {
        $suratdesa = SuratDesa::with('dataPendukung')->findOrFail($id);
        foreach ($suratdesa->dataPendukung as $lampiran) {
            $lampiran->private_url = route('admin.surat-desa.gambar.show', ['filename' => basename($lampiran->image)]);
        }
        return view('Admin.SuratDesa.show', compact('suratdesa'));
    }

    public function showImage(string $filename)
    {
        $isAuthorized = DataPendukung::where('image', 'data_pendukung/' . $filename)->exists();
        if (!$isAuthorized) {
            abort(404);
        }

        $path = storage_path('app/private/data_pendukung/' . $filename);
        if (!file_exists($path)) {
            return response()->file(public_path('images/placeholder.png'));
        }

        return response()->file($path);
    }

    public function updateStatus(int $id)
    {
        $suratdesa = SuratDesa::findOrFail($id);

        if ($suratdesa->status === 'diproses') {
            $suratdesa->update(['status' => 'selesai']);

            DeleteSuratDesa::dispatchSync($id);
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
    public function destroy(int $id)
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
