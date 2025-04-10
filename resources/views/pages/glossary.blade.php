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
        @if ($type->in_glossary === true)
        <div class="panel panel-default">
            <div class="panel-body">
                <h2>{{$type->type}}</h2>
                @if (isset($type->help_text))
                    <!-- <h4><div class="label label-default">{{$type->help_text}}</div></h4><br> -->
                @endif
                @foreach($type['values'] as $value)
                    @if (isset($value->help_text))
                        <h4><label>{{$value->value}}</label>: {{$value->help_text}}</h4>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>
</div>
@endsection
