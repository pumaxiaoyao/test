<div class="nr_history_right">
    <div class="tk_nr">
        <div class="tk_title">
            <h3>提款</h3><span>通常您的提款只需3-15分钟即可到账，若超过30分钟仍未到账，请联系在线客服核查。</span></div>
        <div class="tk_box">
            <div class="tk_jr"><span class="text">提款金额：</span><span class="input"><input name="ctl01" id="withdrawalMoney" type="number" onKeyUp="amount(this)" onBlur="overFormat(this)" placeholder="金额" class="r_inptut inputwd300" /></span></div>
            <div class="tk_ts"><span id="withdrawalMoney_tips" class="text">最低提款值金额不能低于100元</span></div>
            <div class="tk_yh"><span class="text">选择银行：</span>
                <span class="radio">
                    <!-- <div class="deposit_atmsel_icon_i">         -->
                    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($loop->first): ?>
                    <label style="border: 1px solid #c8cccf; width: 300px" class="on" for="bankradiogroup<?php echo e($card["id"]); ?>" > <input checked
                        <?php else: ?>
                            <label style="border: 1px solid #c8cccf; width: 300px" for="bankradiogroup<?php echo e($card["id"]); ?>" > <input
                        <?php endif; ?>
                            id="bankradiogroup<?php echo e($card["id"]); ?>" type="radio" name="bankradiogroup" value="<?php echo e($card["id"]); ?>"/>
                            <b><?php echo e($card["name"]); ?> <?php echo $card["cardNo"]; ?></b></label>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <!-- </div> -->
                </span>
            </div>
            <div><button type="button" id="withdrawal_submit" class="as_but inputwd300">提交提款</button></div>
        </div>
    </div>
</div>
</div>
</div>