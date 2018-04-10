<?php $__currentLoopData = $validGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value='<?php echo e($group["id"]); ?>'><?php echo e($group["name"]); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>