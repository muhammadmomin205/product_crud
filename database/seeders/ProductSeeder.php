<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the products directory exists
        Storage::disk('public')->makeDirectory('products');

        $this->command->info('Creating 200 products with images...');
        $this->command->getOutput()->progressStart(200);

        // Create products in chunks to avoid memory issues
        $chunkSize = 50;
        $totalProducts = 200;

        for ($i = 0; $i < $totalProducts; $i += $chunkSize) {
            $currentChunk = min($chunkSize, $totalProducts - $i);

            for ($j = 0; $j < $currentChunk; $j++) {
                $productNumber = $i + $j + 1;

                // Download a placeholder image from picsum.photos
                $imageContent = $this->downloadImage($productNumber);
                $imagePath = null;

                if ($imageContent) {
                    $imageName = 'products/product_' . $productNumber . '_' . time() . '.jpg';
                    Storage::disk('public')->put($imageName, $imageContent);
                    $imagePath = $imageName;
                }

                Product::factory()->create([
                    'image' => $imagePath,
                ]);

                $this->command->getOutput()->progressAdvance();
            }
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('Successfully created 200 products with images!');
    }

    /**
     * Download a random image from picsum.photos
     */
    private function downloadImage(int $seed): ?string
    {
        try {
            // Use picsum.photos with seed for variety (400x400 images)
            $response = Http::timeout(30)->get("https://picsum.photos/seed/{$seed}/400/400");

            if ($response->successful()) {
                return $response->body();
            }
        } catch (\Exception $e) {
            // If download fails, continue without image
        }

        return null;
    }
}
