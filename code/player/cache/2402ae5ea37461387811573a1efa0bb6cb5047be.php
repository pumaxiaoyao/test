<div class="nr_history_right">
    <div class="as_bet_zz">
        <div class="as_bet_zz_title">
            <h3>交易记录
                <b>| 只显示近一个月的消息,如需更多信息请联系客服查询</b>
            </h3>
            <span>交易类型：
                    <a id="history_Deposit" onclick="searchHistory('Deposit',historyTime)">存款</a>
                    <a id="history_Withdrawal" onclick="searchHistory('Withdrawal',historyTime)">提款</a>
                    <a id="history_Transfer" onclick="searchHistory('Transfer',historyTime)">转账</a>
                    <a id="history_Adjustment" onclick="searchHistory('Adjustment',historyTime)">红利</a>
                    <a id="history_All" onclick="searchHistory('All',historyTime)">全部</a>
                </span>
            <span>选择日期：
                    <a id="history_today" onclick="searchHistory(historyType,'today')">今天</a>
                    <a id="history_3day" onclick="searchHistory(historyType,'3day')">三天内</a>
                    <a id="history_week" onclick="searchHistory(historyType,'week')">一周内</a>
                    <a id="history_month" onclick="searchHistory(historyType,'month')">一个月内</a>
                </span>
        </div>
        <div class="as_bet_zz_table">
            <table>
                <tr>
                    <th>序号</th>
                    <th width="17%">时间</th>
                    <th width="17%">订单号</th>
                    <th>交易类型</th>
                    <th>金额</th>
                    <th width="10%">状态</th>
                </tr>
                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="ms_table_row">
                    <td><?php echo e($record["id"]); ?></td>
                    <td><?php echo e($record["time"]); ?></td>
                    <td><?php echo e($record["dno"]); ?></td>
                    <td><?php echo e($record["optype"]); ?></td>
                    <td><?php echo e($record["amount"]); ?></td>
                    <td><?php echo e($record["status"]); ?></td>
                </tr>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

            </table>
        </div>
    </div>
</div>
</div>
</div>
