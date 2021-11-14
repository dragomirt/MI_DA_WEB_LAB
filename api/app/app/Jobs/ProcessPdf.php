<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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


    }
}
