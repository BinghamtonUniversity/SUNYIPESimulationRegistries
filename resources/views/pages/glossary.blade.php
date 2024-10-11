@extends('pages.default')

@section('title','Glossary Of Terms')

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;">Glossary Of Terms</h1>
    </div>
</div>
<div class="row">
<div class="col-sm-12">
    @foreach($data['types'] as $type)
        <div class="panel panel-default">
            <div class="panel-body">
                <h1>{{$type->type}}</h1>
                @if (isset($type->help_text))
                    <div class="alert alert-info">{{$type->help_text}}</div>
                @else
                    <div class="alert alert-danger">No Help Text Specified</div>
                @endif
                <div class="row">
                @foreach($type['values'] as $value)
                    <div class="col-sm-4">
                        <h3>{{$value->value}}</h3>
                        @if (isset($value->help_text))
                            <div class="alert alert-success">{{$value->help_text}}</div>
                        @else
                            <div class="alert alert-warning">No Help Text Specified</div>
                        @endif
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
</div>
@endsection
