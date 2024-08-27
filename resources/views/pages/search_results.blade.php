@extends('pages.default')

@section('title','Search Results')

@section('description')
    <h1>Search Results</h1>
@endsection

@section('content')
    @if (isset($error))  
        <div class="alert alert-danger">{{$error}}</div>
    @endif

    @if (count($activities) === 0)
        <div class="alert alert-warning">No exact matches were found. Please try to refine your search criteria</div>
    @endif
    @foreach($activities as $activity)
        <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
            <a href="{{url('/activities/'.$activity->id)}}">
                {{$activity->title}}
            </a>
        </h4>
        <div>
            <strong>Type:</strong>
            @if($activity->is_ipe === true && $activity->is_simulation === false)
                IPE
            @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                Simulation
            @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                IPE/Simulation
            @endif
            <strong>Description:</strong>
            {{substr($activity->description,0,250)}}
        </div>
        <div>
            @foreach($activity->matches as $match)
                <div class="label label-success">{{$match}}</div>&nbsp;
            @endforeach
        </div>
    @endforeach

@endsection
