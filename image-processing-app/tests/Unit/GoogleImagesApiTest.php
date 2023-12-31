<?php

use App\Services\GoogleImagesApi;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleImagesApiTest extends TestCase
{
    /** @test */
    public function it_returns_images_for_a_given_search_query()
    {
        Http::fake([
            'https://www.googleapis.com/customsearch/*' => Http::response([
                'items' => [
                    ['link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png'],
                    ['link' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png'],
                    // ... add more items as needed
                ]
            ], 200)
        ]);

        $googleImagesApi = new GoogleImagesApi();
        $images = $googleImagesApi->search('cats', 2);

        $this->assertCount(2, $images);
        $this->assertEquals('https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png', $images[0]['link']);
        $this->assertEquals('https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png', $images[1]['link']);
    }
}
