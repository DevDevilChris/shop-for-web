<?php

class CatalogueController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $products = Catalogue::getAllProducts(Session::get('sorting'));

		return View::make('catalogue.overview')->with('products', $products);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $product = Catalogue::getProduct($id);

        return View::make('catalogue.single')->with('product', $product);
	}

    public function store()
    {
        Session::set('sorting', Input::get('sorting'));

        return Redirect::to('catalogue')->withInput(Input::all());
    }

    public function add_to_cart($id, $qty) {
        $product = Catalogue::getProduct($id);

        Cart::add($product->sku, $product->name, $qty, $product->price, array('vat' => $product->vat));

        return Redirect::to('/catalogue')->with('success', Lang::get('catalogue.added_to_cart', array('product'=>$product->name)));
    }

}
