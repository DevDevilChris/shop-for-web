@extends('layout.master')

@section('after_jquery')
{{ HTML::script('js/catalogue/catalogue-product-1.0.js') }}
@stop

@section('content')

@if(Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ Session::get('success') }}
</div>
@endif

{{ Form::open(array('url'=>'catalogue')) }}
<div class="row">
    <div class="col-lg-2">
        {{
        Form::select(
            'sorting',
            array(
                'null' => 'No sorting',
                'alpha-up' => 'Alphabetic A - Z',
                'alpha-down' => 'Alphabetic Z - A',
                'price-up' => 'Price ascending',
                'price-down' => 'Price descending',
            ),
            Session::get('sorting'),
            array(
                'class' => 'form-control',
                'onchange' => 'submit()'
            )
        )
        }}
    </div>
    <div class="col-lg-2">
        {{
        Form::select(
            'category',
            $list,
            Session::get('category'),
            array(
                'class' => 'form-control',
                'onchange' => 'submit()'
            )
        )
        }}
    </div>
</div>
{{ Form::close() }}
<div class="clr20"></div>
<div class="row">
@foreach($products as $i => $item)

    <div class="col-lg-3">
        <div class="thumbnail">
            {{ HTML::image("img/catalogue/product/camping_hat.jpg", "Camping Hat", array('class'=>'img-rounded')) }}
            <div class="caption text-center">
                <h3>{{ HTML::link('/catalogue/'.$item->id, $item->name)  }}</h3>
                <p> {{ Lang::get('catalogue.price_incl_vat', array('price' => number_format($item->price, 2, ',', '.'))) }}</p>
                <p>
                    @if($js_add_to_cart)
                    <a href="javascript: CatalogueNX.addToCart({{$item->id}}, 1, 1);" role="button" class="btn btn-success">{{ Lang::get('catalogue.add_to_cart') }}</a>
                    @else
                    {{ HTML::link('/catalogue/add/'.$item->id.'/1/1', Lang::get('catalogue.add_to_cart'), array('class'=>'btn btn-success', 'role'=>'button'))  }}
                    @endif
                    {{ HTML::link('/catalogue/'.$item->id, Lang::get('catalogue.details'), array('class'=>'btn btn-info', 'role'=>'button'))  }}
                </p>
            </div>
        </div>
    </div>

    @if ($i % 4 == 3)
        </div>
        <div class="row">
    @endif

@endforeach
</div>

<div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="addToCartModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add_to_cart_modal">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="modal-title">Shopping cart</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{ HTML::link('catalogue', Lang::get('catalogue.continue_shopping'), array('class'=>'btn btn-info', 'role'=>'button')) }}
                </div>
                <div class="col-lg-6">
                    {{ HTML::link('checkout', Lang::get('catalogue.go_to_checkout'), array('class'=>'btn btn-success pull-right', 'role'=>'button')) }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop