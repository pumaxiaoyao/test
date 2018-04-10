
<?php $__currentLoopData = $gameData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gpName=>$gpData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr><td><?php echo e(isset($gpName) ? $gpName : ""); ?></td>
    <td><?php echo e(isset($gpData["winLoseAmount"]) ? $gpData["winLoseAmount"] : ""); ?></td>
    <td><?php echo e(sprintf($gpName["pumpingCommisionRate"] * 100) or ""); ?></td>
    <td><?php echo e(isset($gpName["pumpingCommisionAmount"]) ? $gpName["pumpingCommisionAmount"] : ""); ?></td>
    <td><?php echo e(isset($gpName["validStakeAmount"]) ? $gpName["validStakeAmount"] : ""); ?></td>
    <td><?php echo e(sprintf($gpName["pumpingWaterRate"] * 100) or ""); ?></td>
    <td><?php echo e(isset($gpName["pumpingWaterAmount"]) ? $gpName["pumpingWaterAmount"] : ""); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<tr><td>小计</td>
    <td><?php echo e($TotalWinLose); ?></td><td></td>
    <td><?php echo e($TotalCommision); ?></td>
    <td><?php echo e($TotalStake); ?></td><td></td>
    <td><?php echo e($TotalWater); ?></td></tr>
<tr><td>平台合计</td>
    <td><?php echo e($TotalCommision); ?></td>
    <td>线路费</td>
    <td><?php echo e($lineChargeRate); ?>%</td>
    <td>代理线佣金</td>
    <td colspan='2'><?php echo e($lineCommision); ?></td></tr>