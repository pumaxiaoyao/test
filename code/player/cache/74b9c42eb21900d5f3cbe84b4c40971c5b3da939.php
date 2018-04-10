    <div style="position:relative">
        <span class="mg_lf5_rg_span">
            <a class="r_icon hd_headimg mg_lf5_rg_5"></a>
        <a id="head_name_login" href="/player/accountSetting" class="hd_cl hd_cl_right"><?php echo e(isset($LoginMemberName) ? $LoginMemberName : ""); ?></a>
            <span class="hd_cl">
                <a class=" hd_cl_right" href="/player/receivebox">站内信</a>：
            <a class="hd_cl_msgnub_a" href="/player/receivebox"><i><?php echo e(isset($MessageCount) ? $MessageCount : ""); ?></i> </a>
            </span>

        </span>
        <span class="mg_lf5_rg_span">
            <a href="/player/deposit"  class="hd_cl hd_cl_right">资金管理</a>
            <strong>
                <a class="r_icon" href="/player/deposit">存款</a>
                <a class="r_icon" href="/player/withdrawal">提款</a>
                <a class="r_icon" href="/player/transfer">转账</a>
            </strong>
        </span>
        <a class="r_icon hd_xian mg_lf7_rg_7"></a>
    <div style="color:#fff;" class="hd_cl">中心钱包：<span id="MainBalance_Nav"><?php echo e(isset($MainBalance) ? $MainBalance : ""); ?></span></div>
        <div class="hd_cl hd_cl_right" id="btn-logout" style="margin-left: 20px; margin-right:0; display: inline-block;">退出<a class="r_icon fs_exit mg_lf7_rg_0" style="display: inline-block;"></a></div>

    </div>