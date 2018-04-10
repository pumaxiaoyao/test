<div style="position:relative">
    <span class="mg_lf5_rg_span">
        <a class="r_icon hd_headimg mg_lf5_rg_5"></a>
        <a id="head_name_login" href="/agent/AccountSetting" class="hd_cl hd_cl_right">{{ $LoginMemberName or "" }}</a>
        <span class="hd_cl">
            <a class=" hd_cl_right" href="/agent/receivebox">站内信</a>：
            <a class="hd_cl_msgnub_a" href="/agent/receivebox">
                <i>{{ $MessageCount or "" }}</i>
            </a>
        </span>
    </span>
    <span class="mg_lf5_rg_span">
        <a href="/agent/agentWithdrawl" class="hd_cl hd_cl_right">资金管理</a>
        <strong>
            <a class="r_icon" href="/agent/agentWithdrawl">提交提款</a>
            <a class="r_icon" href="/agent/bankManager">银行卡</a>
        </strong>
    </span>
    <a class="r_icon hd_xian mg_lf7_rg_7"></a>
    <div style="color:#fff;" class="hd_cl">中心钱包：
        <span id="MainBalance_Nav">{{ $MainBalance or "" }}</span>
    </div>
    <div class="hd_cl hd_cl_right" id="agentLogout" onclick="agent_logout()" style="margin-left: 20px; margin-right:0; display: inline-block;">退出
        <a class="r_icon fs_exit mg_lf7_rg_0" style="display: inline-block;"></a>
    </div>
</div>