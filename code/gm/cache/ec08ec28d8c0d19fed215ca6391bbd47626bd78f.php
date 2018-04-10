<form action="/player/fundFlowAjax" id="s_search" class="form-inline" style="text-align:right;">
    <div class="form-group">
    <input type="text" name="act_StartTime" id="act_StartTime" value="<?php echo e($startTime); ?>"
               class="form-control input-inline input-small input-sm datepicker"
               placeholder="开始时间">
    </div>
    <div class="form-group">
    <input type="text" name="act_EndTime" id="act_EndTime" value="<?php echo e($endTime); ?>"
               class="form-control input-inline input-small input-sm datepicker"
               placeholder="结束时间">
    </div>
    <div class="form-group">
        <button type="button" id="act_Search" class="btn btn-sm green table-group-action-submit">
            搜索 &nbsp; <i class="fa fa-search"></i>
        </button>
    </div>
</form>
<br/>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <tr>
        <th>返水</th>
        <th>红利</th>
        <th>存款优惠</th>
        <th>投注</th>
        <th>派彩</th>
        <th>公司输赢</th>
        <th>有效投注</th>
        <th>公司收入</th>
    </tr>
   <tr>
       <td> <?php echo e(isset($rebate) ? $rebate : ""); ?></td>
       <td> <?php echo e(isset($bonus) ? $bonus : ""); ?></td>
       <td> <?php echo e(isset($depositBonus) ? $depositBonus : ""); ?></td>
       <td> <?php echo e(isset($stake) ? $stake : ""); ?></td>
       <td> <?php echo e(isset($win) ? $win : ""); ?></td>
       <td style='color=red'> <?php echo e(isset($companyWinLose) ? $companyWinLose : ""); ?></td>
       <td> <?php echo e(isset($validBet) ? $validBet : ""); ?></td>
       <td style='color=red'> <?php echo e(isset($companyIncome) ? $companyIncome : ""); ?></td>
   </tr>
</table>
<br/>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <tr>
        <th>存款次数</th>
        <th>存款金额</th>
        <th>最近存款</th>
        <th>取款次数</th>
        <th>取款金额</th>
        <th>最近取款</th>
    </tr>
    <tr>
        <td> <?php echo e(isset($depositTimes) ? $depositTimes : ""); ?></td>
        <td> <?php echo e(isset($depositAmount) ? $depositAmount : ""); ?></td>
        <td> <?php echo e(isset($lastDepositTime) ? $lastDepositTime : ""); ?></td>
        <td> <?php echo e(isset($withdrawalTimes) ? $withdrawalTimes : ""); ?></td>
        <td> <?php echo e(isset($withdrawalAmount) ? $withdrawalAmount : ""); ?></td>
        <td> <?php echo e(isset($lastWithDrawalTime) ? $lastWithDrawalTime : ""); ?></td>
    </tr>
</table>

<script type="text/javascript">
    $('#act_StartTime').datetimepicker({
        showSecond: true,
        showMillisec: false,
        timeFormat: 'yyyy-mm-dd hh:ii:ss'
    });
    $('#act_EndTime').datetimepicker({
        showSecond: true,
        showMillisec: false,
        timeFormat: 'yyyy-mm-dd hh:ii:ss'
    });

    $("#act_Search").on('click', function () {
        console.log($('#act_StartTime').val());
        console.log($('#act_EndTime').val());
        $.get("/player/playerActiveTable?uid=" + box_playerid + "&start=" + $('#act_StartTime').val() + "&end=" + $('#act_EndTime').val(), function (data) {
            $('#box_activeinfo').html(data);
        });
    });
</script>