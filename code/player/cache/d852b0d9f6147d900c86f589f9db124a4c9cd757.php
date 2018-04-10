<div class="as_fl20_right">
    <div class="as_bet_email">
        <div class="as_email_title">
            <h3>站内信</h3>
        </div>
        <div class="email_title_box">
            <div id="take_email" class="take_email email_nr" style="display:block">
                <table>
                    <tr>
                        <th width="5%"></th>
                        <th width="20%">时间</th>
                        <th>标题</th>
                        <th width="10%">状态</th>
                    </tr>
                    <?php $__currentLoopData = $recvMails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr value="<?php echo e($email["recordNum"]); ?>" class="ms_table_row">
                            <td></td>
                            <td><?php echo date("Y-m-d H:i:s", $email["recordTime"]); ?></td>
                            <td><a href='javascript:void(0);' onclick="writeMessage(this, '<?php echo e($email["recordNum"]); ?>',1)" ><?php echo e($email["title"]); ?></a></td>
                            <td class="message_isView"><?php echo e($email["messageStatus"] == 1 ? "未读" : "已读"); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($maxPage > 1): ?>
                    <tr><td colspan="5" style="background:#f5f5f5"><span class="page"><strong>
                        <?php for($i = 1; $i < $maxPage + 1; $i++): ?>
                            <?php if($i == $curPage): ?>
                                <strong><span><?php echo e($i); ?></span></strong>
                            <?php else: ?> 
                                <a href="receivebox?pageIndex=<?php echo e($i); ?>"><span><?php echo e($i); ?></span></a>
                            <?php endif; ?>

                            <?php if($i == $maxPage): ?>
                                </strong><a  href="receivebox?pageIndex=<?php echo e($i); ?>" class="nextPage"><span>下一页</span></a></span></td></tr>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <tr>
                        <td colspan="5" style="background:#f5f5f5"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div>
</div>
</div>