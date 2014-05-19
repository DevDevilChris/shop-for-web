<div class="navbar-left cart cart-expandable">
    <span class="count text-center">{{ Cart::count() }}</span>
    <div class="cart-summary">
        <table class="table">
            <tbody class="cart-items">
            @foreach (Cart::content() as $item)
                <tr>
                    <td>
                        <div class="media">
                            <img class="media-object img-rounded pull-left" data-src="holder.js/60x60">
                            <div class="media-body">
                                <h4 class="media-heading">{{ $item->name }}</h4>
                                <small>sku-id: {{ $item->id }}</small>
                            </div>
                        </div>
                    </td>
                    <td>&times; {{ $item->qty }}</td>
                    <td><a href="/checkout/remove/{{ $item->rowid }}" class="btn btn-danger">&times;</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding: 8px;">
            @if (Cart::count() > 0)
            {{ HTML::link('/', 'Continue', array('class'=>'btn btn-success', 'role'=>'button')) }}
            {{ HTML::link('checkout', 'Checkout', array('class'=>'btn btn-success pull-right', 'role'=>'button')) }}
            @endif
        </div>
    </div>
</div>

{{ HTML::script('js/cart/cart-functions-1.0.js') }}