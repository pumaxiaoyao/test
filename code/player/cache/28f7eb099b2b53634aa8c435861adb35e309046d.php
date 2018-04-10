<?php $__currentLoopData = $historyRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($_history["account"]); ?></td>
        <td><?php echo e($_history["dno"]); ?></td>
        <td><?php echo $_history["time"]; ?></td>
        <td><?php echo $_history["content"]; ?></td>
        <?php if( $_history["winloss"] > 0): ?> 
            <td class='green'>赢</td>
            <td><?php echo e($_history["amount"]); ?></td>
            <td class='green'><?php echo e($_history["winloss"]); ?></td>
        <?php else: ?>
            <td class='red'>输</td>
            <td><?php echo e($_history["amount"]); ?></td>
            <td class='red'><?php echo e($_history["winloss"]); ?></td>
        <?php endif; ?>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>