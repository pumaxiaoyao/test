<div class="as_fl20_right">
    <div class="as_bet_zz">
        <div class="as_bet_zz_title">
            <h3>投注记录<b>| 每个产品的数据将有一定时间的延迟，仅供参考使用</b></h3>
            <span>选择日期：
            <a id="history_today"  onclick="searchHistory('today','')">今天</a>
            <a id="history_3day" onclick="searchHistory('3day','')" >三天内</a>
            <a id="history_week" onclick="searchHistory('week','')" >一周内</a>
            <a id="history_month" onclick="searchHistory('month','')" >一个月内</a>
        </span>
        </div>
        <div class="as_bet_zz_table">
            <table>
                <tr>
                    <th>产品</th>
                    <th>笔数</th>
                    <th>投注流水</th>
                    <th>输赢</th>
                </tr>
                <?php
                    $totalCounts = 0;
                    $totalAmount = 0;
                    $totalResult = 0;
                ?>
                <?php $__currentLoopData = $BetRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gpId=>$_record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $totalCounts += (int)$_record["data"]["count"];
                $totalAmount += (float)$_record["data"]["stake"];
                $totalResult += (float)$_record["data"]["winLose"];
                ?>
                <tr>
                    <td><?php echo e($_record["name"]); ?></td>
                    <td class="blue"><a onclick="searchHistory('','<?php echo e($gpId); ?>')"><?php echo e($_record["data"]["count"]); ?></a></td>
                    <td><?php echo e($_record["data"]["stake"]); ?></td>
                    <td>
                        <?php if($_record["data"]["winLose"] > 0): ?>
                            <span class="green"><?php echo e($_record["data"]["winLose"]); ?></span> 
                        <?php else: ?>
                            <span class="red"><?php echo e($_record["data"]["winLose"]); ?></span> 
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr class="total">
                    <td>总计</td>
                    <td><?php echo e($totalCounts); ?></td>
                    <td><?php echo e($totalAmount); ?></td>
                    <td>
                        <?php if($totalResult > 0): ?>
                            <span class="green"><?php echo e($totalResult); ?></span> 
                        <?php else: ?>
                            <span class="red"><?php echo e($totalResult); ?></span> 
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</div>