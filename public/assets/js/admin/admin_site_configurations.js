ajax.get('/api/site_configurations',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'site_configurations',
            search:false,columns:false,upload:false,download:false,title:'site_configurations',
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
                    "label": "Page",
                    "name": "key",
                    "showColumn": true,
                    "type": "text"
                },
                {
                    "type": "textarea",
                    "label": "Content",
                    "name": "value",
                    "showColumn": true
                }
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/site_configurations', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/site_configurations/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/site_configurations/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });

        })
});
