<?php

use \Gloudemans\Shoppingcart\Facades\Cart;

class HomeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('home');
	}


}
