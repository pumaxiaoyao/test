<?php if($checkStatus == 2): ?>
<a href="#bankModal" data-toggle="modal" onclick="setbankModal('<?php echo e($dno); ?>', '<?php echo e($cardId); ?>');" class="btn btn-xs blue"><i class="icon-trash"></i>银行卡出款</a>
<?php endif; ?>