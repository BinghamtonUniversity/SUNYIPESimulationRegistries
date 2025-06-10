ajax.get(`/api/activities/${id}/logs`,function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid(
        {el:'#adminDataGrid',
            name:'activity_logs',
            search:false,columns:false,upload:false,download:false,title:'Activity Logs',
            entries:[],
            sortBy:'order',
            actions:[],
            count:20,
            schema:[
                {name:'id',type:'hidden'},
                {name:'name',type:"text",label:'Actor Name'},
                {name:'organization',type:"text",label:'Organization'},
                {name:'email',type:"text",label:'Email'},
                {name:'file_name',type:"text",label:'File Name',
                    template:"{{attributes.file.name}}"
                },
                {
                    name:'activity_id',type:"combobox",label:'Activity',
                    options:"/api/activities",
                    format:{
                        label:"{{title}}",
                        value:"{{id}}",
                        display:"{{title}}"
                    }
                }
            ],
            data:data
        })

        .on("model:deleted",function(grid_event) {
            ajax.delete('/api/activity/${id}/logs/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
