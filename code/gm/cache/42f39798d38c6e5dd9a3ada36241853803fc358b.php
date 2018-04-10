<?php if($ckStatus == 1): ?>
    <?php if($status == 1): ?>
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('<?php echo e($dno); ?>',
    '<?php echo e($amount); ?>','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    <?php elseif($status == 2): ?>
    <a href="#passModal" data-toggle="modal" onclick="passSet('<?php echo e($dno); ?>',
'<?php echo e($amount); ?>','<?php echo e($rname); ?>','<?php echo e($bank); ?>','<?php echo e($card); ?>','<?php echo e($account); ?>');"class="btn btn-xs green"><i class="icon-trash"></i>通过</a>
    &nbsp;
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('<?php echo e($dno); ?>',
    '<?php echo e($amount); ?>','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    <?php elseif($status == 4): ?>
    <a href="#refuseModal" data-toggle="modal" onclick="refuseSet('<?php echo e($dno); ?>',
    '<?php echo e($amount); ?>','0.00','1510375133');" class="btn btn-xs red"><i class="icon-trash"></i>拒绝</a>
    <?php endif; ?>
<?php elseif($ckStatus == 2): ?>{
<a href='#bankModal' data-toggle='modal' onclick='setbankModal('<?php echo e($dno); ?>');' class='btn btn-xs blue'><i class='icon-trash'></i>银行卡出款</a>
<?php endif; ?>