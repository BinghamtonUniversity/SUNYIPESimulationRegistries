@extends('pages.default')

@section('title',$activity->title)

@section('description')
    <h1>{{$activity->title}}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6"><strong>Name:</strong> {{$activity->title}}</div>
        <div class="col-lg-6">
            <strong>Type:</strong>
            @if($activity->is_ipe === true && $activity->is_simulation === false)
                IPE
            @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                Simulation
            @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                IPE/Simulation
            @endif
        </div>
        <div class="col-lg-6"><strong>Description: </strong> {{$activity->description}}</div>
        <div class="col-lg-6"><strong>Contact Name: </strong> {{$activity->contact_name}}</div>
        <div class="col-lg-6"><strong>Contact Email: </strong> {{$activity->contact_email}}</div>
        <div class="col-lg-6"><strong>KSA Requirements: </strong> {{$activity->ksa_requirements}}</div>
        <div class="col-lg-6"><strong>Number of Learners: </strong> {{$activity->number_of_learners}}</div>
    </div>
@endsection
