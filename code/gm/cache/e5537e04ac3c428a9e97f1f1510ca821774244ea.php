

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
    <?php echo $__env->yieldContent("tabpage1"); ?>
    <?php echo $__env->yieldContent("tabpage2"); ?>
    <?php echo $__env->yieldContent("tabpage3"); ?>
    <?php echo $__env->yieldContent("tabpage4"); ?>
    <?php echo $__env->yieldContent("tabpage5"); ?>
    <?php echo $__env->yieldContent("tabpage6"); ?>
    <?php echo $__env->yieldContent("tabpage7"); ?>
    <?php echo $__env->yieldContent("tabpage8"); ?>
</div>
<?php echo $__env->make("Player.playerDetailBox.scripts", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>