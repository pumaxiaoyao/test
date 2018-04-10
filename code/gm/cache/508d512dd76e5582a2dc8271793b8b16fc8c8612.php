<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>网站活动管理 </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <form id="activity_edit" method="post" action="/activity/edit">
                    <input type="hidden" name="actid" value="<?php echo e(isset($act['id']) ? $act['id'] : ''); ?>" />

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动名称 <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-10">

                                <div class="form-group">

                                    <input type="text" id="name" name="name" value="<?php echo e(isset($act['name']) ? $act['name'] : ''); ?>" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动说明  <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <textarea class="form-control" name="desc" style="height:50px;" id="remark"><?php echo e(isset($act['desc']) ? $act['desc'] : ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">标签时间  <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" readonly onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo e(isset($act['labelTime']) ? $act['labelTime'] : $todayDate); ?>"
                                        name="lbtime">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动图片 <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input id="activityPic" name="activityPic" type="file" multiple="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label">活动图片(图片分辨率:<font
                                color="red">640 * 300</font>，文件大小2M)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <img id="activityPicShow" src="<?php echo e(isset($act['picUrl1']) ? $act['picUrl1'] : ''); ?>" />
                                    <input type="hidden" id="picUrl1" name="picUrl1" value="<?php echo e(isset($act['picUrl1']) ? $act['picUrl1'] : ''); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">头条活动  <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-2" id="headActivitySelect">
                                <div class="radio-list">
                                    <div class="form-group">
                                        <select id="headActivity" name="headActivity">
                                            <option <?php if( isset($act['isHeadAct'])?$act['isHeadAct']:0  == 0): ?> selected="selected" <?php endif; ?> value="0" >非头条活动</option>
                                            <option <?php if( isset($act['isHeadAct'])?$act['isHeadAct']:0  == 1): ?> selected="selected" <?php endif; ?> value="1" >头条活动</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="headActivityUpload">
                            <div class="col-md-2">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input id="headActivityPic" name="headActivityPic" type="file" multiple="false">
                                    <label class="control-label">活动图片(图片分辨率:<font color="red">1920 * 366</font>，文件大小2M)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="headActivityShow">
                            <div class="col-md-2">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <img id="headActivityPicShow" src="<?php echo e(isset($act['picUrl2']) ? $act['picUrl2'] : ''); ?>" />
                                    <input type="hidden" id="picUrl2" name="picUrl2" value="<?php echo e(isset($act['picUrl2']) ? $act['picUrl2'] : ''); ?>" />
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">专属代理</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="radio-list">
                                    <div class="form-group">
                                        <select id="selectagent" style="width: 120px">
                                            <option value="0" selected="selected">选择代理</option>
                                        </select>
                                        <input type="button" class="btn green btn-sm" style="margin-left: 5px;" id="addagent" value="添加" /></div>
                                </div>
                            </div>
                            <div class="col-md-6" id="agentlist">
                                <?php $__currentLoopData = explode(',', isset($act['agentCodes'])?$act['agentCodes']:""); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <A href='javascript:void(0);' style='padding:10px;' onclick='$(this).remove();initAgentInfo();' actid='<?php echo e($agent); ?>'>
                                        <i class='fa fa-check-square-o'></i><?php echo e($agent); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">专属玩家层级</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="radio-list">
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="radio-inline">
                                        <input type="checkbox" <?php if(in_array($group["name"], explode(",", isset($act['groupNames'])?$act['groupNames']:""))): ?> checked="checked" <?php endif; ?> name="group" gpname="<?php echo e($group["name"]); ?>" value="<?php echo e($group["id"]); ?>"><?php echo e($group["name"]); ?>

                                    </label> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动状态   <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select id="status_list" name="status_list">
                                        <option value="0" <?php if( (isset($act['status'])?(string)$act['status']:"0") === "0"): ?> selected="selected" <?php endif; ?>>待上架</option>
                                        <option value="1" <?php if( (isset($act['status'])?(string)$act['status']:"0") === "1"): ?> selected="selected" <?php endif; ?>>已上架</option>
                                        <option value="2" <?php if( (isset($act['status'])?(string)$act['status']:"0") === "2"): ?> selected="selected" <?php endif; ?>>已下架</option>
                                        <option value="3" <?php if( (isset($act['status'])?(string)$act['status']:"0") === "3"): ?> selected="selected" <?php endif; ?>>已删除</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动类型   <font color="red"> * </font>  </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select id="type_list" name="type_list">
                                        <?php $__currentLoopData = $actTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_act_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($_act_type["id"]); ?>" <?php if( (isset($act['type_id'])?$act['type_id']:"1") ==  $_act_type["id"] ): ?> selected="selected" <?php endif; ?>><?php echo e($_act_type["name"]); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">跳转方式</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select id="redirect_to" name="redirect_to" onchange="redirectURL(this)">
                                        <option value="1" <?php if( (isset($act['jumpType'])?$act['jumpType']:"1") ==  1): ?> selected="selected" <?php endif; ?>>默认原生优惠页面</option>
                                        <option value="2" <?php if( (isset($act['jumpType'])?$act['jumpType']:"1") ==  2): ?> selected="selected" <?php endif; ?>>跳转至外部链接</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-6 redirect_url_column" style="display: none;">
                                <input type="text" class="form-control" value="<?php echo e(isset($act['jumpUrl']) ? $act['jumpUrl'] : ''); ?>" name="redirect_url">                                栏位不能够为空，请填写有关的跳转链接
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">排序</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="<?php echo e(isset($act['orderVal']) ? $act['orderVal'] : ''); ?>" name="order">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">玩家参与次数（0为不限制）   <font color="red"> * </font>  </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input class="form-control" type="text" value="<?php echo e(isset($act['timesLimit']) ? $act['timesLimit'] : ''); ?>" name="peru" id="peru">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">主动申请    <font color="red"> * </font>  </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <select name="initiative" id="initiative" class="form-control" tabindex="1">
                                        <option value="1"  <?php if( (isset($act['isActive'])?$act['isActive']:"0") ==  1): ?> selected="selected" <?php endif; ?>>是</option>
                                        <option value="0"  <?php if( (isset($act['isActive'])?$act['isActive']:"0") ==  0): ?> selected="selected" <?php endif; ?>>否</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动内容    <font color="red"> * </font>  </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <textarea class="form-control" id="editor_id" name="content" style="height:200px;" id="remark">
                                            <?php echo e(isset($act['content']) ? $act['content'] : ''); ?>

                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="agentcodes" id="agentcodes">
                            <input type="hidden" name="groupids" id="groupids">
                            <input type="hidden" name="groupnames" id="groupnames">
                            <input type="hidden" name="agentnamelist" id="agentnamelist">
                            <input type="submit" class="btn btn-primary red" value="保存">
                            <a href='/activity/activities' class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

</div>