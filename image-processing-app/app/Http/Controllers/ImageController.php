<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImagesJob;
use App\Models\Image;
use App\Services\Interfaces\ImageServiceInterface;
use App\Services\Interfaces\SearchInterface;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $imageSearch;
    private $imageService;

    public function __construct(SearchInterface $imageSearch, ImageServiceInterface $imageService)
    {
        $this->imageSearch = $imageSearch;
        $this->imageService = $imageService;
    }

    public function processImages(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'query' => 'required|string',
            'max_images' => 'required|integer',
        ]);
        $images = $this->imageSearch->search($data['query'], $this->imageService);
        foreach ($images as $image) {
            // Process the image
//            $resizedImage = ImageManager::imagick()->read($image)->resize(300, 200);

//            $resizedImage = Image::make($image)->resize(300, 200);



        }

        // Dispatch the job to process images asynchronously
        ProcessImagesJob::dispatch($data, $this->imageService);

        return response()->json(['message' => 'Image processing started']);
    }
    public function getImages()
    {
        $images = Image::all();
        return response()->json($images);
    }
}
