<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/home/index">
                <!-- <img src="/static/image/logo.png" alt="logo" class="logo-default"/>  -->          </a>
            <div class="menu-toggler sidebar-toggler hide">
            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <div class="top-menu">
            <label style="color:green;margin-top: 15px;">当前可用游戏平台额度：{{ $PlatformBalance or ""}}&nbsp;<a href="/report/trans"><i class="fa fa-search"></i></a></label>&nbsp;&nbsp;
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-extended dropdown-notification">
                    <a href="/message/platform" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-call-in"></i>
                            <span class="badge badge-default" id="sysMessageNum"></span>
                        </a>
                    <ul class="dropdown-menu" id="sysMessageList">
                        @foreach ($sysMessageList as $sysMessage) {{-- todo : show sysMessageList --}} @endforeach
                    </ul>
                </li>
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-default" id="tasksNum1"></span>
                        </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold" id="tasksNum2">{{ $taskCount or 0 }}</span>个任务通知</h3>
                        </li>
                        <li>
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;">
                                <ul class="dropdown-menu-list scroller" style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283"
                                    data-initialized="1">
                                    <li id="rega">
                                        <a href="/agent/verify">
                                                <span class="time" id="rega_n"></span>
											<span class="details">
												<span class="label label-sm label-icon label-success">
													<i class="fa fa-plus"></i>
												</span>
											有新的代理注册. </span>
                                            </a>
                                    </li>
                                    <li id="dptu">
                                        <a href="/playerFund/dptVerify">
                                                <span class="time" id="dptu_n"></span>
											<span class="details">
												<span class="label label-sm label-icon label-danger">
													<i class="fa fa-bolt"></i>
												</span>
											有新的玩家存款. <font style="color:red;" id="dptf_n">0</font>个已完成。</span>
                                            </a>
                                    </li>
                                    <li id="wtdu">
                                        <a href="/playerFund/wtdVerify">
                                                <span class="time" id="wtdu_n"></span>
											<span class="details">
												<span class="label label-sm label-icon label-warning">
													<i class="fa fa-bell-o"></i>
												</span>
											有新的玩家取款. </span>
                                            </a>
                                    </li>
                                    <li id="wtda">
                                        <a href="/agentFund/wtdVerify">
                                                <span class="time" id="wtda_n"></span>
											<span class="details">
												<span class="label label-sm label-icon label-info">
													<i class="fa fa-bullhorn"></i>
												</span>
											有新的代理取款. </span>
                                            </a>
                                    </li>
                                    <li id="actv">
                                        <a href="/activity/activityVerify">
                                                <span class="time" id="actv_n"></span>
											<span class="details">
												<span class="label label-sm label-icon label-info">
													<i class="fa fa-bullhorn"></i>
												</span>
											有新的活动申请. </span>
                                            </a>
                                    </li>
                                </ul>
                                <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 121.359223300971px; background: rgb(99, 114, 131);"></div>
                                <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="/static/incloud/admin/layout/img/avatar3_small.jpg"/>
								<span class="username username-hide-on-mobile">
								{{ $GmName or "" }} </span>
                        <!-- <i class="fa fa-angle-down"></i> -->
                    </a>
                </li>
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="/home/logout" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
        </div>
    </div>
</div>
</div>
<div class="clearfix">
</div>