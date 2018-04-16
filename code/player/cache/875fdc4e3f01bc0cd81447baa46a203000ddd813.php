<div class="promotions_main">
        <div class="m_ad">
            <?php if(count($headActs) == 0 && count($nomarlActs) == 0): ?>  
            <div class="flex-center full-height">
                    抱歉，暂无可参与的活动！感谢您的关注！
            </div>
            <?php endif; ?>
            <?php if(count($headActs)>0): ?>

            <div class="mi_banner_img">
                <a>
                    <div class="m_logo" style="background-position-y: -60px;"></div>
                </a>
                <?php $__currentLoopData = $headActs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bannerp hidd" view_banner="<?php echo e($loop->index); ?>" 
                        <?php if($loop->first): ?>
                            banner_crt="1" style="display: block; opacity: 1; background:url(<?php echo e($headact["picUrl2"]); ?>)">
                        <?php else: ?>
                            banner_crt="0" style="display: none; opacity: 0; background:url(<?php echo e($headact["picUrl2"]); ?>)">
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mi_banner_ctrl">
                <?php $__currentLoopData = $headActs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mikc_icon  
                    <?php if($loop->first): ?> 
                        mi_select 
                    <?php elseif($loop->count < 3): ?>
                        mikc_icon_middle
                    <?php elseif($loop->last): ?>
                        last
                    <?php else: ?>
                        mikc_icon_middle
                    <?php endif; ?>" onclick="changeImg(<?php echo e($loop->index); ?>,'banner')" banner_ctrl="<?php echo e($loop->index); ?>"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="p_m_content">
                <?php if(count($nomarlActs) > 0): ?>
            <div class="p_m_type">
                <div class="p_m_type_line">
                </div>
            </div>
            <div class="p_m_list">
                <?php $__currentLoopData = $nomarlActs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if((($loop->index) % 2) == 0): ?>
                    <div class="p_m_list_row">
                        <div class="p_m_list_row_left">
                            <div class="p_m_list_box">
                                <div class="p_m_list_box_title"><?php echo e($act["name"]); ?>

                                    <?php if($act["isActive"] == 1): ?> 
                                    <a href="javascript:joinActivity(<?php echo e($act["id"]); ?>)" class="p_m_list_box_btn">立即申请</a>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="p_m_list_box_msg" onclick="showMessage(<?php echo e($act["id"]); ?>)">
                                    <div class="p_m_list_box_resume"><?php echo e($act["desc"]); ?></div>
                                    <img class="p_m_list_box_img" src="<?php echo e($act["picUrl1"]); ?>"/>
                                </div>
                            </div>
                            <div class="p_m_list_row_left_timebox">
                                <div class="p_m_list_row_left_time"><?php echo $act["listTime"]; ?></div>
                                <img class="p_m_list_row_left_across" src="/static/img/promotions/line_03.png" />
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p_m_list_row_right">
                                <div class="p_m_list_box">
                                    <div class="p_m_list_box_title"><?php echo e($act["name"]); ?>

                                        <?php if($act["isActive"] == 1): ?> 
                                        <a href="javascript:joinActivity(<?php echo e($act["id"]); ?>)" class="p_m_list_box_btn">立即申请</a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p_m_list_box_msg" onclick="showMessage(<?php echo e($act["id"]); ?>)">
                                        <div class="p_m_list_box_resume"><?php echo e($act["desc"]); ?></div>
                                        <img class="p_m_list_box_img" src="<?php echo e($act["picUrl1"]); ?>"/>
                                    </div>
                                </div>
                            <div class="p_m_list_row_right_timebox">
                                <div class="p_m_list_row_right_time"><?php echo $act["listTime"]; ?></div>
                                <img class="p_m_list_row_right_across" src="/static/img/promotions/line02_03.png" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>  
</div>