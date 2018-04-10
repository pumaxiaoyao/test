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
                <form id="activity_edit" method="post" enctype="multipart/form-data" action="/kzb/activity/edit">
                    <input type="hidden" name="actid" value="" />

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">活动名称 <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-10">

                                <div class="form-group">

                                    <input type="text" id="name" name="name" value="" class="form-control" placeholder="">
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
                                    <textarea class="form-control" name="desc" style="height:50px;" id="remark"></textarea>
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
                                    <input type="text" class="form-control" readonly onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo e($todayDate); ?>" name="lbtime">
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
                                    <img id="activityPicShow" src="" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">头条活动  <font color="red"> * </font> </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="radio-list">
                                    <div class="form-group"><select id="headActivity">
                                        <option value="0" selected="selected">非头条活动</option>
                                    </select>
                                    </div>
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
                                    <input id="headActivityPic" name="headActivityPic" type="file" multiple="true">
                                    <label class="control-label">活动图片(图片分辨率:<font color="red">1920 * 366</font>，文件大小2M)</label>
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
                                    <img id="headActivityPicShow" src="" />
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
                                    <label class="radio-inline">
                                        <input type="checkbox" name="group" gpname="不送返水优惠" value="1">不送返水优惠</label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="group" value="2">高级会员</label>
                                    <label class="radio-inline"> 
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
                                    <select id="status_list">
                                        <option value="11" selected="selected">待上架</option>
                                        <option value="22" selected="selected">已上架</option>
                                        <option value="25" selected="selected">已下架</option>
                                        <option value="32" selected="selected">已删除</option>
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
                                    <select id="status_list">
                                        <option value="11" selected="selected">存送</option>
                                        <option value="22" selected="selected">返水送</option>
                                        <option value="25" selected="selected">注册送</option>
                                        <option value="32" selected="selected">其他</option>
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
                                    <select id="redirect_to" onchange="redirectURL(this)">
                                            <option value="11" selected="selected">默认原生优惠页面</option>
                                            <option value="22">跳转至外部链接</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                    
                            </div>
                            <div class="col-md-6 redirect_url_column" style="display: none;">
                                <input type="text" class="form-control" value="" name="redirect_url"> 栏位不能够为空，请填写有关的跳转链接
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
                                    <input type="text" class="form-control" value="0" name="order">
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
                                    <input class="form-control" type="text" value="0" name="peru" id="peru">
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
                            <option
                                value="1" >
                                是                                </option>
                            <option
                                value="0"  selected >
                                否                                </option>
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
                                    <textarea class="form-control" id="editor_id" name="content" style="height:200px;" id="remark"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="agentcodes" id="agentcodes">
                            <input type="hidden" name="groupids" id="groupids">
                            <input type="hidden" name="groupnames" id="groupnames">
                            <input type="hidden" name="agentnamelist" id="agentnamelist">
                            <input type="submit" class="btn btn-primary red" value="保存">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

</div>