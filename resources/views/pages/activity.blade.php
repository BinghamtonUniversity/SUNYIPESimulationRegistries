@extends('pages.default')

@section('title',$activity->title)

@section('description')
    <div class="alert alert-info">Welcome to {{$activity->title}}</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6"><strong>Name:</strong> {{$activity->title}}</div>
        <div class="col-lg-6">
            <strong>Type:</strong>
            @if($activity->type ==='ipe')
                IPE
            @elseif(($activity->type ==='simulation'))
                Simulation
            @elseif(($activity->type ==='ipe_simulation'))
                IPE/Simulation
            @endif
        </div>
        <div class="col-lg-6"><strong>Description: </strong> {{$activity->description}}</div>
    </div>
@endsection
