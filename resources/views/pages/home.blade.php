@extends('pages.default')

@section('title', 'Home')

@section('content')
<div class="panel panel-default">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;"><i class="fa fa-medkit fa-fw"></i> SUNY Share Repository</h1>
    </div>
</div>
{!! $site_config['home'] ?? '' !!}

@endsection
