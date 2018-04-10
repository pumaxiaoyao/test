@extends('Home.common.layout')

@section('scripts')
    @include("Player.online.script")
@endsection

@section('scripts1')

@endsection


@section('content')
    @include("Player.online.content")
@endsection


@section('modals')
    @include("Player.modal.agentModal")
    @include("Player.modal.layerModal")
    @include("Player.modal.balanceModal")
    @include("Player.modal.bonusModal")
    @include("Player.modal.waterCheckModal")
    @include("Player.modal.remarkModal")
@endsection
