<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>存款对账管理 </div>
			</div>
			<div class="portlet-body">
				<form action="/bank/depositAjax" id="s_search" class="form-inline" style="text-align:right;">

					<div class="form-group" style="float: left;">
						<label class="">本页总额：</label><label class="label label-success" id="amount"></label>&nbsp;&nbsp;
						<label>全部总额：</label><label class="label label-success" id="total_amount"></label>
					</div>
					<label class="label label-warning">处理时间</label>
					<div class="form-group">
						<input type="text" name="start" id="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control input-inline input-small input-sm"
						 placeholder="开始时间">
					</div>
					<div class="form-group">
						<input type="text" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control input-inline input-small input-sm"
						 placeholder="结束时间">
					</div>
					<div class="form-group">
						<select id="s_type" name="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
                    <option value="name">账号</option>
                    <option value="card">存入卡号pbm:stcn</option>
                </select>
					</div>
					<div class="form-group">
						<input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
						/>
					</div>
					<div class="form-group">
						<button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                    搜索 &nbsp; <i class="fa fa-search"></i>
                </button>
					</div>
				</form>
				<div style="padding-top: 10px;">
					<p style="color: red;">注：存款额，不包含客服手工添加存款金额。<br />注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
				</div>
				<table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
					<thead>
						<tr>
							<th>系统单号</th>
							<th>账号</th>
							<th>金额</th>
							<th>类型→存入卡号</th>
							<th>申请时间</th>
							<th>支付状态</th>
							<th>处理时间</th>
							<th>支付类型</th>
							<th>存款银行/编号/账户名</th>
							<th>交易号/附言</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->