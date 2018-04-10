<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul id="side-toggler" class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper">
                    <div class="sidebar-toggler">
                    </div>
                </li>
                {{--  <li class="sidebar-search-wrapper">
                </li>  --}}
                <li id="home">
                    <a href="/home/index">
                        <i class="icon-home"></i>
                            <span class="title">首页</span>
                            <span class="selected"></span>
                        </a>
                </li>
                <li id="player">
                    <a href="javascript:;">
                            <i class="icon-users"></i>
                            <span class="title">玩家管理</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="online">
                            <a href="/player/online">
                                    <i class="icon-edit"></i>当前在线玩家</a>
                        </li>
                        <li id="allRoles">
                            <a href="/player/allRoles">
                                    <i class="icon-edit"></i>所有玩家列表</a>
                        </li>
                        <li id="regDaily">
                            <a href="/player/regDaily">
                                    <i class="icon-edit"></i>今日注册玩家</a>
                        </li>
                        <li id="fundFlow">
                            <a href="/player/fundFlow">
                                    <i class="icon-edit"></i>玩家资金流水</a>
                        </li>
                    </ul>
                </li>
                <li id="playerfund">
                    <a href="javascript:;">
                            <i class="icon-diamond"></i>
                            <span class="title">玩家资金</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="dptVerify">
                            <a href="/playerfund/dptVerify">
                                    <i class="icon-edit"></i>存款审核</a>
                        </li>
                        <li id="dptHistory">
                            <a href="/playerfund/dptHistory">
                                    <i class="icon-edit"></i>存款历史查询</a>
                        </li>
                        <li id="dptCorrection">
                            <a href="/playerfund/dptCorrection">
                                    <i class="icon-edit"></i>玩家资金调整</a>
                        </li>
                        <li id="wtdVerify">
                            <a href="/playerfund/wtdVerify">
                                    <i class="icon-edit"></i>取款审核</a>
                        </li>
                        <li id="wtdHistory">
                            <a href="/playerfund/wtdHistory">
                                    <i class="icon-edit"></i>取款历史查询</a>
                        </li>
                        <li id="flowLimit">
                            <a href="/playerfund/flowLimit">
                                    <i class="icon-edit"></i>取款流水限制汇总</a>
                        </li>
                        <li id="transferList">
                            <a href="/playerfund/transferList">
                                    <i class="icon-edit"></i>转账未知处理列表</a>
                        </li>
                    </ul>
                </li>
                <li id="activity">
                    <a href="javascript:;">
                            <i class="icon-note"></i>
                            <span class="title">优惠活动</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="activities">
                            <a href="/activity/activities">
                                    <i class="icon-edit"></i>优惠活动管理</a>
                        </li>
                        <li id="activityVerify">
                            <a href="/activity/activityVerify">
                                    <i class="icon-edit"></i>活动审核管理</a>
                        </li>
                        <li id="activityHistory">
                            <a href="/activity/activityHistory">
                                    <i class="icon-edit"></i>活动审核历史</a>
                        </li>
                        <li id="activityFund">
                            <a href="/activity/activityFund">
                                    <i class="icon-edit"></i>活动资金统计</a>
                        </li>
                    </ul>
                </li>
                <li id="flow">
                    <a href="javascript:;">
                            <i class="icon-note"></i>
                            <span class="title">流水及返水</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="wagered">
                            <a href="/flow/wagered">
                                    <i class="icon-edit"></i>玩家流水明细</a>
                        </li>
                        <!-- <li id="grant">
                                <a href="/flow/grant">
                                    <i class="icon-edit"></i>发放玩家返水</a>
                            </li> -->
                        <li id="history">
                            <a href="/flow/history">
                                    <i class="icon-edit"></i>玩家返水历史</a>
                        </li>
                    </ul>
                </li>
                <li id="agent">
                    <a href="javascript:;">
                            <i class="icon-user"></i>
                            <span class="title">代理管理</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="verify">
                            <a href="/agent/verify">
                                    <i class="icon-edit"></i>代理审核</a>
                        </li>
                        <li id="aglist">
                            <a href="/agent/aglist">
                                    <i class="icon-edit"></i>代理列表</a>
                        </li>
                        <li id="verifyhistory">
                            <a href="/agent/verifyhistory">
                                    <i class="icon-edit"></i>代理审核历史</a>
                        </li>
                        <li id="domain">
                            <a href="/agent/domain">
                                    <i class="icon-edit"></i>代理域名</a>
                        </li>
                    </ul>
                </li>
                <li id="agentfund">
                    <a href="javascript:;">
                            <i class="icon-diamond"></i>
                            <span class="title">代理资金</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="curperiod">
                            <a href="/agentfund/curperiod">
                                    <i class="icon-edit"></i>本期代理结算</a>
                        </li>
                        <li id="settlehistory">
                            <a href="/agentfund/settlehistory">
                                    <i class="icon-edit"></i>代理结算历史</a>
                        </li>
                        <li id="agentWtdVerify">
                            <a href="/agentfund/agentWtdVerify">
                                    <i class="icon-edit"></i>代理取款审核</a>
                        </li>
                        <li id="agentWtdHistory">
                            <a href="/agentfund/agentWtdHistory">
                                    <i class="icon-edit"></i>代理取款历史</a>
                        </li>
                    </ul>
                </li>
                <li id="bank">
                    <a href="javascript:;">
                            <i class="icon-notebook"></i>
                            <span class="title">银行资金管理</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="cardlist">
                            <a href="/bank/cardlist">
                                    <i class="icon-edit"></i>银行资金明细</a>
                        </li>
                        <li id="bankpayment">
                            <a href="/bank/bankpayment">
                                    <i class="icon-edit"></i>银行支付设置</a>
                        </li>
                        <li id="merchant">
                            <a href="/bank/merchant">
                                    <i class="icon-edit"></i>第三方平台设置</a>
                        </li>
                        <li id="deposit">
                            <a href="/bank/deposit">
                                    <i class="icon-edit"></i>存款对账管理</a>
                        </li>
                    </ul>
                </li>
                <li id="message">
                    <a href="javascript:;">
                            <i class="icon-bell"></i>
                            <span class="title">系统消息</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="player">
                            <a href="/message/player">
                                    <i class="icon-edit"></i>玩家消息</a>
                        </li>
                        <li id="agent">
                            <a href="/message/agent">
                                    <i class="icon-edit"></i>代理消息</a>
                        </li>
                        <li id="platform">
                            <a href="/message/platform">
                                    <i class="icon-edit"></i>平台消息</a>
                        </li>
                    </ul>
                </li>
                <li id="settings">
                    <a href="javascript:;">
                            <i class="icon-settings"></i>
                            <span class="title">系统设置</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="playerLevel">
                            <a href="/settings/playerLevel">
                                    <i class="icon-edit"></i>玩家组设置</a>
                        </li>
                        <li id="agentLevel">
                            <a href="/settings/agentLevel">
                                    <i class="icon-edit"></i>代理层级设置</a>
                        </li>
                        <li id="gplist">
                            <a href="/settings/gplist">
                                    <i class="icon-edit"></i>游戏平台设置</a>
                        </li>
                        <li id="csdept">
                            <a href="/settings/csDept">
                                    <i class="icon-edit"></i>客服部门设置</a>
                        </li>
                        <li id="csacct">
                            <a href="/settings/csAcct">
                                    <i class="icon-edit"></i>客服账号设置</a>
                        </li>
                        <li id="ws">
                            <a href="/settings/ws">
                                    <i class="icon-edit"></i>系统参数设置</a>
                        </li>
                    </ul>
                </li>
                <li id="report">
                    <a href="javascript:;">
                            <i class="icon-pie-chart"></i>
                            <span class="title">报表中心</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="companydaily">
                            <a href="/report/companydaily">
                                    <i class="icon-edit"></i>公司输赢报表</a>
                        </li>
                        <li id="agentdaily">
                            <a href="/report/agentdaily">
                                    <i class="icon-edit"></i>代理输赢日报</a>
                        </li>
                        <li id="platform">
                            <a href="/report/platform">
                                    <i class="icon-edit"></i>游戏输赢汇总</a>
                        </li>
                        <li id="playeractivity">
                            <a href="/report/playeractivity">
                                    <i class="icon-edit"></i>玩家活跃度</a>
                        </li>
                        <li id="arbitrage">
                            <a href="/report/arbitrage">
                                    <i class="icon-edit"></i>套利查询</a>
                        </li>
                    </ul>
                </li>
                <li id="website">
                    <a href="javascript:;">
                            <i class="icon-settings"></i>
                            <span class="title">前台网站配置</span>
                            <span class="arrow"></span>
                        </a>
                    <ul class="sub-menu">
                        <li id="cf">
                            <a href="/website/cf">
                                    <i class="icon-edit"></i>网站信息管理</a>
                        </li>
                        <li id="upload">
                            <a href="/website/upload">
                                    <i class="icon-edit"></i>图片文件上传库</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>