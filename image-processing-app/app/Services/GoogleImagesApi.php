<?php

namespace App\Services;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\Http;

class GoogleImagesApi implements SearchInterface
{
    public function search($query, $maxImages)
    {

        // Make a request to the Google Custom Search JSON API
        $response = Http::get('https://www.googleapis.com/customsearch/v1', [
            'key' => 'AIzaSyCBnWKqgsDhe-AQRBb8cnewqbH1Yw3HTZI',
            'cx' => '27f605cdfe2d14120',
            'q' => $query,
            'searchType' => 'image',
            'num' => $maxImages,
        ]);
        $images = collect($response->json('items'));

        return $images;
    }
}
