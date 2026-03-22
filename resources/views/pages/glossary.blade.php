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
            <div class="panel-body" style="font-size: 20px;">
                <h2>{{$type->type}}</h2>
                @if (isset($type->help_text))
                    <p style="background-color:#006fa3;color:#fff;display:block;padding:4px 8px;border-radius:4px;white-space:normal;word-wrap:break-word;max-width:100%;font-size:0.9em;margin-bottom:8px;">{{$type->help_text}}</p>
                @endif
                <dl>
                @foreach($type['values'] as $value)
                    @if (isset($value->help_text))
                        <dt>{{$value->value}}</dt>
                        <dd>{{$value->help_text}}</dd>
                    @endif
                @endforeach
                </dl>
            </div>
        </div>
        @endif
    @endforeach
</div>
</div>
@endsection
