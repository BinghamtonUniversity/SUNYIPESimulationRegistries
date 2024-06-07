@extends('pages.default')

{{--@section('title',$simulation->title)--}}

@section('description')
    <div class="alert alert-info">Under development</div>
@endsection

@section('content')
    @foreach($simulations as $simulation)
        <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
            <a href="{{url('/simulations/'.$simulation->id)}}">
                {{$simulation->name}}
            </a>
        </h4>
        <div>
            <b>Description:</b>
            {{substr($simulation->description,0,250)}}
        </div>
    @endforeach
    <div class="row">
        <div class="col-xs-6"></div>
    </div>
@endsection
