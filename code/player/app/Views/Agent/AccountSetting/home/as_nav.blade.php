<div class="conmain">
    <div class="nr_nav">
        <div class="nr_nav_userimg">
            <img src="/static/img/zx/touxiang.png" />
        </div>
        <div class="nr_nav_user">
            <div class="nr_nav_user_title">
                <span id="salutationtext"></span>
                <b>{{ $LoginMemberName or ""}}</b>
            </div>
            <div class="nr_nav_user_time"></div>
        </div>
        <div class="nr_nav_money">
            <div class="nr_nav_money_title">
                <span>账户余额</span>
            </div>
            <div class="nr_nav_money_num">
                <b id="MainBalance_b">{{ $MainBalance or "" }}</b>
                <span id="refreshAgentBt"></span>
            </div>
        </div>
        <div class="nr_nav_saveMoney">
            <div class="nr_nav_saveMoney_box">
                <div class="pic_1">
                    <a href="memberReports?setting=memberlist">
                            <i></i>会员列表</a>
                </div>
                <div class="pic_2">
                    <a href="memberReports?setting=daily">
                            <i></i>每日报表</a>
                </div>
                <div class="pic_3">
                    <a href="agentWithdrawl?setting=tk">
                            <i></i>提款</a>
                </div>
                <div class="pic_4">
                    <a href="benifitReports">
                            <i></i>佣金报表</a>
                </div>
            </div>
        </div>
    </div>
    <div class="nr_main">
        <div class="nr_left_nav">
            <span class="nr_left_nav_san">
                    <i class="nr_left_nav_i">
                        <b></b>
                    </i>
                </span>
            <div class="left_nav_one">
                <div class="left_nav_title">
                    <i></i>报表中心
                    <b></b>
                </div>
                <dl style="display:none;">
                    <dd class="left_nav_ck ">
                        <a href="memberReports">
                                <span></span>下线会员报表</a>
                    </dd>
                    <dd class="left_nav_tk ">
                        <a href="agentReports">
                                <span></span>下线代理报表</a>
                    </dd>
                    <dd class="left_nav_zz ">
                        <a href="benifitReports">
                                <span></span>佣金报表</a>
                    </dd>
                </dl>
            </div>
            <div class="left_nav_two">
                <div class="left_nav_title">
                    <i></i>资金管理
                    <b></b>
                </div>
                <dl style="display:none;">
                    <dd class="left_nav_ck ">
                        <span></span>
                        <a href="agentWithdrawl">提交提款</a>
                    </dd>
                    <dd class="left_nav_tk ">
                        <span></span>
                        <a href="bankManager"> 银行卡</a>
                    </dd>
                </dl>
            </div>
            <div class="left_nav_three">
                <div class="left_nav_title">
                    <i></i>个人中心
                    <b></b>
                </div>
                <dl style="display:none;">
                    <dd class="left_nav_ck">
                        <span></span>
                        <a href="accountSetting">账号管理</a>
                    </dd>
                    <dd class="left_nav_tk">
                        <span></span>
                        <a href="agentInfo"> 合营信息</a>
                    </dd>
                    <dd class="left_nav_zz">
                        <span></span>
                        <a href="receivebox"> 消息中心</a>
                    </dd>
                </dl>
            </div>
        </div>