<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>当前在线玩家（online:
                    <span id="playerTotal"> {{ $onlineCount or 0 }}</span>）
                </div>
            </div>
            <div class="portlet-body">
                <form action="/player/onlineAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                            <option value="account">账号</option>
                            <option value="name">姓名</option>
                            <option value="lastLoginIp">最后登录IP</option>
                            <option value="agentName">代理</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                            搜索 &nbsp;
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>代理</th>
                            <th>玩家组</th>
                            <th>主账户余额</th>
                            <th>月游戏输赢</th>
                            <th>成本占用</th>
                            <th>取款流水限制</th>
                            <th>备注</th>
                            <th>本次登录时间/IP</th>
                            <th>注册时间/IP</th>
                            <th>登录渠道</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>