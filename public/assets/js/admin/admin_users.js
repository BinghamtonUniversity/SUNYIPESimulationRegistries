ajax.get('/api/users',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'users',
            search:false,columns:false,upload:false,download:false,title:'users',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {
                    name:'suny_campus_id',type:"combobox",label:'SUNY Campus',
                    options:"/api/suny_campuses",
                    format:{
                        label:"{{name}}",
                        value:"{{id}}",
                        display:"{{name}}"
                    }
                },
                {name:'first_name',type:'text',label:'First Name'},
                {name:'last_name',type:'text',label:'Last Name'},
                {name:'password',type:'password',label:'Password'},
                {name:'email',type:'email',label:'Email'},
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/users', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            if(grid_event.model.attributes.active ===0){
                if(confirm("You are about to deactivate the user: Deactivating a user will reset the user permissions. Would you like to continue?")){
                    ajax.put('/api/users/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                        grid_event.model.attributes.update(data)
                    },function(data) {
                        grid_event.model.undo();
                    });
                }else{
                    grid_event.model.undo();
                }
            }else{
                ajax.put('/api/users/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                    grid_event.model.attributes.update(data)
                },function(data) {
                    grid_event.model.undo();
                });
            }

        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/users/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        }).on('model:user_permissions',function(grid_event) {
            if(auth_user_perms.includes('manage_permissions')) {
                manage_actions = [{"type": "save", "label": "Save", "action": "save"}];
                edit = true;
            } else {
                manage_actions = [];
                edit = false;
            }
            gdg = new gform(
                {
                    name:'permissions_form',
                    title:'User Permissions',
                    actions:manage_actions,
                    fields:[
                        {
                            type: "radio",
                            label: "Permissions",
                            name: "permissions",
                            multiple: true,
                            showColumn: true,
                            options: [
                                {
                                    type: "optgroup",
                                    options: [
                                        {
                                            label:"View Users",
                                            value:"view_users",
                                        },
                                        {
                                            label:"Manage Users",
                                            value:"manage_users",
                                        },

                                        {
                                            label:"Manage Permissions",
                                            value:"manage_permissions",
                                        },
                                        {
                                            label:"View Studies",
                                            value:"view_studies"
                                        },

                                        {
                                            label:"Manage Studies",
                                            value:"manage_studies"
                                        },
                                        {
                                            label:"Manage Data Types",
                                            value:"manage_data_types"
                                        },
                                        {
                                            label:"View Participants",
                                            value:"view_participants",
                                        },
                                        {
                                            label:"Manage Participants",
                                            value:"manage_participants",
                                        },
                                        {
                                            label:"View Reports",
                                            value:"view_reports",
                                        },
                                        {
                                            label:"Manage Reports",
                                            value:"manage_reports",
                                        },
                                        {
                                            label:"Run Reports",
                                            value:"run_reports",
                                        }
                                    ]
                                }
                            ]
                        }
                    ].map(d=>{
                        d.edit = edit
                        return d;
                    }),
                }).modal().on('save',function (perm_event){
                    ajax.put('/api/users/'+grid_event.model.attributes.id+'/permissions',perm_event.form.get(),function(perm_data) {
                        grid_event.model.attributes.permissions = perm_data
                        perm_event.form.trigger('close')
                    });
                }).set({permissions:grid_event.model.attributes.permissions})
        }).on("model:activate_user",function(grid_event){
            grid_event.model.attributes.active = 1
            console.log(grid_event);
            // debugger
            ajax.put('/api/users/'+grid_event.model.attributes.id,grid_event.model.attributes,function(res) {
                grid_event.model.update(res)
            },function (err){
                grid_event.model.undo();
            });
        }).on('model:deactivate_user',function(grid_event){
            if(confirm("Deactivating a user will reset the user permissions. Would you like to continue?")){
                grid_event.model.attributes.active = 0
                ajax.put('/api/users/'+grid_event.model.attributes.id,grid_event.model.attributes,function(res) {
                    grid_event.model.update(res)
                }, function (err){
                    grid_event.model.undo();
                });
            }
    })
});
