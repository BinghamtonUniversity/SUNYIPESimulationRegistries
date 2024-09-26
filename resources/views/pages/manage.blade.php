@extends('pages.default')

@section('title',"Manage: ".Auth::user()->name)

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
{{--debugger--}}
// Edit activities
$.ajax({
    type: "GET",

    url: root_url+"/api/users/{{Auth::user()->id}}/activities",
    success: function(activities) {
{{--        console.log(activities);--}}
{{--        console.log({!! json_encode($activities_form_fields) !!})--}}
{{--        debugger--}}
        gdg = new GrapheneDataGrid({el:'#admin-update-activities',
        search: false,columns: false,upload:false,download:false,title:'Activities',
        entries:[],
        count:20,
        schema:{!! json_encode($activities_form_fields) !!},
        data: activities
        }).on("model:created",function(grid_event) {
            console.log(grid_event.model.attributes);
            form_fields = grid_event.model.attributes
            form_fields.submitter_id = {{Auth::user()->id}}
            form_fields.status = "submitted"
            form_fields.is_ipe = form_fields.is_ipe == true ? 1 : 0
            form_fields.is_simulation = form_fields.is_simulation == true? 1:0
            $.ajax({
                type:"POST",
                url:root_url+"/api/users/{{Auth::user()->id}}/activities",
                data:form_fields,
                success:function(grid_event,result){
                    grid_event.model.update(result)
                    toastr.success(result.title +' successfully created!');
                    console.log(result)
                }.bind(null,grid_event)
            })
        }).on("model:edited",function(grid_event){
            console.log(grid_event.model.attributes);
            edit_form_fields = grid_event.model.attributes
            edit_form_fields.submitter_id = {{Auth::user()->id}}
            edit_form_fields.status = "submitted"
            edit_form_fields.is_ipe = edit_form_fields.is_ipe == true ? 1 : 0
            edit_form_fields.is_simulation = edit_form_fields.is_simulation == true? 1:0
            $.ajax({
                type:"PUT",
                url:root_url+"/api/activities/"+ grid_event.model.attributes.id,
                data:edit_form_fields,
                success:function(result){
                grid_event.model.update(result)
                toastr.success(result.title +' successfully updated!');
                console.log(result)}
            })
        })
        .on("model:deleted",function(grid_event) {
            $.ajax({
                type:"DELETE",
                url:root_url+'/api/activities/'+grid_event.model.attributes.id,
                data:grid_event.model.attributes,
                success:function(result){
                    toastr.success('Successfully deleted!');
                    console.log(result)
                }
                })
        })
    }
});
@endsection
