
    <div class="page-content-wrapper">
            <div class="page-content" id="a_pageContent">
                
    <div class="content">
        <div class="layout">
            <div>
                <form class="form" method="get" action="/report/agentDaily">
                    <input type="text" name="agentname"  placeholder="代理"
                           value=""/>
                    <label>开始时间</label>
                    <input type="text" name="start" id="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                value="<?php echo e($startDate); ?>"/>
                    <label>结束时间</label>
                    <input type="text" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                value="<?php echo e($endDate); ?>"/>
                    <input type="submit" class="btn-sub" value="查找"/>
                </form>
            </div>
            <div style="padding-top: 10px;">
                <p style="color: red;">注：此报表数据每15分钟自动更新一次。存（取）款额，包含客服手工添加存（取）款金额以及玩家存（取）款操作金额。<br />每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！            </p>
            </div>
            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                <thead>
                <tr>
                    <th>代理</th>
                    <th>注册数</th>
                    <th>登录数</th>
                    <th>存款数</th>
                    <th>首存数</th>
                    <th>首存额</th>
                    <th>存款额</th>
                    <th>取款额</th>
                    <th>投注额</th>
                    <th>公司输赢</th>
                    <th>红利</th>
                    <th>返水</th>
                    <th>存款优惠</th>
                    <th>公司收入</th>
                    <th>更新时间</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $statics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                        <td><?php echo e($data["account"]); ?></td>
                        <td><?php echo e($data["joinCount"]); ?></td>
                        <td><?php echo e($data["loginCount"]); ?></td>
                        <td><?php echo e($data["depositTimes"]); ?></td>
                        <td><?php echo e($data["firstDepositTimes"]); ?></td>
                        <td><?php echo e($data["firstDepositAmount"]); ?></td>
                        <td><?php echo e($data["depositAmount"]); ?></td>
                        <td><?php echo e($data["withdrawalAmount"]); ?></td>
                        <td><?php echo e($data["stakeAmount"]); ?></td>
                        <td><?php echo e($data["winLoseAmount"]); ?></td>
                        <td><?php echo e($data["bonusAmount"]); ?></td>
                        <td><?php echo e($data["rebateAmount"]); ?></td>
                        <td><?php echo e($data["depositBonusAmount"]); ?></td>
                        <td>0</td>
                        <td><?php echo e(date("Y-m-d H:i:s", $data["updateTime"])); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

                
            </table>
        </div>
    </div>        </div>
        </div>
        <!-- END CONTENT -->
    
    </div>
    <!-- END CONTAINER -->
    
    