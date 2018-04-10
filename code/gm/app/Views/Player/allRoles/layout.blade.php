@extends('Home.common.layout')

@section('scripts')
    @include("Player.online.script")
@endsection

@section('scripts1')
    @include("Player.allRoles.script")
@endsection

@section('content')
    @include("Player.allRoles.content")
@endsection

@section('modals')
    @include("Player.modal.agentModal")
    @include("Player.modal.layerModal")
    @include("Player.modal.balanceModal")
    @include("Player.modal.bonusModal")
    @include("Player.modal.waterCheckModal")
    @include("Player.modal.remarkModal")
    @include("Player.modal.resetPwdModal")
    @include("Player.modal.messageModal")
@endsection