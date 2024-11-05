@extends('layouts.app')

@section('content')
    <div class="container">
        {!! $travelPlan->result !!}
    </div>
@endsection

@section('css')
    <style>
        .establishment {
            margin-top: 5%;
        }
    </style>
@endsection
