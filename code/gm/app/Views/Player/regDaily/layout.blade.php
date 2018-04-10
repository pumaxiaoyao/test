@extends('Home.common.layout')

@section('scripts')
    @include("Player.online.script")
@endsection

@section('scripts1')
    @include("Player.regDaily.script")
@endsection

@section('content')
    @include("Player.regDaily.content")
@endsection
