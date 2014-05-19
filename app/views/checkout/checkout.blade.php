@extends('layout.master')

@section('content')

<ul class="nav nav-pills nav-justified">
    <li class="active">
        <a href="#">Details.</a>
    </li>
    <li>
        <a href="#">Payment method.</a>
    </li>
    <li>
        <a href="#">Summary.</a>
    </li>
    <li>
        <a href="#">Payment.</a>
    </li>
    <li>
        <a href="#">Thank you.</a>
    </li>
</ul>

@yield('step')

@stop