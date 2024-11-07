@extends('pages.default')

@section('title',"Manage")

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Manage My Activities</h1>
    </div>
</div><div class="alert alert-info" style="margin-top:15px;">
    <h3 style="margin-top:0px;">Instructions:</h3>
    Use the <div class="btn btn-success btn-xs">Add Activity</div> button below to create a new activity. <br>
    Select the <i class="fa fa-check-square-o"></i> next to the activity you want to modify and click <div class="btn btn-primary btn-xs">Update Activity</div> or <div class="btn btn-danger btn-xs">Delete Activity</div> <br>
    To upload or modify files associated with a particular activity, select the <i class="fa fa-check-square-o"></i> next to the appropriate activity and click <div class="btn btn-default btn-xs">Manage Files</div>
</div>
<div id="admin-update-activities"></div>

<div id="#main_target"></div>
@endsection

@section('scripts')

window.templates.main = `@{{>files_modal}}`;
window.templates.files_modal = `
<div class="modal fade" id="files-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@{{current_activity.title}}</h4>
      </div>
      <div class="modal-body">
        
        @{{^files.length}}
            <div class="alert alert-warning">No files have been uploaded yet!</div>
        @{{/files.length}}
        <div class="row">
            @{{#files}}
                <div class="col-sm-6" style="text-align:center;">
                    <i class="fa fa-file-pdf-o" style="font-size:80px;"></i>
                    <div><input id="file-@{{id}}" type="text" value="@{{name}}" style="margin-top:10px;">.@{{ext}}</div>
                    <div class="btn btn-xs btn-info rename-file" data-id="@{{id}}" style="margin-top:10px;">Rename</div>
                    <div class="btn btn-xs btn-danger delete-file" data-id="@{{id}}" style="margin-top:10px;">Delete</div>
                </div>
            @{{/files}}
        </div>
        <hr>
        <input type="file" class="filepond" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
`;

var actions = [
    {"name":"create","label":"Add Activity"},
    {"name":"edit","label":"Update Activity","min":1,"max":1},
    '|',
    {"name":"manage_files","label":"Manage Files","min":1,"max":1},
    '|','|',
    {"name":"delete","label":"Delete Activity","min":1,"max":1},
];

app.get('/api/users/{{Auth::user()->id}}/activities',function(activities) {
    gdg = new GrapheneDataGrid({el:'#admin-update-activities',
        search: false,columns: false,upload:false,download:false,title:'Activities',
        actions:actions,
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
            grid_event.model.delete();
        });
    }).on("model:manage_files",function(grid_event) {
        app.get('/api/activities/'+grid_event.model.attributes.id+'/files',function(data) {
            app.data.current_activity = grid_event.model.attributes;
            app.data.files = data;
            app.update();
            $('#files-modal').modal('show')
            app.pond.setOptions({
                server: {
                    process: {
                        url: '/api/activities/'+app.data.current_activity.id+'/files',
                        method: 'POST',
                    },
                },
            });
        },function(data) {
            // Do nothing
        });
    })
});

app.click('.rename-file',function(event) {
    var file_name = document.getElementById('file-'+event.target.dataset.id).value;
    toastr.info('Changing File Name: '+file_name);
    app.put('/api/activities/' + app.data.current_activity.id + '/files/'+event.target.dataset.id,
        {name:file_name},function(data) {
            app.get('/api/activities/'+app.data.current_activity.id+'/files',function(data) {
                app.data.files = data;
                app.update();
            });
        });
})
app.click('.delete-file',function(event) {
    var file_name = document.getElementById('file-'+event.target.dataset.id).value;
    if (confirm('Are you sure you want to delete this file? It cannot be undone!')) {
        toastr.info('Deleting File: '+file_name);
        app.delete('/api/activities/' + app.data.current_activity.id + '/files/'+event.target.dataset.id,{},
            function(data) {
            app.get('/api/activities/'+app.data.current_activity.id+'/files',function(data) {
                app.data.files = data;
                app.update();
            });
        });
    }
})

window.ractive = Ractive({
    target: '#main_target',
    template: window.templates.main,
    partials: window.templates,
    data: app.data
});

// Create a FilePond instance
app.pond = FilePond.create(document.querySelector('input[type="file"]'), {
    allowMultiple: true,
    acceptedFileTypes: ['application/pdf'],
    maxFileSize: '20MB'
});
app.pond.on('processfile', (error, file) => {
    if (error) {
        console.log('Error processing file:', error);
    } else {
        console.log('File processed successfully:', file);
        app.get('/api/activities/'+app.data.current_activity.id+'/files',function(data) {
            app.data.files = data;
            app.update();
            app.pond.removeFiles();
        });
    }
});


@endsection
