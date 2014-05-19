<?php

class CheckoutController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //check if user has products in cart
        if(Cart::count() == 0)
            return 'No items found in the cart!';

        $total_vat = 0;
        $total_price_products = 0;

        foreach(Cart::content() as $cartItem) {
            $vat = ($cartItem->subtotal / 100) * 21;

            $total_vat += $vat;
            $total_price_products += $cartItem->subtotal;
        }

		return View::make('checkout.onestepcheckout.index')
                    ->with('total_vat', $total_vat)
                    ->with('total_price_products', $total_price_products);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        //create a new checkout
        $checkout = new Checkout;

        $rules = array(
            //billing table fields
            'bt_firstname'             => 'required|min:2',
            'bt_lastname'              => 'required|min:2',
            'bt_address_1'             => 'required',
            'bt_zip'                   => array('required', 'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i'),
            'bt_city'                  => 'required',
            'bt_country'               => 'required',
            'bt_email'                 => 'required',
            'bt_phone_1'               => 'min:10',
            'bt_phone_2'               => 'min:10',
            //shipping table fields
            'st_firstname'             => 'required|min:2',
            'st_lastname'              => 'required|min:2',
            'st_address_1'             => 'required',
            'st_zip'                   => array('required', 'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i'),
            'st_city'                  => 'required',
            'st_country'               => 'required',
        );

        //check if fields are valid
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::to('checkout')
                    ->withInput(Input::all())
                    ->withErrors($validator);
        }

        /**
         * TODO when customer decides to create account after checkout, create that one first
         * in order to store the billing and shipping address and the order
         **/


	}

    /**
     * @param $product_key row id of the product in the cart
     * @param $qty the new quantity for the product in the cart
     * @return mixed json response
     */
    public function update_qty($product_key, $qty) {
        Cart::update($product_key, $qty);

        $update = array();
        foreach(Cart::get($product_key) as $i => $item) {
            if($i == "options") {
                foreach($item as $o => $option) {
                    $update[$i][$o] = $option;
                }
            } else {
                $update[$i] = $item;
            }
        }

        $update['total'] = 0;
        foreach(Cart::content() as $item) {
            $update['total'] += $item['subtotal'];
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Product qty successfully updated',
            'row_id' => $product_key,
            'cart' => json_encode($update),
        );

        return Response::json( $response );
    }

    /**
     * @param $product_key row id of the product in the cart
     * @return mixed json response
     */
    public function remove_product($product_key) {
        Cart::remove($product_key);

        $update = array();
        $update['total'] = 0;
        foreach(Cart::content() as $item) {
            $update['total'] += $item['subtotal'];
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Product successfully removed',
            'row_id' => $product_key,
            'cart' => json_encode($update),
        );

        return Response::json( $response );
    }
}
