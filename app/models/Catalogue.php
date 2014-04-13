<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 12-04-14
 * Time: 21:49
 */

class Catalogue extends Eloquent {

    protected $table = 'product';

    public static function getAllProducts($sorting = null) {

        $products = DB::table('product')
            ->join('product_detail', 'product.id', '=', 'product_detail.product_id')
            ->select('*')
        ;

        switch($sorting) {
            case 'alpha-up' :
                $products->orderBy('product.name', 'asc');
                break;
            case 'alpha-down' :
                $products->orderBy('product.name', 'desc');
                break;
            case 'price-up' :
                $products->orderBy('product_detail.price', 'asc');
                break;
            case 'price-down' :
                $products->orderBy('product_detail.price', 'desc');
                break;
        }

        $products = $products->get();

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