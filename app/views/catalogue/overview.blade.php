@extends('layout.master')

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
        {{ Form::select(
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
                    {{ HTML::link('/catalogue/add/'.$item->id.'/1', Lang::get('catalogue.add_to_cart'), array('class'=>'btn btn-success', 'role'=>'button'))  }}
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

@stop