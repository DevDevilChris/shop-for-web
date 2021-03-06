<!doctype html>
<html>
<head>
    @yield('before_title_head')
    <title>@yield('title')</title>
    {{ HTML::script('js/jquery-2.1.0.min.js') }}
    @yield('after_jquery')
    {{ HTML::script('js/holder.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/php/number_format.js') }}
    {{ HTML::script('js/php/unserialize.js') }}
    {{ HTML::script('bootflat/js/icheck.min.js') }}
    {{ HTML::style('bootflat/css/site.min.css') }}
    {{ HTML::style('css/main.css') }}
</head>
<body>
<div class="container">
    <nav class="navbar navbar-inverse nav-bar-update" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{ HTML::link('/', 'Webshop Sandbox', array('class'=>'navbar-brand')) }}
            </div>
            <ul class="nav navbar-nav">
                <li>{{ HTML::link('/catalogue', 'Catalogue') }}</li>
            </ul>
            <div class="navbar-right">
                @if(Cart::count() > 0)
                @include('cart.cart')
                @endif

                @if(!Auth::guest())
                <p class="navbar-text navbar-left"><a class="navbar-link" href="">Signed in as {{ Auth::user()->username }}</a></p>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="clr20">&nbsp;</div>
    <div class="footer">
        <div class="container">
            <div class="clearfix">
                <div class="footer-logo"><a href="#">Webshop Sandbox</a></div>
                <dl class="footer-nav">
                    <dt class="nav-title">PORTFOLIO</dt>
                    <dd class="nav-item"><a href="#">Web Design</a></dd>
                </dl>
                <dl class="footer-nav">
                    <dt class="nav-title">ABOUT</dt>
                    <dd class="nav-item"><a href="#">The Company</a></dd>
                </dl>
                <dl class="footer-nav">
                    <dt class="nav-title">GALLERY</dt>
                    <dd class="nav-item"><a href="#">Flickr</a></dd>
                </dl>
                <dl class="footer-nav">
                    <dt class="nav-title">CONTACT</dt>
                    <dd class="nav-item"><a href="#">Basic Info</a></dd>
                </dl>
            </div>
            <div class="footer-copyright text-center">Copyright © 2014 Webshop Sandbox. All rights reserved.</div>
        </div>
    </div>
</div>
</body>
</html>