<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>代理取款审核 </div>
			</div>
			<div class="portlet-body">
				<form action="/agentfund/wtdVerifyAjax" id="s_search" style="text-align:right;" class="form-inline">
					<div class="form-group">
						<select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
							<option value="account">代理</option>
							<option value="name">姓名</option>
						</select>
					</div>
					<div class="form-group">
						<input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
						/>
					</div>
					<div class="form-group">
						<button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
							搜索 &nbsp;
							<i class="fa fa-search"></i>
						</button>
					</div>
					<hr>
				</form>
				<table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
					<thead>
						<tr>
							<th>单号</th>
							<th>代理</th>
							<th>代理层级</th>
							<th>所属一级代理</th>
							<th>所属二级代理</th>
							<th>姓名</th>
							<th>取款申请</th>
							<th>存款手续费</th>
							<th>出款确认</th>
							<th>申请时间</th>
							<th>出款银行卡</th>
							<th>客服备注</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		<div class="modal fade" id="remarkModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>取款客服备注</h3>
					</div>
					<div class="modal-body">
						<form id="remark_form" class="form-horizontal" role="form">
							<input type="hidden" id="cs_remark_dno" />
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-2 control-label">备注
										<span class="required">*</span>
									</label>
									<div class="col-md-10">
										<div class="input-icon right">
											<textarea id="csremark" style="margin: 0px; width: 450px; height: 100px;"></textarea>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary red" save="save">确认</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="passModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>通过出款申请</h3>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款申请数额</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" readonly id="pamount" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款手续费</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<select name="pfeetype" id="pfeetype" class="form-control" tabindex="1">
										<option value="0">取款手续费由玩家承担</option>
										<option value="1">取款手续费由公司承担</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款手续费比例</label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<select name="pperc" id="pperc" class="form-control" tabindex="1">
										<option value="0">无</option>
										<option value="0.012">1.2%</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<input type="text" readonly id="ppercresult" class="form-control" placeholder="">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select name="jj" id="jj" class="form-control" tabindex="1">
										<option value="1">+</option>
										<option value="2">-</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<input type="text" id="jjnum" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款手续费确认</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" readonly id="pwfee" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款金额确认</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" readonly id="pactual" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">备注</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" id="pdealremark" class="form-control" placeholder="">
								</div>
							</div>
						</div> -->
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary red" onclick="pass(this);">通过</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="bankModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>银行卡出款</h3>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">取款银行</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" readonly id="outBankInfo" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">出款金额确认</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" readonly id="bmactual" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">选择出款银行</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<select class="form-control" id="bmbcid">
										<option value="3012">6217933180066670-上海浦东发展银行-0.0000</option>
										<option value="3013">6214833116622971-中国招商银行-0.0000</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">出款手续费确认</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" id="bmwfee" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">备注</label>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<input type="text" id="bmremark" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary red" onclick="submitWtdBankInfo(this);">通过</button>
							<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="refuseModal" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal">×</button>
							<h3>拒绝出款申请</h3>
						</div>
						<div class="modal-body">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">备注</label>
									<input type="text" id="refusedealremark" class="form-control" placeholder="请认真填写拒绝的理由">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary red" onclick="refuse(this);">拒绝</button>
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