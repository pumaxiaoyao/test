
    <div>
        <div class="headbg">
            <div>
                <div class="hd_main">
                    <div class="fl_left">
                        <div id="system_datetime" class="hd_cl hd_cl_left"></div>
                    </div>
                    <div class="fl_right">
                        <?php if($LoginStatus == "True"): ?>
                            <?php echo $__env->make('Common.loginNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>

                        <?php if($LoginStatus == "False"): ?>
                            <?php echo $__env->make('Common.logoutNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="hd_nav_title">
            <div style="text-align: center;">
                <div class="hd_nav_c">
                    <div style="float: left">
                        <a href="/">
                            <img src="/static/img/beplay_logo_03.png" />
                        </a>
                    </div>
                    <div class="hd_nav_t">
                        <!-- <a href="/default.aspx" id="index">首页</a>-->
                        <a href="/game/sportsbook" id="sportsbook" class="" _t_nav="ty">体育投注<i></i></a>
                        <a href="/game/lbcp" id="lbcp" class="" _t_nav="cp">牛博彩票<i></i></a>
                        <a href="/game/igcp" id="igcp" class="" _t_nav="yul">时时彩<i></i></a>
                        
                    </div>
                    <div style="float: right;"><a onclick="openServiceBox()" class="hd_char_icon hd_char"></a></div>
                </div>
                <div class="navigation-down">
                    <div id="ty" class="nav-down-menu menu-1" _t_nav="ty">
                        <div class="nav-down-box">
                            <div class="fans"><i><img src="../../static/img/head/ty1.png" /></i><span>每周返水<br />不设上限</span></div>
                            <div class="middle ahover">
                                <a href="/sportsbook/">
                                <i><img src="../../static/img/head/ty2.png" /></i>
                                <span>每月上万场体育赛事，稳定快速的结算系统 <strong>立即游戏</strong></span>
                                </a>
                            </div>
                            <div class="last ahover">
                                <a href="/mobile/">
                                    <div id="head_code_1"></div>
                                    <i><img src="../../static/img/head/ty3.png" /></i>
                                    <span>使用手机QQ或微信扫一扫可立即进行手机投注 <strong>手机投注</strong></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="yul" class="nav-down-menu menu-3 menu-1" _t_nav="yul">
                        <div class="nav-down-box nav-ylc">
                            <div class="fans"><i><img src="../../static/img/head/fans.png" /></i><span>精选最佳真人娱乐投注平台<br /><strong>每天返水</strong></span></div>
                            <div class="middle  ahover">
                                <a onclick="showCasinoMessage()">
                                    <i><img src="../../static/img/head/yl2.png" /></i>
                                    <span>全球占有率最高的平台 <strong>立即游戏</strong></span>
                                </a>
                            </div>
                            <div class="last ahover">
                                <a onclick="toProductPage('kipicasino')">
                                    <i><img src="../../static/img/head/yl3.png" /></i>
                                    <span>最创新，最具特色的平台 <strong>立刻游戏</strong></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="kl" class="nav-down-menu menu-3 menu-1" _t_nav="kl">
                        <div class="nav-down-box nav-ylc">
                            <div class="fans"><i><img src="../../static/img/head/fans.png" /></i><span>业内第一，每天返水<br /><strong>不设上限</strong></span></div>
                            <div class="middle  ahover">
                                <a onclick="toProductPage('keno')">
                                    <div id="head_code_kl_1"></div>
                                    <i><img src="../../static/img/head/kl2.png" /></i>
                                    <span>全面支持三星、小米、华为、中兴、HTC、魅族、LG等安卓智能机<strong>立即游戏</strong></span>
                                </a>
                            </div>
                            <div class="last ahover">
                                <a>
                                    <div id="head_code_kl_2"></div>
                                    <i><img src="../../static/img/head/kl3.png" /></i>
                                    <span>冬日寒冷,躲在被窝里的keno快乐彩，暖暖的，很贴心。 <strong>扫码下载</strong></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="byu" class="nav-down-menu menu-3 menu-1" _t_nav="byu">
                        <div class="nav-down-box nav-ylc">
                            <div class="fans"><i><img src="../../static/img/head/fans.png" /></i><span>每周返水<br /><strong>不设上限</strong></span></div>
                            <div class="middle  ahover">
                                <a onclick="toProductPage('agbuyu')">
                                    <i><img src="../../static/img/head/byu2.png" /></i>
                                    <span>最具活力及趣味的新兴电子游戏<strong>立即游戏</strong></span>
                                </a>
                            </div>
                            <div class="last ">
                                <a>
                                    <div id="head_code_by_2"></div>
                                    <i><img src="../../static/img/head/byu3.png" /></i>
                                    <!--<span>使用手机QQ或微信扫一扫可立即进行手机游戏 <strong>手机捕鱼</strong></span>-->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- messageDetail div start -->
        <div class="m_pop">
            <div id="parentBorder" class="border">
                <iframe id="msgIframe" frameborder="0" scrolling="no" style="width:100%; height:100%;"></iframe>
                <div class="loading" id="popLoading"></div>
            </div>
        </div>
        <!-- messageDetail div end -->
    </div>