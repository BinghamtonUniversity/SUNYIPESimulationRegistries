@extends('end_user.default')
@section('title',$ipe->title)

@section('description')
    <div class="alert alert-info">Under development</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2 style="float: left; margin-bottom: 0px;">{{$ipe->title}}</h2>
        <h2 style="text-align: right; margin-bottom: 0px;">{{$simulation->name}}</h2>
        <span style="font-size: 13px; padding: 0px 0px 0px 10px;">
            @if($ipe->type == "short") Short-Term Project
            @else Long-Term Project @endif
        </span>
    </div>
</div>
<div class="row">
    <div class="col-xs-6"></div>
</div>
@endsection
