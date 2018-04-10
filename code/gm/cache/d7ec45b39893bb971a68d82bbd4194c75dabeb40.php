<form action="#" class="form-horizontal" id="playerlistmodel">
    <div class="control-group">
        <label class="control-label">关键词</label>
        <div class="controls">
            <div class="input-group">
                <input type="text" class="form-control" id="iptPlayerList" placeholder="用户ID">
                <span id="btnSearchPlayer" class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">搜索到的用户：</label>
            <div class="controls">
                <select id="setPlayerList" class="form-control" tabindex="1">
                    <?php $__currentLoopData = $roleDatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($requestKey === "" || strpos($role["account"], $requestKey) !== false): ?>
                            <option value="<?php echo e($role["name"]); ?>"><?php echo e($role["account"]); ?> - <?php echo e($role["name"]); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
</form>
