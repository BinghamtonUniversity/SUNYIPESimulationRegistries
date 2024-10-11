@extends('pages.default')

@section('title','Search')

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Search</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-info">
            Use the switches and checkboxes below to search for activities that meet your criteria
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="search-form"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    new gform(data.search_form,'#search-form').on('save',function(event) {
        var search_values = event.form.get();
        var search_params = $.param(search_values);
        window.location = '/search/results?' + search_params;
    }).set({is_ipe:true,is_simulation:true});
@endsection
