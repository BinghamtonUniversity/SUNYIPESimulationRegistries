ajax.get(`/api/types/${type_id}/values`,function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'values',
            search:false,columns:false,upload:false,download:false,title:'Values',
            entries:[],
            sortBy:'order',
            actions:actions,
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'value',type:'text',label:'Value'},
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
                // {
                //     name:'type_id',type:"combobox",label:'Type',
                //     options:"/api/types",
                //     format:{
                //         label:"{{name}}",
                //         value:"{{id}}",
                //         display:"{{name}}"
                //     }
                // },

            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post(`/api/types/${type_id}/values`, grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put(`/api/types/${type_id}/values/${grid_event.model.attributes.id}`,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete(`/api/types/${type_id}/values/${grid_event.model.attributes.id}`,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
