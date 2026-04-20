@extends('pages.default')

@section('title',"Manage")

@section('content')
<a id="skip-to-add-activity" href="#admin-update-activities" class="sr-only sr-only-focusable">Skip to Main Content</a>
<section id="manage-main-content" tabindex="-1" aria-labelledby="manage-page-title">
<div class="panel panel-default">
    <div class="panel-body">
        <h1 id="manage-page-title" style="text-align:center;margin:0px;">Manage My Activities</h1>
    </div>
</div>
<section class="alert" style="margin-top:15px;background-color:#004c93;color:#fff;border-color:#003a70;" aria-labelledby="manage-instructions-heading">
    <h2 id="manage-instructions-heading" style="margin-top:0px;color:#fff;font-size:24px;">Instructions</h2>
    Use the <span class="badge" style="background-color:#006200;">Add Activity</span> button below to create a new activity.<br>
    Select the <i class="fa fa-check-square-o" aria-hidden="true"></i> next to the activity you want to modify and click
    <span class="badge" style="background-color:#333333;">Update Activity</span> or
    <span class="badge" style="background-color:#B10000;">Delete Activity</span>.<br>
    To upload or modify files, select the <i class="fa fa-check-square-o" aria-hidden="true"></i> next to the activity and click
    <span class="badge" style="background-color:#333333;">Manage Files</span><br>
    <span>To replace a file, delete the original first. Be sure to update the Date Developed/Revised field in the description.<br>
    <span>
        <br>Be sure to <strong>Submit for Review</strong> once the documents have been uploaded.  You will receive a confirmation email.
    </span>
        <br><strong>*Please note that emails from the SUNY Share Library will come from OpenSim Registry(noreply@binghamton.edu) </strong></span><br>
    <br>
    <a href="/assets/files/SUNY_Nursing_Simulation_Fellowship_Simulation_Template.docx" target="_blank" rel="noopener noreferrer" style="color:#ffffff;" aria-label="Download SUNY Nursing Simulation Fellowship Simulation Template as a DOCX file (opens in a new tab)">Download SUNY Nursing Simulation Fellowship Simulation Template (DOCX)</a><br>
    <a href="/assets/files/SIPTEC_Simulation_Scenario_Template.docx" target="_blank" rel="noopener noreferrer" style="color:#ffffff;" aria-label="Download SIPTEC Simulation Scenario Template as a DOCX file (opens in a new tab)">Download SIPTEC Simulation Scenario Template (DOCX)</a>
</section>
<section class="alert" style="margin-top:15px;background-color:#004c93;color:#fff;border-color:#003a70;" aria-labelledby="manage-review-criteria-heading">
    <h2 id="manage-review-criteria-heading" style="margin-top:0px;color:#fff;font-size:24px;">Review Criteria</h2>
    <ul style="margin-bottom:0;">
        <li>Interprofessional Education activity submissions will be reviewed using the Interprofessional Education Checklist.</li>
        <li>Simulation submissions will be reviewed according to the CSA Scenario Validation Checklist.</li>
    </ul>
</section>

<div id="admin-update-activities" tabindex="-1"></div>

<div id="#main_target"></div>
</section>
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
        <h2 class="modal-title">@{{current_activity.title}}</h2>
      </div>
      <div class="modal-body">
          <div class="alert alert-info">Required file: Simulation scenario document.<br>Consider including other documents to support the scenario implementation: Lab results, provider orders, standardized participant/role scripts, quizzes, etc.
              <br>Be sure to go back into your activity, and use <strong>Submit for Review</strong> once the documents have been uploaded. You will receive a confirmation email.
          </div>
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
        <h3>Upload Files</h3>
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
        <h2 class="modal-title">@{{current_activity.title}} File Download Logs</h2>
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

var focusAddActivityButton = function(attempt) {
    var max_attempts = 20;
    var current_attempt = attempt || 0;
    var grid_container = document.getElementById('admin-update-activities');
    if (!grid_container) {
        return;
    }

    var controls = grid_container.querySelectorAll('button, a, [role="button"], input[type="button"], input[type="submit"]');
    var add_activity_control = _.find(controls, function(control) {
        var text = (control.textContent || '').trim().toLowerCase();
        var value = (control.value || '').trim().toLowerCase();
        var aria_label = (control.getAttribute('aria-label') || '').trim().toLowerCase();
        return text === 'add activity' || value === 'add activity' || aria_label === 'add activity';
    });

    if (add_activity_control) {
        add_activity_control.focus();
        return;
    }

    if (current_attempt < max_attempts) {
        setTimeout(function() {
            focusAddActivityButton(current_attempt + 1);
        }, 100);
    } else {
        grid_container.focus();
    }
};

document.addEventListener('click', function(event) {
    if (event.target && event.target.id === 'skip-to-add-activity') {
        event.preventDefault();
        focusAddActivityButton();
    }
});

var modal_focus_trap_state = {
    active_modal: null,
    trigger_element: null
};

var getModalFocusableElements = function(modal) {
    if (!modal) {
        return [];
    }

    var selector = 'a[href], area[href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"]), [contenteditable="true"]';
    return _.filter(modal.querySelectorAll(selector), function(element) {
        return element.offsetParent !== null;
    });
};

