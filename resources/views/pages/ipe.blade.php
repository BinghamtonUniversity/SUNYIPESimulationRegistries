@extends('pages.default')

@section('title',$ipe->name)

@section('description')
    <div class="alert alert-info">Welcome to {{$ipe->name}}</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6"><strong>Name:</strong> {{$ipe->name}}</div>
        <div class="col-lg-6"><strong>Description: </strong> {{$ipe->description}}</div>
    </div>
@endsection
