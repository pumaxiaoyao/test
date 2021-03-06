<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>代理域名 </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green" href="#addDomainModal" data-toggle="modal"> 添加独立域名 </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <form action="/agent/domainAjax" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <select name="type" id="type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                                <option value="name">账号</option>
                                <option value="domain">绑定域名</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <input name="keyword" id="keyword" type="text" value="" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-s green">
                                搜索 &nbsp;
                                <i class="fa fa-search"></i>
                            </button>
                    </div>
                    <hr>
                </form>
                <table id="data" class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>代理账号</th>
                            <th>代理代码</th>
                            <th>绑定域名</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- add Domain Modal -->
        <div class="modal fade" id="addDomainModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">添加独立域名</h3>
                    </div>
                    <div class="modal-body">
                        <form id="addDomain" method="post" action="/agent/addDomain">
                            <p>代理账号:
                                <input id="agent" name="agent" class="m-wrap small" value="">
                                <span style="color: #ff0000; " id="agentInfo">请填写代理账号</span>
                            </p>
                            <p>独立域名:
                                <input id="domain" name="domain" class="m-wrap small" value="">
                                <span style="color: #ff0000; " id="domainInfo">请填写完整域名，如（www.baidu.com或者baidu.com,泛域名请输入 *.baidu.com）,不要http://</span>
                            </p>
                        </form>
                        <p style="color: #ff0000; ">note:
                            <br> 1、运营商在此处首先添加需要绑定的域名,如需要分配多个推广域名，需要绑定多个。
                            <br> 2、添加成功之后，将此域名提交给奇迹在线客服；
                            <br> 3、将该域名的ns地址修改成奇迹指定的地址；
                            <br> 4、等待奇迹客服协助完成代理独立域名的绑定生效。
                            <br> 5、优先匹配二级域名和根域名，若无法找到才匹配泛域名（泛域名包含根域名）。
                            <br> 注意：不能随意修改绑定域名的ns地址，一旦修改绑定将失效！
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="save">保存</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- update Domain Modal -->
        <div class="modal fade" id="updateDomainModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="title"></h3>
                    </div>
                    <div class="modal-body">
                        <form id="updateDomain" action="/agent/updateDomain">
                            <input id="domainId" name="domainId" type="hidden" value="">
                            <input id="status" name="status" type="hidden" value="">
                            <input id="param" name="param" type="hidden" value="">
                        </form>
                        <p style="color: #ff0000; " id="info"></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary green" id="save">确认</button>
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