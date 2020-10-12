<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Controllers\BaseController;
class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {


        for ($i=0;$i<100;$i++) { $faker = Faker::create(); $canme = $faker->word($nb=6);

            $banner = DB::table('files')->insertGetId([
                'url' =>  $faker->imageUrl($width = 202, $height = 266),
                'alt' => $faker->word($nb=15) ,
                'file_size' => 24.5,
                'file_extension' => 'jpg',
                'file_name' => $faker->word($nb=15).'.jpg',
                'notes' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'status' => 'active'
            ]);

            $primary = DB::table('files')->insertGetId([
                'url' =>  $faker->imageUrl($width = 1920, $height = 480),
                'alt' => $faker->word($nb=15) ,
                'file_size' => 24.5,
                'file_extension' => 'jpg',
                'file_name' => $faker->word($nb=15).'.jpg',
                'notes' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'status' => 'active'
            ]);

            $product_image = DB::table('files')->insertGetId([
                'url' =>  $faker->imageUrl($width = 600, $height = 600),
                'alt' => $faker->word($nb=15) ,
                'file_size' => 24.5,
                'file_extension' => 'jpg',
                'file_name' => $faker->word($nb=15).'.jpg',
                'notes' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'status' => 'active'
            ]);

            $category = DB::table('categories')->insertGetId([
                'category_name' => $canme,
                'slug' => BaseController::slug($canme) ,
                'top_description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'bottom_description' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
                'page_title' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'browser_title' => $faker->sentence($nbWords = 12, $variableNbWords = true),
                'meta_keywords' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'meta_description' => $faker->sentence($nbWords = 160, $variableNbWords = true),
                'tagline' => $faker->sentence($nbWords =12, $variableNbWords = true),
                'banner_image' => $banner,
                'thumbnail_image' => $primary,
            ]);


            $product_cateory_attributes = DB::table('product_cateory_attributes')->insertGetId([
                'category_id' => $category,
                'attribute_name' => $faker->word($nb=6),
                'attribute_slug' => BaseController::slug($canme),
            ]);

            $product_cateory_attribute_values = DB::table('product_cateory_attribute_values')->insertGetId([
                'attribute_id' => $product_cateory_attributes,
                'value' => $faker->word($nb=6),
                'value_slug' => BaseController::slug($canme),

            ]);
            $pname = $faker->sentence($nbWords = 12);
            $mrp = $faker->numberBetween($min = 1000, $max = 50000);
            $discount = $faker->randomElement($array = array ('10','20','30'));
            $sale_price = $mrp - (($mrp*$discount)/100);
            $product = DB::table('products')->insertGetId([
                'category_id' => $category,
                'product_name' => $pname,
                'slug' => BaseController::slug($pname),
                'tagline' => $faker->sentence($nb=6),
                'summary' => $faker->sentence($nbWords=60),
                'top_description' => $faker->sentence($nbWords=120),
                'bottom_description' => $faker->sentence($nbWords=220),
                'quantity' => $faker->randomDigitNotNull(),
                'mrp' => $mrp,
                'sale_price' => $sale_price,
                'is_featured_in_home_page' => $faker->randomElement($array = array ('0','1')),
                'is_featured_in_category' => $faker->randomElement($array = array ('0','1')),
                'is_new' => $faker->randomElement($array = array ('0','1')),
                'is_top_seller' => $faker->randomElement($array = array ('0','1')),
                'is_today_deal' => $faker->randomElement($array = array ('0','1')),
                'is_active' => $faker->randomElement($array = array ('0','1')),
                'default_image_id' => $product_image,
                'page_heading' => $faker->sentence($nbWords=1),
                'browser_title' => $faker->sentence($nbWords=1),
                'meta_keywords' => $faker->sentence($nbWords=1),
                'meta_description' => $faker->sentence($nbWords=3),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $product_variant = DB::table('product_varients')->insertGetId([
                'products_id' => $product,
                'is_default' => 1,
                'sku' =>  $faker->numberBetween($min = 11111111, $max = 99999999),
                'retail_price' => $mrp,
                'sale_price' => $sale_price,
                'landing_price' => $sale_price,
                'quantity' => $faker->randomDigitNotNull(),
                'short_description' => $faker->sentence($nbWords=2),
                'created_by' => 1,
                'updated_by' => 1,
            ]);




        }
    }
}




