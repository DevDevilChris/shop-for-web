@extends('layout.master')

@section('content')

@if(Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ Session::get('success') }}
</div>
@endif

<div class="row">
@foreach($products as $i => $item)

    <div class="col-lg-3">
        <div class="thumbnail">
            <img class="img-rounded" src="holder.js/255x255">
            <div class="caption text-center">
                <h3>{{ HTML::link('/catalogue/'.$item->id, $item->name)  }}</h3>
                <p class="lead">{{{ $item->descr  }}}</p>
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