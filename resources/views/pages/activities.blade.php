@extends('pages.default')

@section('title', 'Activities')

@section('description')
    <div class="alert alert-info">Under development</div>
@endsection

@section('content')
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
    @endforeach

@endsection
