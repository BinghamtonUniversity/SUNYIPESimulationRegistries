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
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Knowledge: </strong> {{$activity->ksa_knowledge}}
                    </div>
                    <div class="col-sm-6">
                        <strong>Skills: </strong> {{$activity->ksa_skills}}
                    </div>
                    <div class="col-sm-6">
                        <strong>Attitudes / Behaviors: </strong> {{$activity->ksa_attitudes}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Learning Objectives: </strong> {{$activity->learning_objectives}}
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
    <div class="panel-heading"><h3 class="panel-title">Files (Click to Download)</h3></div>
    <div class="panel-body">
        @if(count($files) === 0)
            <div class="alert alert-warning">No files available</div>
        @endif
        <div class="row">
            @foreach($files as $file)
                <div class="col-sm-3" style="text-align:center;">
                    <div class="btn btn-primary download_files">
                        <i class="fa fa-file-pdf-o" style="font-size:80px;"></i>
                        <div>{{$file->name}}.{{$file->ext}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
    window.forms['download_form'] = {"name":"download_form","legend":"Please Provide Your Contact Information",
        "actions":[
            {"type": "cancel","action": "cancel","label": "<i class=\"fa fa-times\"></i> Cancel","modifiers": "btn btn-danger"},
            {"type":"save","action":"save","label":"Download Files","modifiers":"btn btn-info"},
        ],
        "fields":[
            {"label":"Your Name","name":"name","type":"text","required":true,"limit":255},
            {"label":"Your Organization","name":"name","type":"text","required":true,"limit":255},
            {"type":"email","label":"Email","name":"email","required":true},
        ]
    }
    app.form('download_form').on('save',function(e) {
        if (e.form.validate()) {
            e.form.trigger('close');
            toastr.success('Prentending to Download Files...');
        }
    }).on('cancel',function(e) {
        e.form.trigger('close');
    })
    app.click('.download_files',function() {
        app.form('download_form').modal();
    })
@endsection
