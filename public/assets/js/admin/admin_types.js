ajax.get('/api/types',function(data) {
    data = data.reverse();
    gdg = new GrapheneDataGrid({
        el:'#adminDataGrid',
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
            },
            {name:'multi_select',type:'switch',label:'Allow Multiple', options: [
                    {value:false,label:"No"},
                    {value:true,label:"Yes"}
                ],
            },
            {name:'in_glossary',type:'switch',label:'In Glossary', help: 'Include in Glossary', options: [
                    {value:false,label:"No"},
                    {value:true,label:"Yes"}
                ],
            },
            {name:'help_text',type:'textarea',label:'Help Text',showColumn:false,limit:255},
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
            grid_event.model.update(data)
        },function(data) {
            grid_event.model.undo();
        });
    }).on("model:manage_values",function(grid_event) {
        window.location = '/admin/types/'+grid_event.model.attributes.id+'/values';
    }).on("model:deleted",function(grid_event) {
        ajax.delete('/api/types/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
            grid_event.model.undo();
        });
    }).on('sort', e => {
        var tempdata = {items:_.map(e.grid.models, function(item){return item.attributes}).reverse()};//[].concat.apply([],pageData)
        var sortlist = '<ol id="sorter" class="list-group" style="margin: -15px;"> {{#items}} <li id="list_{{id}}" data-id="{{id}}" class="list-group-item filterable"> <div class="sortableContent"> <div class="fa fa-bars" style="cursor:move;"></div> {{type}} </div> </li> {{/items}} </ol>';
        var rendered_data = gform.m(sortlist,tempdata);
        mymodal = new gform({
            "legend":"Sort Types",
            "name": "sort_types",
            "fields":[{type:"output",label:"",name:"output",format:{value:rendered_data}}]
        }).modal().on('save',function(e){
            var order = _.map($('#sorter').children(), (item,index) => {return {id:item.dataset.id,order:index}})
            ajax.put('/api/types/order',{order:order},function(data) {
                toastr.success('Updated Types Order');
                e.form.trigger('close');
                setTimeout(function() {
                    location.reload(true);
                }, 500);
            },function(data) {
                toastr.error('Failed to Update Types Order');
            });
        }).on('cancel',function(e){
            e.form.trigger('close');
        });
        Sortable.create($(mymodal.el).find('.modal-content ol')[0],{draggable:'li'});
    });
});
