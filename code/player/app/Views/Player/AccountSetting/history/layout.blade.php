@extends('Player.AccountSetting.home.layout')

@section('scripts')
    @include('Player.AccountSetting.home.scripts')
@endsection

@section('scripts1')
    @include('Player.AccountSetting.history.scripts')
@endsection

@section("as_nav")
    @include('Player.AccountSetting.home.as_nav')
@endsection

@section('content')
    @include('Player.AccountSetting.history.content')
@endsection
