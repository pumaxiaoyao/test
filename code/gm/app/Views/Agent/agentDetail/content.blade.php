<h3 class="form-section">
    玩家信息</h3>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <tr>
        <td>账号：</td>
        <td align="left">{{ $account or ""}}</td>
        <td>姓名：</td>
        <td id="td_realname">{{ $name or ""}}</td>
        <td>邮箱：</td>
        <td id="td_email">{!! $email or "" !!}</td>
        <td>代理代码：</td>
        <td>{{ $agentCode or ""}}</td>
        <td>代理层级：</td>
        <td>{{ $agentLevel or ""}}</td>
        <td>所属一级代理：</td>
        <td>{{ $belongTo1st or ""}}</td>
        <td>所属二级代理：</td>
        <td>{{ $belongTo2rd or ""}}</td>
    </tr>
    <tr>
        <td>注册时间：</td>
        <td>{{ $regTime or ""}}</td>
        <td>注册IP：</td>
        <td>{{ $regIp or ""}}</td>
        <td>上次登录日期：</td>
        <td>{{ $lastLoginTime or "" }}</td>
        <td>状态：</td>
        <td>{{ $status or "" }}</td>
        <td>手机号</td>
        <td id="td_mobile">{{ $cellPhoneNo or ""}}</td>
        <td>QQ：</td>
        <td id="td_qq">{{ $qq or ""}}</td>
        <td></td>
    </tr>
</table>
<div>
    <h3>合营链接</h3>
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <tbody>
            {!! $domainInfo or "" !!}
        </tbody>
    </table>
</div>