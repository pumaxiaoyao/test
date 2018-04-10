

<ul class="title nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">玩家信息</a></li>
    <li><a href="#tab_2" data-toggle="tab" onclick="box_playerBalanceInfo()">平台额度</a></li>
    <li><a href="#tab_3" data-toggle="tab" onclick="box_playerTransRecord()">玩家账户交易</a></li>
    <li><a href="#tab_4" data-toggle="tab" onclick="box_playerMessage()">玩家历史消息</a></li>
    <li><a href="#tab_5" data-toggle="tab" onclick="box_playrtLoginInfo()">登录日志</a></li>
    <li><a href="#tab_6" data-toggle="tab">防止套利查询</a></li>
    <li><a href="#tab_7" data-toggle="tab" onclick="box_playerBankInfo()">取款银行</a></li>
    <li><a href="#tab_8" data-toggle="tab" onclick="box_playerCSInfo()">CSlog</a></li>
</ul>
<div class="tab-content">
    @yield("tabpage1")
    @yield("tabpage2")
    @yield("tabpage3")
    @yield("tabpage4")
    @yield("tabpage5")
    @yield("tabpage6")
    @yield("tabpage7")
    @yield("tabpage8")
</div>
@include("Player.playerDetailBox.scripts")