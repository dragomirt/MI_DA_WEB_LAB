<?php

namespace App\Jobs;

use App\Models\FileContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class ProcessPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $media_id = null;
    protected $filepath = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $media_id, string $filepath)
    {
        $this->media_id = $media_id;
        $this->filepath = $filepath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (null === $this->filepath) {
            $this->fail(new \Exception("No file available."));
        }

        if (null === $this->media_id) {
            $this->fail(new \Exception("No media found."));
        }

        $content = null;
        try {
            $content = (new Pdf())
                ->setPdf($this->filepath)
                ->setOptions(['layout', 'r 96'])
                ->addOptions(['f 1'])
                ->setScanOptions(['-l ron+rus+eng', '--skip-text'])
                ->scan()
                ->decrypt()
                ->text();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
        }

        $file_content = new FileContent();
        $file_content->media_id = $this->media_id;
        $file_content->content = $content;
        $file_content->save();
    }
}
