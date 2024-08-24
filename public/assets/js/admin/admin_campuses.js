ajax.get('/api/campuses',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'campuses',
            search:false,columns:false,upload:false,download:false,title:'campuses',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {
                    "type": "hidden",
                    "label": "",
                    "name": "id",
                    "showColumn": true
                },
                {
                    "label": "Name",
                    "name": "name",
                    "showColumn": true,
                    "type": "text"
                }
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/campuses', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/campuses/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/campuses/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });

        })
});
