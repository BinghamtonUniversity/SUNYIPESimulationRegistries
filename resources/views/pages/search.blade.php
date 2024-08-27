@extends('pages.default')

@section('title','Search')

@section('description')
    <h1>Search</h1>
@endsection

@section('content')
    <div id="search-form"></div>
@endsection

@section('scripts')
    new gform(data.search_form,'#search-form').on('save',function(event) {
        var search_values = event.form.get();
        var search_params = $.param(search_values);
        window.location = '/search/results?' + search_params;
    });
@endsection
