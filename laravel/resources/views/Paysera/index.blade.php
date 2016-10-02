@extends('app')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Laravel
        </div>
        <p>
        @for ($i = 0; $i < count($data); $i++)
            {{ $data[$i] }}<br>
        @endfor
        </p>
    </div>
@stop