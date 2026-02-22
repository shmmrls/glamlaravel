<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            [1,'keratin_1.png'],[1,'keratin_2.png'],[1,'keratin_3.png'],
            [2,'argan_1.png'],[2,'argan_2.png'],[2,'argan_3.png'],
            [3,'collagen_1.png'],[3,'collagen_2.png'],[3,'collagen_3.png'],
            [4,'haircolor_1.png'],[4,'haircolor_2.png'],[4,'haircolor_3.png'],
            [5,'purple_1.png'],[5,'purple_2.png'],[5,'purple_3.png'],
            [6,'serum_1.png'],[6,'serum_2.png'],[6,'serum_3.png'],
            [7,'spa_1.png'],[7,'spa_2.png'],[7,'spa_3.png'],
            [8,'cleanser_1.png'],[8,'cleanser_2.png'],[8,'cleanser_3.png'],
            [9,'toner_1.png'],[9,'toner_2.png'],[9,'toner_3.png'],
            [10,'vitamin_1.png'],[10,'vitamin_2.png'],[10,'vitamin_3.png'],
            [11,'aloe_1.png'],[11,'aloe_2.png'],[11,'aloe_3.png'],
            [12,'mask_1.png'],[12,'mask_2.png'],[12,'mask_3.png'],
            [13,'sunscreen_1.png'],[13,'sunscreen_2.png'],[13,'sunscreen_3.png'],
            [14,'dryer_1.png'],[14,'dryer_2.png'],[14,'dryer_3.png'],
            [15,'iron_1.png'],[15,'iron_2.png'],[15,'iron_3.png'],
            [16,'curler_1.png'],[16,'curler_2.png'],[16,'curler_3.png'],
            [17,'scissors_1.png'],[17,'scissors_2.png'],[17,'scissors_3.png'],
            [18,'brush_1.png'],[18,'brush_2.png'],[18,'brush_3.png'],
            [19,'mixing_1.png'],[19,'mixing_2.png'],[19,'mixing_3.png'],
            [20,'cape_1.png'],[20,'cape_2.png'],[20,'cape_3.png'],
            [21,'nailpolish_1.png'],[21,'nailpolish_2.png'],[21,'nailpolish_3.png'],
            [22,'nailfile_1.png'],[22,'nailfile_2.png'],[22,'nailfile_3.png'],
            [23,'cuticle_2.png'],[23,'cuticle_3.png'],
            [24,'scrub_1.png'],[24,'scrub_2.png'],[24,'scrub_3.png'],
            [25,'lotion_1.png'],[25,'lotion_2.png'],[25,'lotion_3.png'],
            [26,'bodyscrub_1.png'],[26,'bodyscrub_2.png'],[26,'bodyscrub_3.png'],
        ];

        foreach ($images as $img) {
            DB::table('product_images')->insert([
                'product_id' => $img[0],
                'img_name'   => $img[1],
            ]);
        }
    }
}