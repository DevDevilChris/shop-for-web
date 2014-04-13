<?php

class CatalogueController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $products = Catalogue::getAllProducts(Session::get('sorting'), Session::get('category'));
        $categories = Catalogue::getCategories();

        $list = array();
        $list[0] = 'All';
        foreach($categories as $cat) {
            $list[$cat->id] = $cat->name;
        }

		return View::make('catalogue.overview')->with('products', $products)->with('list', $list);
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
        Session::set('category', Input::get('category'));

        return Redirect::to('catalogue')->withInput(Input::all());
    }

    public function add_to_cart($id, $qty) {
        $product = Catalogue::getProduct($id);

        Cart::add($product->sku, $product->name, $qty, $product->price, array('vat' => $product->vat));

        return Redirect::to('/catalogue')->with('success', Lang::get('catalogue.added_to_cart', array('product'=>$product->name)));
    }

}
