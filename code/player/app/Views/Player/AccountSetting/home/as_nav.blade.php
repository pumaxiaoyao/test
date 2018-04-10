<div class="conmain">
    <div class="nr_nav">
        <div class="nr_nav_userimg"><img src="/static/img/zx/touxiang.png" /></div>
        <div class="nr_nav_user">
            <div class="nr_nav_user_title"><span id="salutationtext"></span> <b>{{ $LoginMemberName or ""}}</b></div>
            <div class="nr_nav_user_time"></div>
            <div class="progress-box">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" data-transitiongoal-backup="0" data-transitiongoal="0" aria-valuenow="0" style="width: {{ $SafetyRate or "
                        "}}%;"></div>
                </div>
            </div>
            <div class="nr_nav_user_help"><span>账户安全等级 <strong>{{ $AccountSafetyLevel or "" }}</strong></span>
                <span>
        <b class="pic_1  {{ empty($Phone)?'':'on' }} "><i>提示：为了享受更便捷的手机app服务，请先<a href="/player/accountSetting?setting=phone"> 绑定手机！</a></i></b>
        <b class="pic_2  {{ empty($Email)?'':'on' }} "><i>提示：为了享受更便捷的找回密码服务，请先<a href="/player/accountSetting?setting=mail"> 绑定邮箱！</a></i></b>
        <b class="pic_3  {{ empty($RealName)?'':'on' }} "><i>提示：为了享受更便捷的提款服务，请先<a href="/player/accountSetting"> 绑定真实姓名！</a></i></b>
        <b class="pic_4  {{ empty($isBindCard)?'':'on' }} "> <i>提示：为了享受更便捷的提款服务，请先<a href="/player/BankManager"> 绑定银行卡！</a></i></b>
    </span>
            </div>
        </div>
        <div class="nr_nav_money">
            <div class="nr_nav_money_title"><span>账户余额</span>(中心钱包)</div>
            <div class="nr_nav_money_num"><b id="MainBalance_b">{{ $MainBalance or "" }}</b><span id="refreshMainBt"></span></div>
        </div>
        <div class="nr_nav_saveMoney">
            <div class="nr_nav_saveMoney_box">
                <div class="pic_1"><a href="deposit"><i></i>存款</a></div>
                <div class="pic_2"><a href="withdrawal"><i></i>提款</a></div>
                <div class="pic_3"><a href="transfer"><i></i>转账</a></div>
                <div class="pic_4"><a href="History"><i></i>交易记录</a></div>
            </div>
        </div>
    </div>

    <div class="nr_main">
        <div class="nr_left_nav">
            <span class="nr_left_nav_san"> <i class="nr_left_nav_i"><b></b></i></span>
            <div class="left_nav_one">
                <div class="left_nav_title"><i></i>资金管理<b></b></div>
                <dl style="display:none;">
                    <dd class="left_nav_ck"><a href="deposit"><span></span>存款</a></dd>
                    <dd class="left_nav_tk"><a href="withdrawal"><span></span>提款</a></dd>
                    <dd class="left_nav_zz"><a href="transfer"><span></span>转账</a></dd>
                    <dd class="left_nav_jy"><a href="History"><span></span>交易记录</a></dd>
                    <dd class="left_nav_yhk"><a href="BankManager"><span></span>银行卡</a></dd>
                </dl>
            </div>
            <div class="left_nav_two">
                <div class="left_nav_title"><i></i>个人中心<b></b></div>
                <dl style="display:none;">
                    <dd class="left_nav_ck"><span></span><a href="AccountSetting">账号设置</a></dd>
                    <dd class="left_nav_tk"><span></span><a href="receivebox"> 消息中心</a></dd>
                    <dd class="left_nav_jy"><span></span><a href="BettingRecords">投注记录</a></dd>
                </dl>
            </div>
        </div>