<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>活动审核管理 </div>
                <div class="actions">
                    <button id="batchPass" class="btn btn-sm green table-group-action-submit">批量审核</button>
                    <button onclick="if(confirm('确定要拒绝这些申请吗？拒绝后将无法恢复.')){refuseAll();}" type="button" id="s_submit" class="btn btn-sm red table-group-action-submit">
                批量拒绝            </button>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/activity/activityVerifyAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="actid" id="actid" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                            <option value="0">所有活动</option>
                                    </select>
                        <select name="type" id="type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                            <option value="0">所有类型</option>
                                            <?php $__currentLoopData = $actTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($_type["id"]); ?>"><?php echo e($_type["name"]); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                    搜索 &nbsp; <i class="fa fa-search"></i>
                </button>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectall"></th>
                            <th>序号</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>代理</th>
                            <th>申请活动名称</th>
                            <th>活动类型</th>
                            <th>申请时间</th>
                            <th>申请状态</th>
                            <th style="width:150px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="refuseModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" onclick="freetask();">×</button>
                        <h3>拒绝活动申请</h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">备注</label>
                                <input type="text" id="refusedealremark" class="form-control" value="客服拒绝" placeholder="请认真填写拒绝的理由">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary red" onclick="refuse(this);">拒绝</button>
                        <button class="btn" data-dismiss="modal" onclick="freetask();" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="passModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" onclick="freetask();">×</button>
                        <h3 id="myModalLabel">活动审核管理</h3>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="horizontal-form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="form-section">调整红利金额</h4>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">加减</label>
                                            <select class="form-control" id="atype">
                                        <option value="1">+</option>
                                        <option value="2">-</option>
                                    </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">调整红利金额</label>
                                            <input type="text" id="ja" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">选择玩家存款</label>
                                            <select class="form-control" id="cc">
                                    </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">确认存款额</label>
                                            <input type="text" id="amount" readonly value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="form-section">
                                            <hr> 调整取款流水条件 </h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">取款流水倍数</label>
                                            <input type="text" id="jb" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">确认</label>
                                            <input type="text" id="jc" readonly value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">加减</label>
                                            <select class="form-control" id="jj">
                                        <option value="2">-</option>
                                        <option value="1">+</option>
                                    </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">数值</label>
                                            <input type="text" id="jz" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">确认</label>
                                            <input type="text" readonly id="jv" value="0" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">红利流水限平台</label>
                                            <select class="form-control" id="gpid">
                                                <option value="0">不限平台</option>
                                                <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GPID => $GPNAME): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($GPID); ?>"> <?php echo e($GPNAME); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">备注</label>
                                            <input type="text" id="passremark" class="form-control" placeholder="请认真填写" value="客服通过">
                                        </div>
                                    </div>
                                </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary green" onclick="pass(this);">确认</button>
                            <button class="btn" data-dismiss="modal" onclick="freetask();" aria-hidden="true">取消</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="batchPassModal" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal">×</button>
                            <h3 id="myModalLabel">批量审核</h3>
                        </div>
                        <div class="modal-body">
                            <form action="#" class="horizontal-form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="form-section">调整红利金额</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">加减</label>
                                                <select class="form-control" calc="calc" id="atype1">
                                        <option value="1">+</option>
                                        <option value="2">-</option>
                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">红利金额</label>
                                                <input type="text" id="ja1" calc="calc" value="0" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="form-section">
                                                <hr> 调整取款流水条件 </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">取款流水倍数</label>
                                                <input type="text" id="jb1" calc="calc" value="1" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">确认</label>
                                                <input type="text" id="jc1" calc="calc" readonly value="0" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">加减</label>
                                                <select class="form-control" calc="calc" id="jj1">
                                        <option value="2">-</option>
                                        <option value="1">+</option>
                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">数值</label>
                                                <input type="text" id="jz1" calc="calc" value="0" class="form-control" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">确认</label>
                                                <input type="text" readonly calc="calc" id="jv1" value="0" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">红利流水限平台</label>
                                                <select class="form-control" id="gpid1">
                                                                                    <option
                                                value="0">不限平台</option>
                                                                                    <option
                                                value="350808494186211">BB视讯</option>
                                                                                    <option
                                                value="350808494186212">BB彩票</option>
                                                                                    <option
                                                value="350808494186213">BB3D</option>
                                                                                    <option
                                                value="350808494186214">BB机率</option>
                                                                                    <option
                                                value="387122175998732">AG电游</option>
                                                                                    <option
                                                value="387122175998733">AG捕鱼</option>
                                                                                    <option
                                                value="8246252097638400">沙巴体育</option>
                                                                                    <option
                                                value="11964220589608960">MG电游</option>
                                                                                    <option
                                                value="350808494186210">BB体育</option>
                                                                                    <option
                                                value="9283948292830">欧博真人</option>
                                                                                    <option
                                                value="7821359015601">蚂蚁彩票</option>
                                                                                    <option
                                                value="420987656202">newPT电游</option>
                                                                                    <option
                                                value="520723134101">KG</option>
                                                                                    <option
                                                value="550123423101">IM捕鱼</option>
                                                                                    <option
                                                value="550223423201">IM电子</option>
                                                                                    <option
                                                value="773562192801">申博真人</option>
                                                                                    <option
                                                value="773562192802">申博老虎机</option>
                                                                                    <option
                                                value="940256904101">新EBet</option>
                                                                                    <option
                                                value="7589283920390">双赢彩票</option>
                                                                                    <option
                                                value="38712217599873024">AG真人</option>
                                                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">备注</label>
                                                <input type="text" id="batchPassRemark" class="form-control" placeholder="请认真填写" value="客服批量处理">
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary green" onclick="batchPass(this);">确认</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->

    </div>
    <!-- END CONTAINER -->