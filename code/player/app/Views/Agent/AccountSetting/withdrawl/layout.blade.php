@extends('Agent.AccountSetting.home.layout')

@section('scripts')
    @include('Agent.AccountSetting.home.scripts')
@endsection

@section('scripts1')
@include('Agent.AccountSetting.withdrawl.scripts')
@endsection

@section("as_nav")
    @include('Agent.AccountSetting.home.as_nav')
@endsection

@section('content')
@include('Agent.AccountSetting.withdrawl.content')
@endsection