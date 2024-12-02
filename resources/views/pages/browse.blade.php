@extends('pages.default')

@section('title','Browse Activities')

@section('description')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Browse Activities</h1>
    </div>
</div>
@endsection

@section('content')
    <div class="btn btn-primary" id="filter-activities-btn" style="width:100%;margin-bottom:20px;"><i class="fa fa-filter"></i> Search / Filter Activities</div>
    @if (isset($error))  
        <div class="alert alert-danger">{{$error}}</div>
    @endif
    @if (count($activities) === 0)
        <div class="alert alert-warning">No exact matches were found. Please try to refine your search criteria</div>
    @endif
    <div class="row">
    @foreach($activities as $activity)
        <div class="col-sm-4">
        <div class="panel panel-default" style="height:300px;overflow:scroll;">
            <div class="panel-body">
                <h4>
                    @if(!is_null($activity->video_url))
                    <div class="badge pull-right" style="margin-left:5px;">
                        <a href="{{$activity->video_url}}" target="_blank" <i class="fa fa-video-camera fa-fw"></i></a>
                    </div>
                    @endif
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
                    <strong>Knowledge:</strong>
                    {{$activity->ksa_knowledge}}
                </div>
                <div>
                    <strong>Skills:</strong>
                    {{$activity->ksa_skills}}
                </div>
                <div>
                    <strong>Attitudes:</strong>
                    {{$activity->ksa_attitudes}}
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

@section('scripts')

    window.forms.search_form = {
        'legend': 'Search / Filter Activities',
        'name':'Search',
        'fields':data.search_form_fields,
        'actions':[
            {"type": "cancel","action": "cancel","label": "<i class=\"fa fa-times\"></i> Cancel","modifiers": "btn btn-danger"},
            {'type':'button','action':'select_all','label':'Select All','modifiers':'btn btn-warning'},
            {'type':'button','action':'select_none','label':'Select None','modifiers':'btn btn-warning'},
            {'type':'save','action':'save','label':'Search / Filter','modifiers':'btn btn-info'},
        ],
    };

    app.form('search_form').on('save',function(event) {
        var search_values = event.form.get();
        var search_params = $.param(search_values);
        window.location = '/browse?' + search_params;
    }).on('select_none',function(event) {
        app.form('search_form').set(null);
    }).on('select_all',function(event) {
        var all_values = {is_ipe:true,is_simulation:true,types:{}};
        _.each(app.form('search_form').options.fields[2].fields,function(field,value) {
            all_values.types[field.name] = _.pluck(field.options,'value');
        })
        app.form('search_form').set(all_values);
    }).on('cancel',function(event) {
        event.form.trigger('close');
    });

    
    app.click('#filter-activities-btn',function(e) {
        app.form('search_form').set(null);
        app.form('search_form').modal();
    })

@endsection
