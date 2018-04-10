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
                <td><span class="text"><?php echo e(isset($name) ? $name : ""); ?></span></td>
                    <td><label class="control-label">玩家组:</label></td>
                    <td><span class="text"><?php echo e(isset($layer) ? $layer : ""); ?></span></td>
                </tr>
                <tr>
                    <td><label class="control-label">状态:</label></td>
                    <td><span class="text"><?php echo e(isset($status) ? $status : ""); ?></span></td>
                    <td><label class="control-label">代理编号:</label></td>
                    <td><span class="text "><?php echo e(isset($agentAccount) ? $agentAccount : ""); ?></span></td>
                </tr>
                <tr>
                    <td><label class="control-label">QQ:</label></td>
                    <td><span class="text"><?php echo e(isset($qq) ? $qq : ""); ?></span></td>
                    <td><label class="control-label">手机号:</label></td>
                    <td><span class="text"><?php echo e(isset($cellPhoneNo) ? $cellPhoneNo : ""); ?></span></td>
                </tr>
                <tr>
                    
                    <td><label class="control-label">邮箱:</label></td>
                    <td><span class="text"><?php echo e(isset($email) ? $email : ""); ?></span></td>
                </tr>
                <tr>
                    <td><label class="control-label">注册时间:</label></td>
                    <td><span class="text"><?php echo e(isset($joinTime) ? $joinTime : ""); ?></span></td>
                    <td><label class="control-label">注册IP:</label></td>
                    <td><span class="text"><?php echo e(isset($joinIp) ? $joinIp : ""); ?></span></td>
                </tr>
                <tr>
                    <td><label class="control-label">上次登录日期:</label></td>
                    <td><span class="text"><?php echo e(isset($lastLoginTime) ? $lastLoginTime : ""); ?></span></td>
                    <td inbox=zhh><label class="control-label">主账户余额</label></td>
                    <td inbox=zhh><span class="text"><?php echo e(isset($balance) ? $balance : ""); ?></span></td>
                </tr>
            </table>
            <div id="box_activeinfo"></div>
        </form>
    </div>
</div>