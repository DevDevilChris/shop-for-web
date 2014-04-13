<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 12-04-14
 * Time: 21:49
 */

class Catalogue extends Eloquent {

    protected $table = 'product';

    public static function getAllProducts() {

        $products = DB::table('product')
            ->join('product_detail', 'product.id', '=', 'product_detail.product_id')
            ->select('*')
            ->get()
        ;

        return $products;

    }

    public static function getProduct($id) {

        $product = DB::table('product')
            ->where('product.id', '=', $id)
            ->join('product_detail', 'product.id', '=', 'product_detail.product_id')
            ->select('*')
            ->get()
        ;

        return $product[0];

    }

}