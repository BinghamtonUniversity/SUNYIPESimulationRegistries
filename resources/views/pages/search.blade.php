@extends('pages.default')

@section('title','Search')

@section('content')
<h1 style="text-align:center;">Search</h1>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="search-form"></div>
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
