<?php

namespace Tests\Unit;

use App\Services\ImageService;
use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    /** @test */
    public function it_saves_images_to_database_after_processing()
    {
        $fakeSearchInterface = Mockery::mock(SearchInterface::class);
        $fakeSearchInterface->shouldReceive('search')
            ->once()
            ->with('cats', 10)
            ->andReturn(collect([
                ['image' => ['thumbnailLink' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png']],
                ['image' => ['thumbnailLink' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Letter_A.svg/768px-Letter_A.svg.png']],
                // ... add more items as needed
            ]));

        $imageService = new ImageService($fakeSearchInterface);

        // Assuming you want to test the side effect of saving to the database
        // You should use a database transaction or a test database for this
        DB::beginTransaction();
        try {
            $imageService->fetchAndProcessImages(['query' => 'cats', 'max_images' => 10]);

            $this->assertDatabaseCount('images', 2);
        } finally {
            DB::rollBack();
        }
    }
}