var getPreferredModalFocusElement = function(modal) {
    if (!modal) {
        return null;
    }

    var preferred_selectors = {
        myModal: '#activity_form input[name="title"]:not([disabled])'
    };

    var modal_id = modal.getAttribute('id');
    var preferred_selector = modal_id ? preferred_selectors[modal_id] : null;
    if (preferred_selector) {
        var preferred_element = modal.querySelector(preferred_selector);
        if (preferred_element) {
            return preferred_element;
        }
    }

    return modal.querySelector('[autofocus]');
};

var focusWithinModal = function(modal) {
    if (!modal || !$(modal).is(':visible')) {
        return;
    }

    var preferred_element = getPreferredModalFocusElement(modal);
    if (preferred_element) {
        preferred_element.focus();
        return;
    }

    var focusable = getModalFocusableElements(modal);
    if (focusable.length) {
        focusable[0].focus();
        return;
    }

    modal.setAttribute('tabindex', '-1');
    modal.focus();
};

var activateModalFocusTrap = function(modal, trigger_element) {
    modal_focus_trap_state.active_modal = modal;
    modal_focus_trap_state.trigger_element = trigger_element || document.activeElement;
};

var getTopVisibleModal = function() {
    var visible_modals = $('.modal:visible').toArray();
    return visible_modals.length ? visible_modals[visible_modals.length - 1] : null;
};

var ensureActiveModalFocusTrap = function() {
    var active_modal = modal_focus_trap_state.active_modal;
    if (active_modal && $(active_modal).is(':visible')) {
        return active_modal;
    }

    var top_modal = getTopVisibleModal();
    if (top_modal) {
        activateModalFocusTrap(top_modal, modal_focus_trap_state.trigger_element || document.activeElement);
    } else {
        modal_focus_trap_state.active_modal = null;
    }

    return modal_focus_trap_state.active_modal;
};

var scheduleModalTrapActivation = function(trigger_element, attempt) {
    var max_attempts = 20;
    var current_attempt = attempt || 0;
    var top_modal = getTopVisibleModal();

    if (top_modal) {
        activateModalFocusTrap(top_modal, trigger_element);
        focusWithinModal(top_modal);
        return;
    }

    if (current_attempt < max_attempts) {
        setTimeout(function() {
            scheduleModalTrapActivation(trigger_element, current_attempt + 1);
        }, 100);
    }
};

var releaseModalFocusTrap = function(trigger_override) {
    var trigger_element = trigger_override || modal_focus_trap_state.trigger_element;
    modal_focus_trap_state.active_modal = null;
    modal_focus_trap_state.trigger_element = null;

    if (trigger_element && typeof trigger_element.focus === 'function' && document.contains(trigger_element)) {
        trigger_element.focus();
    }
};

$(document).on('show.bs.modal', '.modal', function() {
    this._focusTriggerElement = document.activeElement;
});

$(document).on('shown.bs.modal', '.modal', function() {
    activateModalFocusTrap(this, this._focusTriggerElement);
    focusWithinModal(this);
});

$(document).on('hidden.bs.modal', '.modal', function() {
    var top_modal = getTopVisibleModal();
    if (top_modal) {
        activateModalFocusTrap(top_modal, modal_focus_trap_state.trigger_element);
        focusWithinModal(top_modal);
    } else if (modal_focus_trap_state.active_modal === this) {
        releaseModalFocusTrap(this._focusTriggerElement);
    } else {
        releaseModalFocusTrap(this._focusTriggerElement);
    }

    this._focusTriggerElement = null;
});

document.addEventListener('keydown', function(event) {
    if (event.key !== 'Tab') {
        return;
    }

    var modal = ensureActiveModalFocusTrap();
    if (!modal) {
        return;
    }

    var focusable = getModalFocusableElements(modal);
    if (!focusable.length) {
        event.preventDefault();
        modal.setAttribute('tabindex', '-1');
        modal.focus();
        return;
    }

    var first = focusable[0];
    var last = focusable[focusable.length - 1];
    var active_element = document.activeElement;

    if (event.shiftKey) {
        if (active_element === first || !modal.contains(active_element)) {
            event.preventDefault();
            last.focus();
        }
    } else if (active_element === last || !modal.contains(active_element)) {
        event.preventDefault();
        first.focus();
    }
});

document.addEventListener('focusin', function(event) {
    var modal = ensureActiveModalFocusTrap();
    if (!modal) {
        return;
    }

    if (!modal.contains(event.target)) {
        focusWithinModal(modal);
    }
});

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
        var modal_trigger = document.activeElement;
        app.form('activity_form').modal();
        scheduleModalTrapActivation(modal_trigger);
    }).on('model:update_activity',function (grid_event) {
        app.current_grid_event = grid_event;
        app.form('activity_form').set(null);
        app.form('activity_form').set(grid_event.model.attributes);
        var modal_trigger = document.activeElement;
        app.form('activity_form').modal();
        scheduleModalTrapActivation(modal_trigger);
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
    });

    app.gdatagrid.bindDataGrid('#admin-update-activities', {
        tableLabel: 'Manage activities data grid'
    });
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
