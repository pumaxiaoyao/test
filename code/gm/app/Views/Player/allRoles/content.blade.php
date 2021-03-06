<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>所有玩家列表 </div>
            </div>
            <div class="portlet-body">
                <form action="/player/listAjax1" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group" style="float: left;">
                        <a class="btn btn-sm green table-group-action-submit" href="#" id="batch_layer_btn">批量调层</a>
                        <a class="btn btn-sm green" href="/player/exportmember" target="_blank">导出全部玩家信息</a>
                    </div>
                    <label>玩家组:</label>
                    <select name="groupid" id="groupid">
                            <option value="0">所有组别</option>
                            {{ $GROUPDATA or "" }}
                        </select>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                <option value="account">账号</option>
                                <option value="name">姓名</option>
                                <option value="lastLoginIp">最后登录IP</option>
                                <option value="agentName">代理</option>
                                <option value="email">邮箱</option>
                                <option value="cellPhoneNo">手机号</option>
                                <option value="bankCard">取款银行卡</option>
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
                            <th>
                                <input type="checkbox" value="" id="selAll" />
                            </th>
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
        <input type="hidden" id="__pline" value="3000">