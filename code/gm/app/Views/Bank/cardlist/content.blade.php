<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>银行资金明细 </div>
				<div class="actions">
					<a href="#addCardMmTransfer" data-toggle="modal" onclick="startSelect();" class="btn green">
                手工添加银行转账记录 </a>
				</div>
			</div>
			<div class="portlet-body">
				<form action="/bank/cardListAjax" id="s_search" class="form-inline" style="text-align:right;">
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
						<input type="text" name="s_StartTime" id="s_StartTime" value='2017-10-13 00:00:00' class="form-control input-inline input-small input-sm datepicker"
						 placeholder="开始时间">
					</div>
					<div class="form-group">
						<input type="text" name="s_EndTime" id="s_EndTime" value='2017-10-13 23:59:59' class="form-control input-inline input-small input-sm datepicker"
						 placeholder="结束时间">
					</div>
					<div class="form-group">
						<select class="table-group-action-input form-control input-small input-sm" tabindex="1" id="bcid" name="bcid">
                    <option value="">选择银行卡</option>
                                            <option value="3000">智付3.0-卡尼奥普-卡尼奥普                            -949087.5700</option>
                                            <option value="3002">微信支付-LY-依儿-lo**                            -260644.1300</option>
                                            <option value="3005">支付宝-QQ微信支付宝扫码-888888                            -656032.5300</option>
                                            <option value="3008">中国农业银行-用于旧路易会员转移额度至新路易-000000000                            -9506.6100</option>
                                            <option value="3009">上海浦东发展银行-王轶兵-6217933180010298                            -348895.9200</option>
                                            <option value="3010">中国招商银行-王轶兵-6214834316226456                            -3821735.9600</option>
                                            <option value="3011">速汇宝-i12-6000016833                            -3737.0000</option>
                                            <option value="3012">上海浦东发展银行-李想-6217933180066670                            -0.0000</option>
                                            <option value="3013">中国招商银行-徐立洋-6214833116622971                            -0.0000</option>
                                            <option value="3014">中国建设银行-张增有-6236683140002095158                             -629830.0000</option>
                    
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
				<br/>
				<div class="note note-success">
					<div>
						<label>当前页统计：</label>
						<label>收入：</label><label class="label label-success" id="pageIn"></label>
						<label>支出：</label><label class="label label-success" id="pageOut"></label>
					</div>
					<div style="padding-top: 10px;">
						<label>搜索结果统计：</label>
						<label>收入：</label><label class="label label-success" id="totalIn"></label>
						<label>支出：</label><label class="label label-success" id="totalOut"></label>
					</div>
				</div>
				<div style="padding-top: 10px;">
					<p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
				</div>
				<table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
					<thead>
						<tr>
							<th>序号</th>
							<th>公司银行卡</th>
							<th>类型</th>
							<th>来源</th>
							<th>交易时间</th>
							<th>交易金额</th>
							<th>余额</th>
							<th>交易对象</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="addCardMmTransfer" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal">×</button>
						<h3>手工添加银行转账记录</h3>
					</div>
					<div class="modal-body">
						<form action="#" class="horizontal-form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group"><label class="control-label">转账类型</label></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><select class="form-control" name="tp" id="tp">
                                        <option value="1">转账</option>
                                        <option value="2">股东</option>
                                    </select></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><label class="control-label">手续费</label></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><input type="text" id="fee" class="form-control" value="" placeholder=""></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group"><label class="control-label">转出银行</label></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><select class="form-control" name="outid" id="outid">
                                        <option value="0">无</option>
                                                                                    <option value="3000"
                                                    balance="949087.5700">存-卡尼奥普                                                -智付3.0-卡尼奥普                                                -949087.5700</option>
                                                                                    <option value="3002"
                                                    balance="260644.1300">存-LY-依儿                                                -微信支付-lo**                                                -260644.1300</option>
                                                                                    <option value="3005"
                                                    balance="656032.5300">存-QQ微信支付宝扫码                                                -支付宝-888888                                                -656032.5300</option>
                                                                                    <option value="3008"
                                                    balance="9506.6100">存-用于旧路易会员转移额度至新路易                                                -中国农业银行-000000000                                                -9506.6100</option>
                                                                                    <option value="3009"
                                                    balance="348895.9200">存-王轶兵                                                -上海浦东发展银行-6217933180010298                                                -348895.9200</option>
                                                                                    <option value="3010"
                                                    balance="3821735.9600">存-王轶兵                                                -中国招商银行-6214834316226456                                                -3821735.9600</option>
                                                                                    <option value="3011"
                                                    balance="3737.0000">存-i12                                                -速汇宝-6000016833                                                -3737.0000</option>
                                                                                    <option value="3012"
                                                    balance="0.0000">取-李想                                                -上海浦东发展银行-6217933180066670                                                -0.0000</option>
                                                                                    <option value="3013"
                                                    balance="0.0000">取-徐立洋                                                -中国招商银行-6214833116622971                                                -0.0000</option>
                                                                                    <option value="3014"
                                                    balance="629830.0000">存-张增有                                                -中国建设银行-6236683140002095158                                                 -629830.0000</option>
                                                                            </select></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><label class="control-label">金额</label></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><input type="text" id="amount" class="form-control" value="" placeholder=""></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group"><label class="control-label">转入银行</label></div>
									</div>
									<div class="col-md-3">
										<div class="form-group"><select class="form-control" name="inid" id="inid">
                                        <option value="0">无</option>
                                                                                    <option value="3000"
                                                    balance="949087.5700">存-卡尼奥普                                                -智付3.0-卡尼奥普                                                -949087.5700</option>
                                                                                    <option value="3002"
                                                    balance="260644.1300">存-LY-依儿                                                -微信支付-lo**                                                -260644.1300</option>
                                                                                    <option value="3005"
                                                    balance="656032.5300">存-QQ微信支付宝扫码                                                -支付宝-888888                                                -656032.5300</option>
                                                                                    <option value="3008"
                                                    balance="9506.6100">存-用于旧路易会员转移额度至新路易                                                -中国农业银行-000000000                                                -9506.6100</option>
                                                                                    <option value="3009"
                                                    balance="348895.9200">存-王轶兵                                                -上海浦东发展银行-6217933180010298                                                -348895.9200</option>
                                                                                    <option value="3010"
                                                    balance="3821735.9600">存-王轶兵                                                -中国招商银行-6214834316226456                                                -3821735.9600</option>
                                                                                    <option value="3011"
                                                    balance="3737.0000">存-i12                                                -速汇宝-6000016833                                                -3737.0000</option>
                                                                                    <option value="3012"
                                                    balance="0.0000">取-李想                                                -上海浦东发展银行-6217933180066670                                                -0.0000</option>
                                                                                    <option value="3013"
                                                    balance="0.0000">取-徐立洋                                                -中国招商银行-6214833116622971                                                -0.0000</option>
                                                                                    <option value="3014"
                                                    balance="629830.0000">存-张增有                                                -中国建设银行-6236683140002095158                                                 -629830.0000</option>
                                                                            </select></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group"><label class="control-label">交易时间</label></div>
								</div>
								<div class="col-md-9">
									<div class="input-group input-medium date date-picker">
										<input type="text" class="form-control" name="dateline" id="dateline" readonly="">
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group"><label class="control-label">备注</label></div>
								</div>
								<div class="col-md-9">
									<div class="form-group"><input type="text" id="remark" class="form-control" value="" placeholder=""></div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary red" onclick="reconciliation();">保存</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->