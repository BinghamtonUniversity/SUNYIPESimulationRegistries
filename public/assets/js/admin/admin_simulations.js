ajax.get('/api/simulations',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'simulations',
            search:false,columns:false,upload:false,download:false,title:'simulations',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'name',type:'text',label:'Name'},
                {name:'user_id',type:'user',label:'User'},
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/simulations', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/simulations/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/simulations/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });

        })
});
