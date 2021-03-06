<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>代理结算历史 </div>
			</div>
			<div class="portlet-body">
				<form action="/agentfund/settleHistoryList" id="s_search" class="form-inline" style="text-align:right;">
					<input type="text" name="agentname" placeholder="代理" />
					<button type="submit" id="s_submit" class="btn btn-s green">
						搜索 &nbsp;
						<i class="fa fa-search"></i>
					</button>&nbsp;&nbsp;
				</form>
				<table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
					<thead>
						<tr>
							<th>结算月</th>
							<th>一级代理</th>
							<th>二级代理</th>
							<th>三级代理</th>
							<th>代理层级</th>
							<th>有效会员</th>
							<th>游戏平台佣金</th>
							<th>成本分摊</th>
							<th>累加上月</th>
							<th>手工调整</th>
							<th>调整备注</th>
							<th>本期佣金</th>
							<th>实际发放</th>
							<th>结转下月</th>
							<th>结转备注</th>
							<th>审核状态</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="DetailModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>游戏平台佣金</h3>
					</div>
					<div class="modal-body" id="detial">
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="CbDetailModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>成本分摊</h3>
					</div>
					<div class="modal-body" id="detial">

						<table class="table table-striped table-bordered table-hover table-full-width">
							<thead>
								<tr>
									<th>项目</th>
									<th>合计值</th>
									<th>比例</th>
									<th>结果</th>
								</tr>
							</thead>
							<tbody>
								<tr item=a>
									<td>存款优惠</td>
									<td item=a></td>
									<td item=b></td>
									<td item=c></td>
								</tr>
								<tr item=b>
									<td>红利</td>
									<td item=a></td>
									<td item=b></td>
									<td item=c></td>
								</tr>
								<tr item=c>
									<td>返水</td>
									<td item=a></td>
									<td item=b></td>
									<td item=c></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
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