<h3 class="form-section">
    玩家信息</h3>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <tr>
        <td>账号：</td>
        <td align="left"><?php echo e(isset($account) ? $account : ""); ?></td>
        <td>姓名：</td>
        <td id="td_realname"><?php echo e(isset($name) ? $name : ""); ?></td>
        <td>邮箱：</td>
        <td id="td_email"><?php echo isset($email) ? $email : ""; ?></td>
        <td>代理代码：</td>
        <td><?php echo e(isset($agentCode) ? $agentCode : ""); ?></td>
        <td>代理层级：</td>
        <td><?php echo e(isset($agentLevel) ? $agentLevel : ""); ?></td>
        <td>所属一级代理：</td>
        <td><?php echo e(isset($belongTo1st) ? $belongTo1st : ""); ?></td>
        <td>所属二级代理：</td>
        <td><?php echo e(isset($belongTo2rd) ? $belongTo2rd : ""); ?></td>
    </tr>
    <tr>
        <td>注册时间：</td>
        <td><?php echo e(isset($regTime) ? $regTime : ""); ?></td>
        <td>注册IP：</td>
        <td><?php echo e(isset($regIp) ? $regIp : ""); ?></td>
        <td>上次登录日期：</td>
        <td><?php echo e(isset($lastLoginTime) ? $lastLoginTime : ""); ?></td>
        <td>状态：</td>
        <td><?php echo e(isset($status) ? $status : ""); ?></td>
        <td>手机号</td>
        <td id="td_mobile"><?php echo e(isset($cellPhoneNo) ? $cellPhoneNo : ""); ?></td>
        <td>QQ：</td>
        <td id="td_qq"><?php echo e(isset($qq) ? $qq : ""); ?></td>
        <td></td>
    </tr>
</table>
<div>
    <h3>合营链接</h3>
    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
        <tbody>
            <?php echo isset($domainInfo) ? $domainInfo : ""; ?>

        </tbody>
    </table>
</div>