<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>活动类型管理 </div>
                <div class="actions">
                    <a class="btn green small" id="add_btn" href="javascript:void(0);" data-toggle="modal">创建新类型</a>
                </div>
            </div>
            <div class="portlet-body">
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：请您根据您页面的实际展示情况调整启用个数和类型的文字，建议同时启用的优惠活动类型不超过六个，总体不超过30个字。</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th>类型ID</th>
                            <th>类型名称</th>
                            <th>类型描述</th>
                            <th>创建时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $actTypes as $_type)
                        <tr>
                            <td>{{ $_type["id"] }}</td>
                            <td>{{ $_type["name"] }}</td>
                            <td>{{ $_type["desc"] }}</td>
                            <td>{{ $_type["created_at"] }}</td>
                            <td>
                                @if ($_type["status"] == "1")
                                <span class="label label-success">启用</span> @else
                                <span class="label label-warning">禁用</span> @endif
                            </td>
                            <td>
                                <a edit="edit" href="javascript:void(0);" status="{{ $_type["status"] }}" desc="{{ $_type["desc"]}}" cateId="{{ $_type["id"]}}" name="{{ $_type["name"] }}" class="btn btn-xs green">编辑</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="act_cate_modal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="title">编辑活动类型</h3>
                    </div>
                    <div class="modal-body">
                        <form id="act_cate_form" class="form-horizontal" role="form">
                            <input type="hidden" id="cateId" name="cateId" value="" />

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">类型名称<span class="required">*</span></label>

                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="name" id="name" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">类型描述</label>

                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="desc" id="desc" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">状态<span class="required">*</span></label>

                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <div id="status" class="radio-list">
                                                <label class="radio-inline">
                                                <input type="radio" name="status" checked value="1">启用</label>
                                                <label class="radio-inline">
                                                <input type="radio" name="status" value="2">禁用</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="btn_save">确认</button>
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