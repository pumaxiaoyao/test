@extends('Agent.AccountSetting.home.layout')

@section('scripts')
    @include('Agent.AccountSetting.home.scripts')
@endsection

@section('scripts1')
    @include('Agent.reports.agentReports.scripts')
@endsection

@section("as_nav")
    @include('Agent.AccountSetting.home.as_nav')
@endsection

@section('content')
    @include('Agent.reports.agentReports.content')
@endsection
