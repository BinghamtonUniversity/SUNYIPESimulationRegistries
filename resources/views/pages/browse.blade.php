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
    <div class="panel panel-default" style="font-size:18px;">
        <div class="panel-body">
            <a href="https://creativecommons.org/licenses/by-nc/4.0/" target="_blank" class="pull-right">
                <img src="/assets/images/licenses/by-nc.png" style="width:150px;">
            </a>
            Activities are submitted under the CC BY-NC license.  This license enables users to adapt and build upon the activities for noncommercial purposes.  
            We encourage you to modify an activity to fit your needs. The user may also distribute the activity.  When using or distributing the activity, credit for authorship must be given.
            Activities are vetted by simulation and/or IPE content experts for essential activity components prior to approval for inclusion.
        </div>
    </div>

    <div class="btn btn-primary" id="filter-activities-btn" style="width:100%;margin-bottom:20px;font-size:20px;"><i class="fa fa-filter"></i> Search / Filter Activities</div>
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
            <div class="panel-body" style="font-size: 20px;">
                <h2 style="font-size: 26px;">
                    @if(!is_null($activity->video_url))
                    <div class="badge pull-right" style="margin-left:5px;">
                        <a href="{{$activity->video_url}}" target="_blank" <i style="color:white;" class="fa fa-video-camera fa-fw"></i></a>
                    </div>
                    @endif
                    <div class="badge pull-right" style="margin-left:5px;">
                        @if($activity->is_ipe === true && $activity->is_simulation === false)
                            IPE
                        @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                            Simulation
                        @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                            IPE/Simulation
                        @endif
                    </div>
                    <a href="{{url('/activities/'.$activity->id)}}">{{$activity->title}}</a>
                </h2>
                <!--
                <div>
                    @foreach($activity->matches as $match)
                        <div class="label label-primary">{{$match}}</div>&nbsp;
                    @endforeach
                </div>
                -->
                <div>
                    <strong>Description:</strong>
                    {{substr($activity->description,0,250)}}
                </div>
                <div>
                    <strong>Contact:</strong>
                    <a href="mailto:{{$activity->contact_email}}">{{$activity->contact_name}}</a>
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
