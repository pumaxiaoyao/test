<body>
    <div>
        <div class="headbg">
            <div>
                <div class="hd_main">
                    <div class="fl_left">
                        <div id="system_datetime" class="hd_cl hd_cl_left"></div>
                    </div>
                    <div class="fl_right">
                        @if($LoginStatus == "True")
                            @include('Agent.common.loginNav')
                        @endif

                        @if($LoginStatus == "False")
                            @include('Agent.common.logoutNav')
                        @endif
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
                        <a href="/agent/index" id="index">合营首页
                            <i></i>
                        </a>
                        <a href="/agent/agentMode" id="mode">合营模式
                            <i></i>
                        </a>
                        <a href="/agent/Policies" id="Policies">佣金政策
                            <i></i>
                        </a>
                        <a href="/agent/Apply" id="reg">成为代理
                            <i></i>
                        </a>
                        <a href="/agent/Contact" id="contact">联系我们
                            <i></i>
                        </a>
                        <!-- <a href="/agent/agentInfo" id="test">代理用户界面预览(临时测试)><i></i></a> -->
                    </div>
                    <div style="float: right;">
                        <a onclick="openServiceBox()" class="hd_char_icon hd_char"></a>
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