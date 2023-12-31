<?php

namespace App\Jobs;

use App\Services\ImageService;
use App\Services\Interfaces\ImageServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $imageService;

    public function __construct($data,  ImageServiceInterface $imageService)
    {
        $this->data = $data;
        $this->imageService = $imageService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->imageService->fetchAndProcessImages($this->data);
    }
}
