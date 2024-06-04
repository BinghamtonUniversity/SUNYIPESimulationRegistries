ajax.get('/api/ipes',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'ipes',
            search:false,columns:false,upload:false,download:false,title:'ipes',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'name',type:'text',label:'Name'},
                {name:'user_id',type:'user',label:'User'}
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/ipes', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            if(grid_event.model.attributes.active ===0){
                if(confirm("You are about to deactivate the user: Deactivating a user will reset the user permissions. Would you like to continue?")){
                    ajax.put('/api/ipes/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                        grid_event.model.attributes.update(data)
                    },function(data) {
                        grid_event.model.undo();
                    });
                }else{
                    grid_event.model.undo();
                }
            }else{
                ajax.put('/api/ipes/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                    grid_event.model.attributes.update(data)
                },function(data) {
                    grid_event.model.undo();
                });
            }

        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/ipes/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
