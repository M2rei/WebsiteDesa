<?php

namespace App\Jobs;

use App\Models\SuratDesa;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class DeleteSuratDesa implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $suratId;

    /**
     * Create a new job instance.
     */
    public function __construct($suratId)
    {
        $this->suratId = $suratId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $suratdesa = SuratDesa::with('dataPendukung')->find($this->suratId);

        if ($suratdesa && $suratdesa->status === 'selesai') {
            foreach ($suratdesa->dataPendukung as $lampiran) {
                if ($lampiran->image && Storage::exists($lampiran->image)) {
                    Storage::delete($lampiran->image);
                }
                $lampiran->delete();
            }

            $suratdesa->delete();
        }
    }
}
