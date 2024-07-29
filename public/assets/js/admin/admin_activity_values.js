ajax.get('/api/activity_values',function(data) {
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'activity_values',
            search:false,columns:false,upload:false,download:false,title:'activity_values',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'activity_id',label:"Activity",type:'number'},
                {
                    name:'activity_id',type:"combobox",label:'Activity',
                    options:"/api/activities",
                    format:{
                        label:"{{name}}",
                        value:"{{id}}",
                        display:"{{name}}"
                    }
                },
                {
                    name:'value_id',type:"combobox",label:'Value',
                    options:"/api/values",
                    format:{
                        label:"{{name}}",
                        value:"{{id}}",
                        display:"{{name}}"
                    }
                }
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/activities', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/activities/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/activities/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
