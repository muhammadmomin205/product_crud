<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FixProductImagesSeeder extends Seeder
{
    /**
     * Fix products that are missing images.
     */
    public function run(): void
    {
        // Get products without images
        $products = Product::where(function ($query) {
            $query->whereNull('image')->orWhere('image', '');
        })->get();

        $count = $products->count();
        $this->command->info("Found {$count} products without images. Fixing...");

        if ($count === 0) {
            return;
        }

        $this->command->getOutput()->progressStart($count);

        foreach ($products as $index => $product) {
            $seed = $product->id + 1000; // Use different seed for variety
            $imageContent = $this->downloadImage($seed);

            if ($imageContent) {
                $imageName = 'products/product_' . $product->id . '_' . time() . '.jpg';
                Storage::disk('public')->put($imageName, $imageContent);
                $product->update(['image' => $imageName]);
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('Done fixing product images!');
    }

    private function downloadImage(int $seed): ?string
    {
        try {
            $response = Http::timeout(30)->get("https://picsum.photos/seed/{$seed}/400/400");
            if ($response->successful()) {
                return $response->body();
            }
        } catch (\Exception $e) {
            // Continue without image
        }
        return null;
    }
}
