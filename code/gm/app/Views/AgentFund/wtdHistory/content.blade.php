<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>代理取款历史 </div>
			</div>
			<div class="portlet-body">
				<form action="/agentfund/wtdHistoryAjax" id="s_search" class="form-inline" style="text-align:right;">
					<div class="form-group">
						<select name="" id="s_TimeFli" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
							<option value="ClearDate">不筛选</option>
							<option value="Today">今日</option>
							<option value="Yesterday">昨日</option>
							<option value="LastWeek">上周</option>
							<option value="LastMonth">上月</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="s_StartTime" id="s_StartTime" class="form-control input-inline input-small input-sm datepicker"
					placeholder="开始时间" value="{{ $startTime }}">
					</div>
					<div class="form-group">
					<input type="text" name="s_EndTime" id="s_EndTime" class="form-control input-inline input-small input-sm datepicker" placeholder="结束时间" value="{{ $endTime }}">
					</div>
					<div class="form-group">
						<select name="s_Status" id="s_Status" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
							<option value="0">全部</option>
							<option value="8">成功(银行卡已出款)</option>
							<option value="4">成功(银行卡未出款)</option>
							<option value="1">拒绝</option>
						</select>
					</div>
					<div class="form-group">
						<select name="s_type" id="s_type" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
							<option value="account">账号</option>
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
			</div>
			</form>
			<table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
				<thead>
					<tr>
						<th>代理</th>
						<th>代理层级</th>
						<th>所属一级代理</th>
						<th>所属二级代理</th>
						<th>姓名</th>
						<th>取款申请</th>
						<th>存款手续费</th>
						<th>出款确认</th>
						<th>申请时间</th>
						<th>处理时间</th>
						<th>出款银行卡</th>
						<th>审核状态</th>
						<th>备注</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
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
									<option value="3012" balance="999999">6217933180066670-上海浦东发展银行-0.0000</option>
									<option value="3013" balance="999999">6214833116622971-中国招商银行-0.0000</option>
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
	</div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->