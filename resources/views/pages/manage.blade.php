@extends('pages.default')

@section('title',"Manage")

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Manage My Activities</h1>
    </div>
</div><div class="alert alert-info" style="margin-top:15px;">
    <h3 style="margin-top:0px;">Instructions:</h3>
    Use the <div class="btn btn-success btn-xs">New</div> button below to create a new project listing.  <br>
    Select the <i class="fa fa-check-square-o"></i> next to the listing you want to modify and click <div class="btn btn-primary btn-xs">Edit</div> or <div class="btn btn-danger btn-xs">Delete</div>
</div>
<div id="admin-update-activities"></div>

@endsection

@section('scripts')
app.get('/api/users/{{Auth::user()->id}}/activities',function(activities) {
        gdg = new GrapheneDataGrid({el:'#admin-update-activities',
        search: false,columns: false,upload:false,download:false,title:'Activities',
        entries:[],
        count:20,
        schema:{!! json_encode($activities_form_fields) !!},
        data: activities
    }).on("model:created",function(grid_event) {
        app.post('/api/activities', grid_event.model.attributes,function(data) {
            grid_event.model.update(data)
        },function(data) {
            grid_event.model.undo();
        });
    }).on('model:edited',function (grid_event) {
        app.put('/api/activities/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
            grid_event.model.update(data)
        },function(data) {
            grid_event.model.undo();
        });
    }).on("model:deleted",function(grid_event) {
        app.delete('/api/activities/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
            grid_event.model.undo();
        });
    })
});
@endsection
