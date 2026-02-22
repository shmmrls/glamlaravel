<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Hair Care (category_id 1)
            [1, 'Keratin Treatment Set',             'Smoothens and repairs damaged hair.',              1299.00, 'keratin_treatment.png', 0],
            [1, 'Argan Oil Shampoo',                 'Moisturizing shampoo for soft and shiny hair.',    399.00,  'argan_shampoo.png',     0],
            [1, 'Collagen Conditioner',              'Rejuvenates and strengthens hair strands.',         429.00,  'collagen_conditioner.png', 0],
            [1, 'Hair Color Cream (Various Shades)', 'Vibrant and long-lasting hair color.',             299.00,  'hair_color_cream.png',  0],
            [1, 'Purple Shampoo',                   'Neutralizes brassiness in blonde hair.',            359.00,  'purple_shampoo.png',    0],
            [1, 'Leave-In Hair Serum',               'Protects hair from heat and frizz.',               279.00,  'leave_in_serum.png',    0],
            [1, 'Hair Spa Cream',                    'Salon-grade treatment for silky smooth hair.',      499.00,  'hair_spa_cream.png',    0],
            // Skincare (category_id 2)
            [2, 'Facial Cleanser',                  'Gentle cleanser for all skin types.',               299.00,  'facial_cleanser.png',   0],
            [2, 'Hydrating Toner',                  'Restores pH balance and refreshes skin.',           259.00,  'hydrating_toner.png',   0],
            [2, 'Vitamin C Serum',                  'Brightens and reduces dark spots.',                 799.00,  'vitamin_c_serum.png',   0],
            [2, 'Aloe Vera Gel',                    'Soothes and hydrates skin naturally.',              199.00,  'aloe_vera_gel.png',     0],
            [2, 'Facial Sheet Masks (Pack of 5)',   'Instant hydration for glowing skin.',               349.00,  'sheet_masks.png',       0],
            [2, 'Sunscreen SPF 50',                 'Protects skin from harmful UV rays.',               499.00,  'sunscreen_spf50.png',   0],
            // Salon Tools (category_id 3)
            [3, 'Professional Hair Dryer',           'High-speed dryer for professional use.',          1599.00,  'hair_dryer.png',        0],
            [3, 'Flat Iron / Hair Straightener',     'Smooth and straight styling tool.',               1299.00,  'flat_iron.png',         0],
            [3, 'Hair Curling Wand',                 'Easy-to-use curling wand for waves.',             1399.00,  'curling_wand.png',      0],
            [3, 'Cutting Scissors & Thinning Shears Set', 'Durable stainless steel tools.',             899.00,  'scissors_set.png',      0],
            [3, 'Hair Brush & Comb Set',             'Complete styling brush set.',                      299.00,  'brush_comb_set.png',    0],
            [3, 'Mixing Bowl and Applicator Brush',  'Essential tools for hair coloring.',               199.00,  'mixing_bowl_brush.png', 0],
            [3, 'Salon Cape and Gloves',             'Protective wear for salon use.',                   249.00,  'salon_cape_gloves.png', 0],
            // Nail & Body Care (category_id 4)
            [4, 'Nail Polish Set (Assorted Colors)', 'Vibrant nail colors in a set.',                   499.00,  'nail_polish_set.png',   0],
            [4, 'Nail File and Buffer Set',          'Smooth and shape your nails.',                    149.00,  'nail_file_buffer.png',  0],
            [4, 'Cuticle Oil',                       'Moisturizes and softens cuticles.',               199.00,  'cuticle_oil.png',       0],
            [4, 'Hand and Foot Scrub',               'Removes dead skin and softens.',                  249.00,  'hand_foot_scrub.png',   0],
            [4, 'Body Lotion',                       'Moisturizing and soothing lotion.',               299.00,  'body_lotion.png',       0],
            [4, 'Body Scrub (Coffee or Milk Variant)', 'Exfoliating scrub for glowing skin.',           349.00,  'body_scrub_new.png',    1],
        ];

        foreach ($products as $p) {
            DB::table('products')->insert([
                'category_id'   => $p[0],
                'product_name'  => $p[1],
                'description'   => $p[2],
                'price'         => $p[3],
                'main_img_name' => $p[4],
                'is_featured'   => $p[5],
                'is_available'  => 1,
                'created_at'    => now(),
            ]);
        }
    }
}