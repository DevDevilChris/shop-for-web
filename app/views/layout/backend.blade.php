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
    {{ HTML::style('css/backend/frame.css') }}
</head>
<body>
    <div class="protect-width">
        <div class="header navbar-fixed-top protect-width">
            <div class="logo">
                <h1 class="logo-h1">Grapefruit<small>cms</small></h1>
            </div>
            <div class="navigation-base">
                <ul class="nav-left pull-left">
                    <li>
                        <a href="#" class="item">
                            <span class="glyphicon glyphicon-home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <span class="glyphicon glyphicon-file"></span>
                            Content
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <span class="glyphicon glyphicon-camera"></span>
                            Media
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            Webshop
                        </a>
                    </li>
                </ul>

                <div class="pull-right">
                    <a href="#" class="link">
                        <span class="glyphicon glyphicon-new-window"></span> Open website
                    </a>
                </div>
            </div>
        </div>

        <div class="row top-margin-fix">
            <div class="col-lg-12">
                <ol class="breadcrumb breadcrumb-arrow">
                    <li><a href="#"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Library</a></li>
                    <li class="active"><span><i class="glyphicon glyphicon-calendar"></i> Data</span></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                @yield('sub')
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        Cras justo odio
                    </a>
                    <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                    <a href="#" class="list-group-item">Morbi leo risus</a>
                    <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item">Vestibulum at eros</a>
                </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                @yield('content')
            </div>
        </div>

        <div class="feet navbar-fixed-bottom">
            <small class="quick-stats">
                <span class="glyphicon glyphicon-user"></span> 2 admins
                <span class="glyphicon glyphicon-user"></span> 0 users
            </small>
            <small class="copyright pull-right">Copyright 2014 - Backend - All rights reserved</small>
        </div>

        {{ HTML::script('js/backend/backend-functions-1.0.js') }}
    </div>
</body>
</html>