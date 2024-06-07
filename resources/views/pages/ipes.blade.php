@extends('pages.default')

@section('title', 'IPES')

@section('description')
    <div class="alert alert-info">Under development</div>
@endsection

@section('content')
    @foreach($ipes as $ipe)
        <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
            <a href="{{url('/ipes/'.$ipe->id)}}">
                {{$ipe->name}}
            </a>
        </h4>
        <div>
            <b>Description:</b>
            {{substr($ipe->description,0,250)}}
        </div>
    @endforeach

@endsection
