<?php

class CatalogueController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $model = new Catalogue;

        $products = $model->getAllProducts(Session::get('sorting'), Session::get('category'));
        $categories = $model->getCategories();

        $list = array();
        $list[0] = 'All';
        foreach($categories as $cat) {
            $list[$cat->id] = $cat->name;
        }

		return View::make('catalogue.overview')->with('products', $products)->with('list', $list)->with('js_add_to_cart', true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $model = new Catalogue;

        $product = $model->getProduct($id);

        return View::make('catalogue.single')->with('product', $product)->with('js_add_to_cart', true);
	}

    public function store()
    {
        Session::set('sorting', Input::get('sorting'));
        Session::set('category', Input::get('category'));

        return Redirect::to('catalogue')->withInput(Input::all());
    }

    public function add_to_cart($id, $qty, $return = 0) {
        $model = new Catalogue;

        $product = $model->getProduct($id);

        Cart::add($product->sku, $product->name, $qty, $product->price, array('vat' => $product->vat));

        if($return == "1") {
            $response = array(
                'status' => 'success'
            );

            return Response::json( $response );
        }

        return Redirect::to('/catalogue')->with('success', Lang::get('catalogue.added_to_cart', array('product'=>$product->name)));
    }

    public function get_cart() {
        $update = array();
        $total = 0;

        $k = 0;
        foreach(Cart::content() as $i => $item) {
            foreach($item as $j => $field) {
                if($j == "options") {
                    foreach($field as $o => $option) {
                        $update[$k][$j][$o] = $option;
                    }
                } else {
                    $update[$k][$j] = $field;
                }
            }
            $total += $item['subtotal'];
            $k++;
        }

        $data = array(
            "cart" => $update,
            "total" => $total,
            "count" => Cart::count()
        );

        return Response::json( $data );
    }
}
