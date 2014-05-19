@extends('layout.master')

@section('after_jquery')
{{ HTML::script('js/catalogue/catalogue-product-1.0.js') }}
@stop

@section('content')

<!--{{ var_dump($product) }}-->

<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 text-center">
        {{ HTML::image("img/catalogue/product/camping_hat.jpg", "Camping Hat", array('class'=>'img-rounded')) }}
    </div>
    <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
        <h2>{{ $product->name }}</h2>
        <p>
            {{ $product->descr }}
        </p>
        <p class="lead">
            {{ Lang::get('catalogue.price_incl_vat', array('price'=>$product->price)) }}
        </p>
        <p>
            <div class="input-group col-lg-3 pull-left">
                {{ Form::text('product_qty', 1, array('class'=>'form-control', 'onblur'=>'javascript: if(this.value == "" || this.value == 0) { this.value = 1; CatalogueNX.setQty(1); } else { this.value } ;')) }}
                <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="CatalogueNX.plusQty('product_qty', 1)">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                    <button class="btn btn-danger" type="button" onclick="CatalogueNX.minusQty('product_qty', 1)">
                        <i class="glyphicon glyphicon-minus"></i>
                    </button>
                </span>
            </div>
            <div class="col-lg-9">
                @if($js_add_to_cart)
                <a href="javascript: CatalogueNX.addToCart({{$product->id}}, 1, 1);" role="button" class="btn btn-success add_to_cart">{{ Lang::get('catalogue.add_to_cart') }}</a>
                @else
                {{ HTML::link('/catalogue/add/'.$product->id.'/1/1', Lang::get('catalogue.add_to_cart'), array('class'=>'btn btn-success add_to_cart', 'role'=>'button'))  }}
                @endif
            </div>
            <input type="hidden" name="product_id" value="{{ $product->id }}" />
            <input type="hidden" name="js_add_to_cart" value="{{ $js_add_to_cart ? $js_add_to_cart : 0 }}" />
        </p>

    </div>
</div>

<script>
    CatalogueNX.setQty({{ $js_add_to_cart }});
</script>

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