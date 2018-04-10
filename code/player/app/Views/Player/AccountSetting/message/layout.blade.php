@extends('Player.AccountSetting.home.layout')

@section('scripts')
    @include('Player.AccountSetting.home.scripts')
@endsection

@section('scripts1')
    @include('Player.AccountSetting.message.scripts')
@endsection

@section("as_nav")
    @include('Player.AccountSetting.home.as_nav')
@endsection

@section('content')
    @include('Player.AccountSetting.message.content')
@endsection
