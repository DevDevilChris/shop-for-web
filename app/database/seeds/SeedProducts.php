<?php
/**
 * Created by PhpStorm.
 * User: chrissmits
 * Date: 21/05/14
 * Time: 18:08
 */

class SeedProducts extends Seeder {
    public function run()
    {
        DB::table('product_detail')->delete();
        DB::table('product')->delete();

        $cat = DB::table('product_category')->select('id')->take(1)->get();
        $id = DB::table('product')->insertGetId(array(
            'category_id' => $cat[0]->id,
            'sku' => 'P001',
            'name' => 'Fishing Hat',
            'description' => 'Dit is een Hat uit de jaren 60'
        ));

        DB::table('product_detail')->insertGetId(array(
            'product_id' => $id,
            'vat' => 21,
            'delivery_time' => 3,
            'price' => 15.5
        ));
    }
} 