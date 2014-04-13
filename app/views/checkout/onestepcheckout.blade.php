@extends('layout.master')

@section('after_jquery')
{{ HTML::script('js/checkout/checkout-process-1.0.js') }}
@stop

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('checkout.already_a_member') }}</h3>
            </div>
            <div class="panel-body">

                @if(Session::get('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if(Auth::guest())

                {{ Form::open(array('url' => 'user/login', 'class' => 'user-form')) }}
                <div class="row">
                    <div class="col-md-3">
                        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.email'))) }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=> Lang::get('checkout.password'))) }}
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-block">{{ Lang::get('checkout.login') }}</button>
                    </div>
                </div>
                <div class="clr10"></div>
                <div class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-3">
                        <small>{{ HTML::link('user/forgot_password', Lang::get('checkout.forgot_password')) }}</small>
                    </div>
                </div>

                <input type="hidden" name="origin" value="{{ base64_encode('checkout') }}" />
                {{ Form::close() }}

                @else

                <p>
                    {{ Lang::get('checkout.welcome_message', array('name'=>Auth::user()->username)) }}
                </p>
                {{ HTML::link('user/logout', Lang::get('checkout.logout'), array('class'=>'btn btn-danger')) }}

                @endif

            </div>
        </div>
    </div>
</div>

<!--{{ var_dump($errors) }}-->

<!--@foreach(Cart::content() as $cartItem)-->
<!--    {{ var_dump($cartItem) }}-->
<!--@endforeach-->

{{ Form::open(array('url'=>'checkout', 'class'=>'form-horizontal')) }}
<form class="form-horizontal">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ Lang::get('checkout.your_order') }}</h3>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th width="30%">{{ Lang::get('checkout.table_head_product') }}</th>
                            <th width="10%">{{ Lang::get('checkout.table_head_price') }}</th>
                            <th width="15%">{{ Lang::get('checkout.table_head_amount') }}</th>
                            <th width="15%">{{ Lang::get('checkout.table_head_vat') }}</th>
                            <th width="15%">{{ Lang::get('checkout.table_head_discount') }}</th>
                            <th width="15%">{{ Lang::get('checkout.table_head_total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- START OF PRODUCTS -->
                        @foreach(Cart::content() as $product)

                        <tr>
                            <td>
                                <div class="media">
                                    <img class="media-object img-rounded pull-left" src="holder.js/60x60">
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $product['name'] }}</h4>
                                        <small>sku-id: {{ $product['id'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>€ {{ number_format($product['price'], 2, ',', '.') }}</td>
                            <td>
                                <div class="input-group">
                                    {{ Form::text($product['id'].'_product_qty', $product['qty'], array('class' => 'form-control')) }}

                                     <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" onclick="CheckoutNX.updateQty('{{ $product['rowid'] }}', $('input[name={{ $product['id'].'_product_qty' }}]').val())">
                                            <i class="glyphicon glyphicon-refresh"></i>
                                        </button>
                                        <button class="btn btn-danger" type="button" onclick="(confirm('Delete?')) ? CheckoutNX.removeProduct('{{ $product['rowid'] }}') : false;">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                            <td>&euro; {{ number_format($product['qty'] / 100 * 21 * $product['price'], 2, ',', '.') }}</td>
                            <td></td>
                            <td><strong>&euro; {{ number_format($product['qty'] * $product['price'], 2, ',', '.') }}</strong></td>
                        </tr>

                        @endforeach

                        <tr>
                            <td colspan="3">
                                <span class="pull-right">{{ Lang::get('checkout.total_product_price') }}</span>
                            </td>
                            <td>&euro; {{ number_format($total_vat, 2, ',', '.') }}</td>
                            <td></td>
                            <td><strong>&euro; {{ number_format($total_price_products, 2, ',', '.') }} </strong></td>
                        </tr>
                        <!-- END OF PRODUCTS -->

                        <!-- START OF SHIPPING -->
                        <tr>
                            <td colspan="3">
                                <p>{{ Lang::get('checkout.shipping_method') }}</p>
                                <select class="form-control">
                                    <option value="1">Standard</option>
                                    <option value="1">DHL service</option>
                                    <option value="1">PostNL service</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- END OF SHIPPING -->

                        <!-- START OF PAYMENT -->
                        <tr>
                            <td colspan="3">
                                <p>{{ Lang::get('checkout.payment_method') }}</p>
                                <select class="form-control">
                                    <option value="1">Creditcard (VISA, Mastercard, etc)</option>
                                    <option value="1">iDeal</option>
                                    <option value="1">Paypal</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- END OF PAYMENT -->

                        <!-- TOTAL -->
                        <tr>
                            <td colspan="3">
                                <span class="pull-right">{{ Lang::get('checkout.total') }}</span>
                            </td>
                            <td>&euro; {{ number_format($total_vat, 2, ',', '.') }}</td>
                            <td></td>
                            <td><strong class="text-success">&euro; {{ number_format($total_price_products, 2, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ Lang::get('checkout.billing_information') }}</h3>
                </div>
                <div class="panel-body">
                    @if(Auth::guest())
                    <p>
                        {{ Lang::get('checkout.create_account') }} <input type="checkbox" name="create_account" />
                    </p>
                    @endif
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_email') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_email', (Auth::user()) ? Auth::user()->email : null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_email'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_company_name') }}</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_company_name', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_company_name'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Title</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="bt_title">
                                <option>Mr.</option>
                                <option>Mrs.</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_firstname') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_firstname', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_firstname'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_insertion') }}</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_insertion', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_insertion'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_lastname') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_lastname', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_lastname'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_address_1') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_address_1', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_address_1'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_address_2') }}</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_address_2', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_address_2'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_zip') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_zip', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_zip'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_city') }} *</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_city', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_city'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_country') }} *</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="bt_country">
                                <option>Netherlands</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_phone_1') }}</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_phone_1', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_phone_1'))) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_phone_2') }}</label>
                        <div class="col-lg-8">
                            {{ Form::text('bt_phone_2', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_phone_2'))) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ Lang::get('checkout.shipping_information') }}</h3>
                </div>
                <div class="panel-body">
                    <p>
                        Shipping same as billing information <input type="checkbox" name="st_same_as_bt" id="same_as_bt" onchange="CheckoutNX.syncShippingTable()" />
                    </p>
                    <div class="sameasbt">
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_firstname') }} *</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_firstname', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_firstname'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_insertion') }}</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_insertion', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_insertion'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_lastname') }} *</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_lastname', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_lastname'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_address_1') }} *</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_address_1', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_address_1'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_address_2') }}</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_address_2', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_address_2'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_zip') }} *</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_zip', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_zip'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_city') }} *</label>
                            <div class="col-lg-8">
                                {{ Form::text('st_city', null, array('class'=>'form-control', 'placeholder' => Lang::get('checkout.form_label_city'))) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{{ Lang::get('checkout.form_label_country') }} *</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="st_country">
                                    <option value="netherlands">Netherlands</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ Lang::get('checkout.comment') }}</h3>
                </div>
                <div class="panel-body">
                    <textarea class="form-control" rows="4" cols="30" placeholder="{{ Lang::get('checkout.comment_placeholder') }}"></textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <p>
                {{ Lang::get('checkout.confirm_terms') }}
                {{ Form::checkbox('terms_of_agreement') }}
            </p>
            <button class="btn btn-success" onsubmit="CheckoutNX.termsAccepted()">{{ Lang::get('checkout.confirm_order') }}</button>
        </div>
    </div>

{{ Form::close() }}

@stop