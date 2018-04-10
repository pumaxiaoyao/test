<?php $__currentLoopData = $wdHistoryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td>
        <?php echo e($_history["time"]); ?>

    </td>
    <td>
        <?php echo e($_history["dno"]); ?>

    </td>
    <td>
        <?php echo e($_history["amount"]); ?>

    </td>
    <td>
        <?php echo e($_history["wdfee"]); ?>

    </td>
    <td>
        <?php echo e($_history["applyAmount"]); ?>

    </td>
    <td>
        <?php echo e($_history["checkStatus"]); ?>

    </td>
    <td>
        <?php echo e($_history["note"]); ?>

    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>