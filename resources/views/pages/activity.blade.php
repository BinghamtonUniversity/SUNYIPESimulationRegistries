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
        <div class="col-lg-6"><strong>Contact Name: </strong> {{$activity->contact_name}}</div>
        <div class="col-lg-6"><strong>Contact Email: </strong> {{$activity->contact_email}}</div>
        <div class="col-lg-6"><strong>Participating Programs: </strong> {{$activity->participating_programs}}</div>
        <div class="col-lg-6"><strong>KSA Requirements: </strong> {{$activity->ksa_requirements}}</div>
        <div class="col-lg-6"><strong>Focus Areas: </strong> {{$activity->focus_areas}}</div>
        <div class="col-lg-6"><strong>Learning Objectives: </strong> {{$activity->learning_objectives}}</div>
        <div class="col-lg-6"><strong>Number of Learners: </strong> {{$activity->number_of_learners}}</div>

    </div>
@endsection
