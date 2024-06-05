ajax.get('/api/suny_campuses',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'suny_campuses',
            search:false,columns:false,upload:false,download:false,title:'suny_campuses',
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
            ajax.post('/api/suny_campuses', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/suny_campuses/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/suny_campuses/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });

        })
});
