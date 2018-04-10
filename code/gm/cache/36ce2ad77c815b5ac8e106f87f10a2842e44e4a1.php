<?php if(count($domains) > 0): ?> <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $_domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td style="cursor:hand;text-align: left;">
        <font style=color:red;><?php echo e($_domain["domain"]); ?></font>
    </td>
</tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php else: ?>
<tr>
    <td style=\ "cursor:hand;text-align: left;\">无数据</td>
</tr>
<?php endif; ?>