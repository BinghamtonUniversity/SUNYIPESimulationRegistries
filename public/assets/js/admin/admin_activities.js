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
                {name:'id',type:'hidden'},
                {name:'submitter_id',label:"Submitter",type:'user'},
                {name:'is_ipe',type:'switch',label:'IPE Related',options:[
                    {label:'No','value':false},{label:'Yes','value':true}
                ]},
                {name:'is_simulation',type:'switch',label:'Simulation',options:[
                    {label:'No','value':false},{label:'Yes','value':true}
                ]},
                {name:'title',type:'text',label:'Title'},
                {name:'description',type:'textarea',label:'Description'},
                {name:'contact_name',type:'text',label:'Contact Name'},
                {name:'contact_email',type:'text',label:'Contact Email'},
                {name:'ksa_requirement',type:'text',label:'KSA Requirements'},
                {name:'learning_objectives',type:'text',label:'Learning Objectives'},
                {name:'number_of_learners',type:'text',label:'Number of Learners'},
                {name:'status',type:'select',label:'Status', options:[
                        {label:"Submitted",value:"submitted"},
                        {label:"Under Review",value:"reviewss"},
                        {label:"Approved",value:"approved"}
                    ]
                },
                {name:'approved_by',type:'user',label:'Approved By', show:false,
                    template:"{{user.first_name}}"
                },
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
