@extends('layout.master')

@section('after_jquery')
{{ HTML::script('js/checkout/checkout-process-1.0.js') }}
@stop

@section('content')

{{ var_dump(Cart::total()) }}

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
                            <th width="30%">{{ Lang::get('checkout.table_head_amount') }}</th>
                            <th width="10%">{{ Lang::get('checkout.table_head_price') }}</th>
                            <th width="10%">{{ Lang::get('checkout.table_head_discount') }}</th>
                            <th width="10%">{{ Lang::get('checkout.table_head_total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- START OF PRODUCTS -->
                        @foreach(Cart::content() as $product)

                        <tr cart-item-id="{{ $product['rowid'] }}">
                            <td>
                                <div class="media">
                                    <img class="media-object img-rounded pull-left" data-src="holder.js/60x60">
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $product['name'] }}</h4>
                                        <small>sku-id: {{ $product['id'] }}</small>
                                    </div>
                                </div>
                            </td>
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
                            <td>&euro; <span class="product_price">{{ number_format($product['price'], 2, ',', '.') }}</span></td>
                            <td></td>
                            <td><strong>&euro; <span class="product_sub_price">{{ number_format($product['qty'] * $product['price'], 2, ',', '.') }}</span></strong></td>
                        </tr>

                        @endforeach

                        <!-- END OF PRODUCTS -->

                        <!-- START OF SHIPPING -->
                        <tr>
                            <td colspan="5">
                                <p>{{ Lang::get('checkout.shipping_method') }}</p>
                                <p>
                                    <input type="radio" name="send_method" /> <label>Standard</label>
                                    <small>Description</small>
                                </p>
                                <p>
                                    <input type="radio" name="send_method" /> <label>DHL service</label>
                                    <small>Description</small>
                                </p>
                                <p>
                                    <input type="radio" name="send_method" /> <label>PostNL service</label>
                                    <small>Description</small>
                                </p>
                            </td>
                        </tr>
                        <!-- END OF SHIPPING -->

                        <!-- START OF PAYMENT -->
                        <tr>
                            <td colspan="5">
                                <p>{{ Lang::get('checkout.payment_method') }}</p>
                                <p>
                                    <input type="radio" name="payment_method" /> <label>Creditcard (VISA, Mastercard, etc)</label>
                                    <small>Description</small>
                                </p>
                                <p>
                                    <input type="radio" name="payment_method" /> <label>iDeal</label>
                                    <small>Description</small>
                                </p>
                                <p>
                                    <input type="radio" name="payment_method" /> <label>Paypal</label>
                                    <small>Description</small>
                                </p>
                            </td>
                        </tr>
                        <!-- END OF PAYMENT -->

                        <!-- TOTAL -->
                        <tr>
                            <td colspan="2">
                                <span class="pull-right">{{ Lang::get('checkout.total_product_price') }}</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>&euro; <span class="product_total_sub">{{ number_format($total_price_products, 2, ',', '.') }}</span> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="pull-right">{{ Lang::get('checkout.total_product_vat') }}</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>&euro; <span class="product_total_vat">{{ number_format( ($total_price_products * 1.21) - $total_price_products , 2, ',', '.') }}</span> </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="pull-right">{{ Lang::get('checkout.total') }}</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td><strong class="text-success">&euro; <span class="product_total">{{ number_format(($total_price_products * 1.21), 2, ',', '.') }}</span></strong></td>
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
                        Shipping same as billing information <input type="checkbox" checked="checked" name="st_same_as_bt" id="same_as_bt" />
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

<script type="text/javascript">
    $(function() {
        function sameAsBT() {
            var checked = $('input[name=st_same_as_bt]').is(':checked');
            $('div.sameasbt').css('display', (checked) ? 'none' : 'block');
        }

        sameAsBT();
        $('input[name=st_same_as_bt]').on('change', function(e) {
            sameAsBT();
        });
    });
</script>

@stop