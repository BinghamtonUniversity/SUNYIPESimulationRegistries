@extends('pages.default')

@section('title',$activity->title)

@section('description')
<section class="panel panel-default">
    <section class="panel-body">
        <a href="https://creativecommons.org/licenses/by-nc/4.0/" target="_blank" rel="noopener noreferrer" class="pull-right">
            <img src="/assets/images/licenses/by-nc.png" style="width:150px;" alt="Creative Commons Attribution-NonCommercial 4.0 License">
        </a>
        <h1 style="text-align:center;margin:0px;">{{$activity->title}}</h1>
    </section>
</section>
@endsection

@section('content')

@if($activity->status === 'approved' || (request()->get('preview') === 'true' && auth()->user()))
    @if($activity->status !== 'approved')
        <section class="alert alert-warning">
            This submission has not been approved (current status is: {{$activity->status}}) and cannot be viewed publicly.
        </section>
    @endif
    <section class="panel panel-default">
        <section class="panel-body">
            <section class="row">
                <section class="col-sm-12" style="font-size:20px;">
                    <section class="badge pull-right">
                        @if($activity->is_ipe === true && $activity->is_simulation === false)
                            IPE
                        @elseif($activity->is_ipe === false && $activity->is_simulation === true)
                            Simulation
                        @elseif($activity->is_ipe === true && $activity->is_simulation === true)
                            IPE/Simulation
                        @endif
                    </section>
                    <section>
                        <strong>Description: </strong><br>
                        {!! str_replace("\n",'<br>',$activity->description) !!}
                    </section>
                    <hr>
                    <section class="row">
                        <section class="col-sm-6">
                            <strong>Contact Name: </strong> {{$activity->contact_name}}
                        </section>
                        <section class="col-sm-6">
                            <strong>Contact Email: </strong> <a href="mailto:{{$activity->contact_email}}">{{$activity->contact_email}}</a>
                        </section>
                        <section class="col-sm-6">
                            <strong>Scenario Author and Credentials: </strong> {{$activity->scenario_author}}
                        </section>
                        <section class="col-sm-6">
                            <strong>Date Developed / Revised: </strong> {{$activity->date_developed}}
                        </section>

                    </section>
                    <hr>
                    <section class="row">
                        <section class="col-sm-6">
                            @if (is_null($video_html))
                                <!-- <section class="alert alert-info" style="font-size:12px;">No Video to Display</section> -->
                            @else
                                {!! $video_html !!}
                            @endif
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <section class="panel panel-default">
        <section class="panel-body" style="font-size:20px;">
            <section class="row">
            @foreach($activity->plain_text_values as $type)
                <section class="col-sm-6">
                    @if (is_array($type['value']))
                        <strong>{{$type['type']}}: </strong> {{implode(', ',$type['value'])}}
                    @else
                        <strong>{{$type['type']}}: </strong> {{$type['value']}}
                    @endif
                </section>
            @endforeach
            </section>
        </section>
    </section>
    <section class="panel panel-default">
        <section class="panel-heading"><h3 class="panel-title">Files (Click to Download)</h3></section>
        <section class="panel-body">
            @if(count($files) === 0)
                <section class="alert alert-warning">No files available</section>
            @endif
            <section class="row">
                @foreach($files as $file)
                    <section class="col-sm-3" style="text-align:center;">
                        <button type="button" class="btn btn-primary download_files" style="width:100%;" data-file_id="{{$file->id}}" data-activity_id="{{$activity->id}}" aria-label="Download {{$file->name}}.{{$file->ext}}">
                            <i class="fa fa-file-pdf-o" style="font-size:80px;" aria-hidden="true"></i>
                            <section style="text-wrap:wrap;">{{$file->name}}.{{$file->ext}}</section>
                        </button>
                    </section>
                @endforeach
            </section>
        </section>
    </section>
@else
    <section class="alert alert-warning">
        This submission has not been approved (current status is: {{$activity->status}}) and cannot be viewed.
        Please try back at a later date.
    </section>
@endif
@endsection

@section('scripts')
    window.forms['download_form'] = {"name":"download_form","legend":"Please Provide The Following Information:",
        "actions":[
            {"type": "cancel","action": "cancel","label": "<i class=\"fa fa-times\"></i> Cancel","modifiers": "btn btn-danger"},
            {"type":"save","action":"save","label":"Download File","modifiers":"btn btn-info"},
        ],
        "fields":[
            {name:"activity_id",type:"hidden"},
            {name:"file_id",type:"hidden"},
            {"label":"Your Name","name":"name","type":"text","required":true,"limit":255},
            {"label":"Your Organization","name":"organization","type":"text","required":true,"limit":255},
            {"type":"email","label":"Email","name":"email","required":true,"limit":255,
                "help":"<a href='https://creativecommons.org/licenses/by-nc/4.0/' target='_blank' rel='noopener noreferrer'>Review the CC BY-NC 4.0 license (opens in new tab)</a>"
            },
            {"type":"checkbox","label":'Activity License',name:"license_accept","required":true,options:[
                {label:'I accept the CC BY-NC 4.0 license associated with this activity',value:false},
                {label:'I accept the CC BY-NC 4.0 license associated with this activity',value:true}
            ],
                "help":"<a href='https://creativecommons.org/share-your-work/cclicenses/' target='_blank' rel='noopener noreferrer'>Review the Creative Commons license options (opens in new tab)</a>"
            },
        ]
    }
    app.form('download_form').on('save',function(e) {
        var form_data = e.form.get();
        if (e.form.validate()) {
            e.form.trigger('close');
            toastr.success('Downloading Files ...');
            window.open('/api/activities/'+form_data.activity_id+'/files/'+form_data.file_id+'?name='+form_data.name+'&organization='+form_data.organization+'&email='+form_data.email, '_blank');
        }
    }).on('cancel',function(e) {
        e.form.trigger('close');
    })
    app.click('.download_files',function(e) {
        var data = e.target.closest('.btn').dataset;
        app.form('download_form').set(data);
        app.form('download_form').modal();
    })
@endsection
