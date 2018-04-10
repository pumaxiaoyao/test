<div class="as_fl20_right">

        <div class="as_fr80">
            <div style="padding:0px 10px;">
                <div id="setting_agentreports_box" class="setting_box_div">
                    <div class="as_bet_zz">
                        <div class="as_bet_zz_title1">
                            <h3>下线代理列表
                                <b>| 管理下线的代理数据。</b>
                                
                                <?php if($lvl < 3): ?>
                                <button onclick="addNewAgent()" style="float:right;" class="addAgentbtn addAgentbtnbg"><span>新增代理</span></button>
                                <?php endif; ?>
                            </h3>
                        </div>
                        <div class="as_bet_zz_table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th width="17%">代理账号</th>
                                        <th width="17%">真实姓名</th>
                                        <th>注册日期</th>
                                        <th>代理层级</th>
                                        <th width="10%">代理编码</th>
                                        <th width="10%">会员总数</th>
                                        <th width="10%">状态</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $agentReportsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(isset($_data["id"]) ? $_data["id"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["account"]) ? $_data["account"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["name"]) ? $_data["name"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["time"]) ? $_data["time"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["layer"]) ? $_data["layer"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["roleId"]) ? $_data["roleId"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["memgberCount"]) ? $_data["memgberCount"] : ""); ?></td>
                                            <td><?php echo e(isset($_data["stag"]) ? $_data["stag"] : ""); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    </div>