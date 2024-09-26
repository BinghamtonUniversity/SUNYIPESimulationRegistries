@extends('pages.default')

@section('title','Search Results')

@section('description')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Search Results</h1>
    </div>
</div>
@endsection

@section('content')
    @if (isset($error))  
        <div class="alert alert-danger">{{$error}}</div>
    @endif

    @if (count($activities) === 0)
        <div class="alert alert-warning">No exact matches were found. Please try to refine your search criteria</div>
    @endif
    <div class="row">
    @foreach($activities as $activity)
        <div class="col-sm-4">
        <div class="panel panel-default" style="height:200px;overflow:scroll;">
            <div class="panel-body">
                <h4>
                    <div class="badge pull-right">
                        @if($activity->is_ipe === true && $activity->is_simulation === false)
                            IPE
                        @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                            Simulation
                        @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                            IPE/Simulation
                        @endif
                    </div>
                    <a href="{{url('/activities/'.$activity->id)}}">{{$activity->title}}</a>
                </h4>
                <div>
                    @foreach($activity->matches as $match)
                        <div class="label label-success">{{$match}}</div>&nbsp;
                    @endforeach
                </div>
                <div>
                    <strong>Description:</strong>
                    {{substr($activity->description,0,250)}}
                </div>
                <div>
                    <strong>Contact:</strong>
                    <a href="mailto:{{$activity->contact_email}}">{{$activity->contact_name}}</a>
                </div>
                <div>
                    <strong>KSA Requirement:</strong>
                    {{$activity->ksa_requirement}}
                </div>
                <div>
                    <strong>Learning Objectives:</strong>
                    {{$activity->learning_objectives}}
                </div>
            </div>
        </div>
        </div>
    @endforeach
    </div>

@endsection
