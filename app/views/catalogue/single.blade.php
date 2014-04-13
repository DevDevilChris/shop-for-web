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
                {{ Form::text('product_qty', 1, array('class'=>'form-control', 'onblur'=>'javascript: if(this.value == "") { this.value = 1; CatalogueNX.setQty(); } else { this.value } ;')) }}
                <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="CatalogueNX.plusQty('product_qty')">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                    <button class="btn btn-danger" type="button" onclick="CatalogueNX.minusQty('product_qty')">
                        <i class="glyphicon glyphicon-minus"></i>
                    </button>
                </span>
            </div>
            <div class="col-lg-9">
                {{ HTML::link('/catalogue/add/'.$product->id, Lang::get('catalogue.add_to_cart'), array('class'=>'btn btn-success add_to_cart', 'role'=>'button'))  }}
            </div>
            <input type="hidden" name="product_id" value="{{ $product->id }}" />
        </p>

    </div>
</div>

<script>
    CatalogueNX.setQty();
</script>

@stop