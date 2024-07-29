ajax.get('/api/types',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'types',
            search:false,columns:false,upload:false,download:false,title:'types',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'type',type:'text',label:'Type'},
                {name:'is_ipe',type:'switch',label:'Is IPE', options: [
                        {value:false,label:"No"},
                        {value:true,label:"Yes"}
                    ]
                },
                {name:'is_simulation',type:'switch',label:'Is Simulation', options: [
                        {value:false,label:"No"},
                        {value:true,label:"Yes"}
                    ]
                },

                {name:'searchable',type:'switch',label:'Is searchable', options: [
                        {value:false,label:"No"},
                        {value:true,label:"Yes"}
                    ]
                }
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/types', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/types/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:manage_values",function(grid_event) {
            window.location = '/admin/types/'+grid_event.model.attributes.id+'/values';
        })
        .on("model:deleted",function(grid_event) {
            ajax.delete('/api/types/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
