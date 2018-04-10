<?php $__currentLoopData = $AgentDomains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td>合营域名</td>
    <td style="float:left;text-align:center"><?php echo e(isset($domain["domain"]) ? $domain["domain"] : ""); ?> </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>