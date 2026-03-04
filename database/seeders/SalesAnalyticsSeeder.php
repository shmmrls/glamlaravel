<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesAnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing products and customers
        $products = DB::table('products')->pluck('product_id', 'product_name');
        $customers = DB::table('customers')->pluck('customer_id');
        
        if ($products->isEmpty() || $customers->isEmpty()) {
            $this->command->warn('No products or customers found. Please run ProductSeeder and CustomerSeeder first.');
            return;
        }

        // Generate orders over the past 3 years with realistic patterns
        $orderCount = 0;
        $startDate = Carbon::now()->subYears(3);
        $endDate = Carbon::now();

        // Generate 800-1200 orders over 3 years
        $totalOrders = rand(800, 1200);
        
        for ($i = 0; $i < $totalOrders; $i++) {
            // Random date within the past 3 years, with more recent orders being more frequent
            $daysAgo = rand(0, $startDate->diffInDays($endDate));
            $orderDate = Carbon::now()->subDays($daysAgo);
            
            // Add some seasonality - more orders in certain months
            $month = $orderDate->month;
            $seasonMultiplier = $this->getSeasonMultiplier($month);
            
            if (rand(1, 100) > ($seasonMultiplier * 100)) {
                continue; // Skip this order to maintain seasonality
            }

            // Create order
            $orderId = DB::table('orders')->insertGetId([
                'transaction_id' => 'TXN' . str_pad($orderCount + 1, 6, '0', STR_PAD_LEFT),
                'customer_id' => $customers->random(),
                'payment_method' => ['Cash on Delivery', 'GCash', 'Credit Card'][rand(0, 2)],
                'shipping_fee' => rand(0, 150) / 10, // 0.00 to 15.00
                'payment_status' => 'Paid', // Only paid orders show in analytics
                'order_status' => 'Delivered',
                'date_shipped' => $orderDate->copy()->addDays(rand(1, 7)),
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Add 1-5 items per order
            $itemsPerOrder = rand(1, 5);
            $selectedProducts = $products->random(min($itemsPerOrder, $products->count()));

            foreach ($selectedProducts as $productName => $productId) {
                $productPrice = DB::table('products')->where('product_id', $productId)->value('price');
                $quantity = rand(1, 3);
                
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $productPrice,
                ]);
            }

            $orderCount++;
        }

        $this->command->info("Generated {$orderCount} sample orders with items for analytics testing.");
    }

    private function getSeasonMultiplier(int $month): float
    {
        // Simulate seasonal sales patterns
        // Higher sales in: December (holidays), March (summer prep), June (graduation)
        $seasons = [
            1 => 0.8,   // January - post holiday slump
            2 => 0.7,   // February - low season
            3 => 1.2,   // March - summer prep
            4 => 0.9,   // April
            5 => 0.8,   // May
            6 => 1.3,   // June - graduation season
            7 => 0.9,   // July
            8 => 0.8,   // August
            9 => 1.0,   // September
            10 => 1.1,  // October
            11 => 1.2,  // November - pre-holiday
            12 => 1.5,  // December - holiday season
        ];

        return $seasons[$month] ?? 1.0;
    }
}