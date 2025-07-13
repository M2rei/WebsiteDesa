<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\DataPendukung;
use App\Models\Desa;
use App\Models\DokumenDesa;
use App\Models\SuratDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $dokumenSurat = DokumenDesa::where('kategori', 'Surat')->get();
        return view('User.dokument', compact('dokumenSurat', 'desa'));
    }

    public function getFields($id)
    {
        $dokumen = DokumenDesa::findOrFail($id);

        return response()->json([
            'fields' => $dokumen->fields,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil dokumen yang dipilih user
        $dokumen = DokumenDesa::findOrFail($request->dokumen_desa_id);

        // Validasi input field dinamis
        $fieldValidations = [];
        foreach (json_decode($dokumen->fields ?? '[]') as $field) {
            $fieldValidations[$field] = 'required|string';
        }
        // Validasi utama
        $validated = $request->validate(array_merge([
            'desa_id' => 'required|exists:desa,id',
            'dokumen_desa_id' => 'required|exists:dokumen_desa,id',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ], $fieldValidations));

        // Proses Template Word
        $templatePath = storage_path('app/public/' . $dokumen->dokumen);
        $template = new TemplateProcessor($templatePath);

        foreach (json_decode($dokumen->fields) as $field) {
            $template->setValue($field, $request->input($field));
        }

        $outputName = 'document_' . time() . '.docx';
        $outputPath = storage_path('app/public/surat/' . $outputName);
        $template->saveAs($outputPath);

        $surat = SuratDesa::create([
            'desa_id' => $request->desa_id,
            'dokumen' => 'surat/' . $outputName,
            'status' => 'diproses',
        ]);

        // Simpan data pendukung (gambar)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('data_pendukung', 'public');
                DataPendukung::create([
                    'surat_desa_id' => $surat->id,
                    'image' => $path,
                ]);
            }
        }

        // Konversi ke PDF
        // $fullPdfPath = str_replace('.docx', '.pdf', $outputPath);
        // exec("libreoffice --headless --convert-to pdf --outdir " . escapeshellarg(dirname($fullPdfPath)) . " " . escapeshellarg($outputPath));

        // Update path PDF
        // $surat->update([
        //     'dokumen' => 'surat/' . basename($fullPdfPath),
        // ]);


        return redirect()->route('user.surat.create')->with('success', 'Surat berhasil diajukan dan dibuat.')->with('file_url', asset('storage/surat/' . basename($outputName)));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $suratdesa = SuratDesa::with('dataPendukung')->findOrFail($id);
        return view('Admin.SuratDesa.show', compact('suratdesa'));
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

    public function downloadPdf($id)
    {
        $suratdesa = SuratDesa::with('dataPendukung')->findOrFail($id);
        $images = $suratdesa->dataPendukung;

        $html = '<html><head><style>
                body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 0; }
                .page { page-break-after: always; padding: 20px; }
                .row { display: flex; justify-content: center; gap: 20px; }
                .img-container { width: 49%; text-align: center; }
                img { width: 100%; height: auto; max-height: 500px; object-fit: contain; border: 1px solid #ccc; }
            </style></head><body>';

        $chunks = $images->chunk(1);

        foreach ($chunks as $chunk) {
            $html .= '<div class="page"><div class="row">';
            foreach ($chunk as $lampiran) {
                $path = storage_path('app/public/' . $lampiran->image);
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $html .= '<div class="img-container"><img src="' . $base64 . '" alt="Gambar"></div>';
                }
            }
            $html .= '</div></div>';
        }

        $html .= '</body></html>';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('A4', 'portrait');

        return $pdf->download('data_pendukung_surat_' . $suratdesa->id . '.pdf');
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
        if ($suratdesa->dokumen && Storage::disk('public')->exists($suratdesa->dokumen)) {
            Storage::disk('public')->delete($suratdesa->dokumen);
        }

        foreach ($suratdesa->dataPendukung as $lampiran) {
            if ($lampiran->image && Storage::disk('public')->exists($lampiran->image)) {
                Storage::disk('public')->delete($lampiran->image);
            }
            $lampiran->delete();
        }

        $suratdesa->delete();

        return redirect()->route('admin.surat-desa.index')->with('success', 'Surat dan data terkait berhasil dihapus.');
    }
}
