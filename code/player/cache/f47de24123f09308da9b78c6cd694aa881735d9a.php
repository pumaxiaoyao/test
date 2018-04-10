<div class="nr_history_right">
        <div class="tk_all_moeny">
            <ul>
                <?php $__currentLoopData = $GPS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ID=>$NAME): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                    <span><?php echo e($NAME); ?></span>
                        <p id="<?php echo e($ID); ?>_balace">
                            <img src="/static/img/loading.gif" />
                        </p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="tk_nr zz_nr">
            <div class="tk_title">
                <h3>转账</h3>
                <span>产品钱包和产品钱包之间不能进行互转，请先转入中心钱包后再转到需要转入的产品钱包。</span></div>
            <div class="tk_box">
                <div class="zz_nr-pic"></div>
                <div class="tk_jr">
                    <span class="text">转出钱包：</span><span class="input">
                        <select id="source-transfer" class="r_inptut inputwd300" name="source-transfer">
                                <option value="MAIN">中心钱包</option>
                                <?php $__currentLoopData = $GPS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ID=>$NAME): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ID); ?>"><?php echo e($NAME); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </span>
                </div>
                <div class="tk_yh">
                    <span class="text">转入钱包：</span><span class="input">
                        <select id="desc-transfer" class="r_inptut inputwd300" name="desc-transfer">
                            <option value="">请选择</option>
                            <option value="MAIN">中心钱包</option>
                            <?php $__currentLoopData = $GPS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ID=>$NAME): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ID); ?>"><?php echo e($NAME); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </span>
                </div>
                <div class="tk_yh"><span class="text">　　金额：</span> <span class="input">
                    <input name="ctl01" type="number" id="transferMoney" placeholder="金额" class="r_inptut inputwd300"></span></div>
                <div>
                    <button type="button" id="transfer_submit" class="as_but inputwd300">立即转账</button></div>
            </div>
        </div>
    </div>
</div>
</div>
