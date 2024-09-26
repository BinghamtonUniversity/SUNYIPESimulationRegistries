@extends('pages.default')

@section('title',$activity->title)

@section('description')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">{{$activity->title}}</h1>
    </div>
</div>
@endsection

@section('content')

@if($activity->status !== 'approved')
    <div class="alert alert-warning">
        This submission is currently under review and cannot be viewed.
        Please try back at a later date.
    </div>
@endif

@if($activity->status === 'approved')
<div class="panel panel-default">   
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12" style="font-size:20px;">
                <div class="badge pull-right">
                    @if($activity->is_ipe === true && $activity->is_simulation === false)
                        IPE
                    @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                        Simulation
                    @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                        IPE/Simulation
                    @endif
                </div>
                <div><strong>Description: </strong><br> {{$activity->description}}</div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Contact Name: </strong> {{$activity->contact_name}}
                    </div>
                    <div class="col-sm-6">
                        <strong>Contact Email: </strong> <a href="mailto:{{$activity->contact_email}}">{{$activity->contact_email}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>KSA Requirements: </strong> {{$activity->ksa_requirements}}
                    </div>
                    <div class="col-sm-6">
                        <strong>Number of Learners: </strong> {{$activity->number_of_learners}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body" style="font-size:20px;">
        <div class="row">
        @foreach($activity->plain_text_values as $type)
            <div class="col-sm-6">
                @if (is_array($type['value']))
                    <strong>{{$type['type']}}: </strong> {{implode(', ',$type['value'])}}
                @else
                    <strong>{{$type['type']}}: </strong> {{$type['value']}}
                @endif
            </div>
        @endforeach
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Files</h3></div>
    <div class="panel-body">
        <i class="fa fa-file-o fa-4x"></i>
    </div>
</div>
@endif
@endsection
