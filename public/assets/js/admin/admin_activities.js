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
                {name:'type',type:'select',label:'Type',options:[
                        {label:"IPE",value:"ipe"},
                        {label:"Simulation",value:"simulation"},
                        {label:"IPE/Simulation",value:"ipe_simulation"}
                    ]
                },
                {name:'title',type:'text',label:'Title'},
                {name:'description',type:'textarea',label:'Description'},
                {name:'contact_name',type:'text',label:'Contact Name'},
                {name:'contact_email',type:'text',label:'Contact Email'},
                {name:'participating_programs',type:'select',label:'Participating Programs', options:[
                        "Advanced Practice Nursing",
                        "Education",
                        "Occupational Therapy",
                        "Pharmacy",
                        "Physical Therapy",
                        "Prelicensure Nursing",
                        "Public Health",
                        "Social Work",
                        "Speech and Language Pathology",
                    ]},
                {name:'ksa_requirements',type:'text',label:'KSA Requirements'},
                {name:'focus_areas',type:'text',label:'Focus Areas'},
                {name:'learning_objectives',type:'text',label:'Learning Objectives'},
                {name:'is_new',type:'switch',label:'Is New?', options: [
                        {
                            "label": "False",
                            "value": 0
                        },
                        {
                            "label": "True",
                            "value": 1
                        }
                    ]},
                {name:'number_of_learners',type:'text',label:'Number of Learners'},
                {name:'status',type:'select',label:'Status', options:[
                        {label:"Submitted",value:"submitted"},
                        {label:"Under Review",value:"review"},
                        {label:"Approved",value:"approved"}
                    ]},
            ],
            data:data
        }).on("model:created",function(grid_event) {
            ajax.post('/api/ipes', grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on('model:edited',function (grid_event) {
            ajax.put('/api/ipes/'+grid_event.model.attributes.id,grid_event.model.attributes,function(data) {
                grid_event.model.attributes.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/ipes/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
});
