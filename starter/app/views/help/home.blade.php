@extends('master')

@section('title')
@parent
:: Help
@stop

{{-- Content --}}
@section('content')
    @if ($errors->has())
        <div id="errors" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
      @endif
    <div class="page-header">
        <h2>CropYield - What can we help you with today?</h2>
    </div>
    <div class="jumbotron">
      <ul>
        <li>Still waiting on input from client...</li>
        <li>Still waiting on input from client...</li>
        <li>Still waiting on input from client...</li>
        <li>Still waiting on input from client...</li>
        <li><a href="">Download will go here.</a></li>
      </ul>
    </div>


@stop
