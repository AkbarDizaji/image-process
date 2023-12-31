<?php

namespace App\Services;

use App\Models\Image;
use App\Services\Interfaces\ImageServiceInterface;
use App\Services\Interfaces\SearchInterface;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
class ImageService implements ImageServiceInterface
{
    private $imageSearch;

    public function __construct(SearchInterface $imageSearch)
    {
        $this->imageSearch = $imageSearch;
    }
    public function fetchAndProcessImages($data): void
    {
        // Use an API or library to fetch images from Google based on $data['query']
        // This part is hypothetical and for illustrative purposes only
        $images = $this->imageSearch->search($data['query'], $data['max_images']);
        $manager = new ImageManager(new Driver());
        foreach ($images as $image) {
            // Process the image


//            $resizedImage = Image::make($image)->resize(300, 200);

            // Convert image to a binary stream
            $thumbnailLink = $image['image']['thumbnailLink'];
            $imageData = file_get_contents($thumbnailLink);
            $processed_image = $manager->read($imageData);

            $processed_image->scale(width: 300);
            $saved = $processed_image->toPng();
            $base64ImageData = base64_encode($saved);
            $image = new Image;
            $image->image_data = $base64ImageData;
//            dd($image->image_data);

            $image->save();
        }

    }
}
