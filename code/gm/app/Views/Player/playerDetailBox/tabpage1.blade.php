<div class="tab-pane active" id="tab_1">
    <div class="portlet-body form">
        <form action="#" id="box_playerdetail" class="horizontal-form">
            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                <thead>
                    <tr>
                        <th colspan="4">玩家信息</th>
                    </tr>
                </thead>
                <tr>
                    <td><label class="control-label">姓名:</label></td>
                <td><span class="text">{{ $name or "" }}</span></td>
                    <td><label class="control-label">玩家组:</label></td>
                    <td><span class="text">{{ $layer or "" }}</span></td>
                </tr>
                <tr>
                    <td><label class="control-label">状态:</label></td>
                    <td><span class="text">{{ $status or "" }}</span></td>
                    <td><label class="control-label">代理编号:</label></td>
                    <td><span class="text ">{{ $agentAccount or "" }}</span></td>
                </tr>
                <tr>
                    <td><label class="control-label">QQ:</label></td>
                    <td><span class="text">{{ $qq or "" }}</span></td>
                    <td><label class="control-label">手机号:</label></td>
                    <td><span class="text">{{ $cellPhoneNo or "" }}</span></td>
                </tr>
                <tr>
                    {{--  <td><label class="control-label">出生日期:</label></td>
                    <td><span class="text">{{ $birthDate or "" }}</span></td>  --}}
                    <td><label class="control-label">邮箱:</label></td>
                    <td><span class="text">{{ $email or "" }}</span></td>
                </tr>
                <tr>
                    <td><label class="control-label">注册时间:</label></td>
                    <td><span class="text">{{ $joinTime or "" }}</span></td>
                    <td><label class="control-label">注册IP:</label></td>
                    <td><span class="text">{{ $joinIp or "" }}</span></td>
                </tr>
                <tr>
                    <td><label class="control-label">上次登录日期:</label></td>
                    <td><span class="text">{{ $lastLoginTime or "" }}</span></td>
                    <td inbox=zhh><label class="control-label">主账户余额</label></td>
                    <td inbox=zhh><span class="text">{{ $balance or "" }}</span></td>
                </tr>
            </table>
            <div id="box_activeinfo"></div>
        </form>
    </div>
</div>