<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // user_id 2 = Trisha (adjust if your user IDs differ after seeding)
        DB::table('customers')->insert([
            [
                'title'      => 'Ms.',
                'fullname'   => 'Trisha Mia Morales',
                'address'    => '70 Visayas Extn., Central Signal Village',
                'contact_no' => '09262027104',
                'zipcode'    => '1630',
                'town'       => 'Taguig City',
                'user_id'    => 2,
            ],
        ]);
    }
}