ajax.get('/api/activities',function(data) {
    // data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'activities',
            search:false,columns:false,upload:false,download:false,title:'activities',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {label:"Submitter", name:'submitter_id',type:'user',show:false},
                {label:"Status", name:'status',type:'select', options:[
                    {
                        label:"Submitted",
                        value:'submitted'
                    },
                    {
                        label:"In Review",
                        value:'review'
                    },
                    {
                        label:"Approved",
                        value:'approved'
                    }
                    ]
                },
                ...form_fields],
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
        }).on('model:view_logs',function (grid_event){
            window.location = '/admin/activities/'+grid_event.model.attributes.id+'/logs';
        })
});
