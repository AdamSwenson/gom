<?php
namespace Database\Seeders;

use App\Item;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        factory(Item::class, 10)->create();
    }
}
