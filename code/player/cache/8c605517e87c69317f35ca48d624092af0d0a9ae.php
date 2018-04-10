<table width="600px;" class="form-t txt-left m-t-20 form-t-4">
    <thead>
        <tr>
            <th rowspan="3">代理账号</th>
            <th colspan="3">存款优惠</th>
            <th colspan="3">红利</th>
            <th colspan="3">返水</th>
        </tr>
        <tr>
            <th>金额</th>
            <th>承担比例</th>
            <th>承担金额</th>
            <th>金额</th>
            <th>承担比例</th>
            <th>承担金额</th>
            <th>金额</th>
            <th>承担比例</th>
            <th>承担金额</th>
        </tr>
        <?php echo e(isset($AgentAllocationData) ? $AgentAllocationData : ""); ?>

    </thead>
    <tbody>
        <?php echo e(isset($ChildAllocationData) ? $ChildAllocationData : ""); ?>

    </tbody>
</table>