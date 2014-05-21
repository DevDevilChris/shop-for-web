<?php
/**
 * Created by PhpStorm.
 * User: chrissmits
 * Date: 21/05/14
 * Time: 18:01
 */

class SeedCategories extends Seeder {

    public function run()
    {
        DB::table('product_detail')->delete();
        DB::table('product')->delete();
        DB::table('product_category')->delete();

        DB::table('product_category')->insert(array(
            'name' => 'Hats',
            'image' => 'default.png',
            'published' => 1,
            'ordering' => 1
        ));
    }

} 