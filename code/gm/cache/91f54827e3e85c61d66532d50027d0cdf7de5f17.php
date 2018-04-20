<span class='label label-info' style='cursor:pointer;' onclick="custom_getAgentModel('<?php echo e($agentId); ?>','<?php echo e($agentAccount); ?>');">
<?php if($type == 1): ?>
    <?php echo e($agentId); ?>

<?php else: ?> 
    <?php echo e($agentAccount); ?>

<?php endif; ?>
</span>