@extends('pages.default')

@section('title',$simulation->name)

@section('description')
    <div class="alert alert-info">Welcome to {{$simulation->name}}</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6"><strong>Name:</strong> {{$simulation->name}}</div>
        <div class="col-lg-6"><strong>Description:</strong> {{$simulation->description}}</div>
    </div>
@endsection
