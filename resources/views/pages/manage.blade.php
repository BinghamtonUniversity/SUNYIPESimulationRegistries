@extends('pages.default')

@section('title',"Manage")

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Manage My Activities</h1>
    </div>
</div><div class="alert alert-info" style="margin-top:15px;background-color:#004c93;">
    <h3 style="margin-top:0px;">Instructions:</h3>
    Use the <div class="btn btn-success btn-xs">Add Activity</div> button below to create a new activity. <br>
    Select the <i class="fa fa-check-square-o"></i> next to the activity you want to modify and click <div class="btn btn-primary btn-xs">Update Activity</div> or <div class="btn btn-danger btn-xs">Delete Activity</div> <br>
    To upload or modify files associated with a particular activity, select the <i class="fa fa-check-square-o"></i> next to the appropriate activity and click <div class="btn btn-default btn-xs">Manage Files</div>
</div>
<div id="admin-update-activities"></div>

<div id="#main_target"></div>
@endsection

@section('scripts')

var activities_form_fields = {!! json_encode($activities_form_fields) !!};

window.forms.activity_form = {
    "name":"activity_form",
    "legend":"Manage Activity",
    "actions":[
        {"type": "cancel","action": "cancel","label": "<i class=\"fa fa-times\"></i> Cancel","modifiers": "btn btn-danger"},
        {"type":"save","action":"save_draft","label":"Save Draft","modifiers":"btn btn-warning"},
        {"type":"save","action":"submit","label":"Submit (For Review)","modifiers":"btn btn-success"},
    ],
    "fields":activities_form_fields
};

window.templates.main = `@{{>files_modal}}@{{>logs_modal}}`;
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
                <div class="col-sm-6" style="text-align:center;margin-bottom:15px;">
                    <i class="fa fa-file-pdf-o" style="font-size:80px;"></i>
                    <div><input id="file-@{{id}}" type="text" value="@{{name}}" style="margin-top:10px;width:80%;display:inline" class="form-control">.@{{ext}}</div>
                    <div class="btn btn-xs btn-info rename-file" data-id="@{{id}}" style="margin-top:10px;">Rename</div>
                    <div class="btn btn-xs btn-danger delete-file" data-id="@{{id}}" style="margin-top:10px;">Delete</div>
                </div>
            @{{/files}}
        </div>
        <hr>
        <h4>Upload Files:</h4>
        <input type="file" class="filepond" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
`;
window.templates.logs_modal = `
<div class="modal fade" id="logs-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@{{current_activity.title}} File Download Logs</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
            <thead><tr><th>File</th><th>Name</th><th>Organization</th><th>Email</th><th>Date</th></tr></thead>
            <tbody>
            @{{#logs}}
                <tr><td>@{{file.name}}</td><td>@{{name}}</td><td>@{{organization}}</td><td>@{{email}}</td><td>@{{created_at}}</td></tr>
            @{{/logs}}
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
`;

var actions = [
    {"name":"add_activity","label":"Add Activity","type":"success"},
    {"name":"update_activity","label":"Update Activity","min":1,"max":1,"type":"primary"},
    '|',
    {"name":"visit","label":"View Activity","min":1,"max":1},
    {"name":"manage_files","label":"Manage Files","min":1,"max":1},
    {"name":"logs","label":"View File Download Logs","min":1,"max":1},
    '|','|',
    {"name":"delete","label":"Delete Activity","min":1,"max":1},
];

app.create_update_activity = function(e,validate=false) {
    if (validate) {
        if (!e.form.validate()) {
            return false;
        }
    }
    var form_data = e.form.get();
    if (_.has(form_data,'id') && form_data.id !== null && form_data.id !== '') {
        app.put('/api/activities/'+form_data.id,form_data,function(data) {
            e.form.trigger('close');
            app.current_grid_event.model.update(data)
        },function(data) {
            app.current_grid_event.model.undo();
        });
    } else {
        app.post('/api/activities', e.form.get(),function(data) {
            e.form.trigger('close');
            app.current_grid_event.grid.add(data)
        });
    }
}

app.form('activity_form').on('save_draft',function(e) {
    e.form.set({status:'draft'});
    app.create_update_activity(e);
}).on('submit',function(e) {
    e.form.set({status:'submitted'});
    app.create_update_activity(e,true);
}).on('cancel',function(e) {
    e.form.trigger('close');
})

app.get('/api/users/{{Auth::user()->id}}/activities',function(activities) {
    gdg = new GrapheneDataGrid({el:'#admin-update-activities',
        search: false,columns: false,upload:false,download:false,title:'Activities',
        actions:actions,
        entries:[],
        count:20,
        schema:activities_form_fields,
        data: activities
    }).on("add_activity",function(grid_event) {
        app.current_grid_event = grid_event;
        app.form('activity_form').set(null);
        app.form('activity_form').set({status:'draft'});
        app.form('activity_form').modal();
    }).on('model:update_activity',function (grid_event) {
        app.current_grid_event = grid_event;
        app.form('activity_form').set(null);
        app.form('activity_form').set(grid_event.model.attributes);
        app.form('activity_form').modal();
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
    }).on("model:logs",function(grid_event) {
        app.get('/api/activities/'+grid_event.model.attributes.id+'/logs',function(data) {
            app.data.current_activity = grid_event.model.attributes;
            app.data.logs = data;
            app.update();
            $('#logs-modal').modal('show')
        });
    }).on("model:visit",function(grid_event) {
        window.location = '/activities/'+grid_event.model.attributes.id+'?preview=true';
    }).on("click",function(grid_event) {
        window.location = '/activities/'+grid_event.model.attributes.id+'?preview=true';
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
        toastr.error("File Upload Error!")
        console.log('Error processing file:', error);
    } else {
        console.log('File processed successfully:', file);
        app.get('/api/activities/'+app.data.current_activity.id+'/files',function(data) {
            toastr.success("File Uploaded!")
            app.data.files = data;
            app.update();
            app.pond.removeFiles();
        });
    }
});


@endsection
