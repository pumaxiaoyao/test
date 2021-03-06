<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>银行支付设置 </div>
				<div class="actions">
					<a class="btn green small" id="bank_list" href="javascript:void(0);">银行类型列表</a>
					<a class="btn green small" id="add" onclick="addbc();" href="#AddBankCard" data-toggle="modal">添加银行卡</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>银行卡列表 </div>
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#portlet_tab1" data-toggle="tab">
                            启用的银行卡</a>
							</li>
							<li>
								<a href="#portlet_tab2" data-toggle="tab">
                            禁用的银行卡</a>
							</li>
						</ul>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_tab1">
								<table class="table table-bordered table-striped table-condensed flip-content table-hover">
									<thead>
										<tr>
											<th>序号</th>
											<th>银行名称</th>
											<th>开户名</th>
											<th>银行账号</th>
											<th>开户行</th>
											<th>用途</th>
											<th>类型</th>
											<th>启用</th>
											<th>最大限额</th>
											<th>余额</th>
											<th>最后修改</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<tr style="background-color:wheat">
											<td>1</td>
											<td>智付3.0</td>
											<td>卡尼奥普</td>
											<td>卡尼奥普<br>智付</td>
											<td>智付</td>
											<td>存款</td>
											<td>三方</td>
											<td>启用</td>
											<td style="color:red">100,000.00</td>
											<td style="color:red">949,087.57</td>
											<td>2017-08-24<br/>17:02:15</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3000');" class="btn btn-xs green">编辑</a>
												<br><br><a onclick="unbindid('3000');" class="btn btn-xs red">解除三方支付接口(newdinpay)</a></td>
										</tr>
										<tr style="background-color:wheat">
											<td>2</td>
											<td>微信支付</td>
											<td>LY-依儿</td>
											<td>lo**<br>LY-小易</td>
											<td>扫码添加微信转帐</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td style="color:red">100,000.00</td>
											<td style="color:red">260,644.13</td>
											<td>2017-09-08<br/>23:44:17</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3002');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr style="background-color:wheat">
											<td>3</td>
											<td>支付宝</td>
											<td>QQ微信支付宝扫码</td>
											<td>888888<br>民乐支付</td>
											<td>支付页面务必填写会员账号和真实姓名</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td style="color:red">100,000.00</td>
											<td style="color:red">656,032.53</td>
											<td>2017-09-02<br/>13:57:40</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3005');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr>
											<td>4</td>
											<td>中国农业银行</td>
											<td>用于旧路易会员转移额度至新路易</td>
											<td>000000000<br>用于旧路易会员转移额度至新路易</td>
											<td>用于旧路易会员转移额度至新路易</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td>100,000.00</td>
											<td>9,506.61</td>
											<td>2017-09-05<br/>16:19:23</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3008');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr style="background-color:wheat">
											<td>5</td>
											<td>上海浦东发展银行</td>
											<td>王轶兵</td>
											<td>6217933180010298<br>公司入款</td>
											<td>浦发长春一汽支行</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td style="color:red">300,000.00</td>
											<td style="color:red">348,895.92</td>
											<td>2017-09-05<br/>19:47:05</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3009');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr style="background-color:wheat">
											<td>6</td>
											<td>中国招商银行</td>
											<td>王轶兵</td>
											<td>6214834316226456<br>公司入款</td>
											<td>招商银行</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td style="color:red">300,000.00</td>
											<td style="color:red">3,821,735.96</td>
											<td>2017-09-10<br/>01:02:50</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3010');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr>
											<td>7</td>
											<td>速汇宝</td>
											<td>i12</td>
											<td>6000016833<br>速匯寶</td>
											<td>速匯寶</td>
											<td>存款</td>
											<td>三方</td>
											<td>启用</td>
											<td>10,000,000.00</td>
											<td>3,737.00</td>
											<td>2017-09-18<br/>17:07:59</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3011');" class="btn btn-xs green">编辑</a>
												<br><br><a onclick="unbindid('3011');" class="btn btn-xs red">解除三方支付接口(shuhuibaopay)</a></td>
										</tr>
										<tr>
											<td>8</td>
											<td>上海浦东发展银行</td>
											<td>李想</td>
											<td>6217933180066670<br>出款卡</td>
											<td>长春支行</td>
											<td>取款</td>
											<td>银行</td>
											<td>启用</td>
											<td>300,000.00</td>
											<td>0.00</td>
											<td>2017-09-23<br/>15:35:28</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3012');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr>
											<td>9</td>
											<td>中国招商银行</td>
											<td>徐立洋</td>
											<td>6214833116622971<br>出款卡</td>
											<td>招商银行</td>
											<td>取款</td>
											<td>银行</td>
											<td>启用</td>
											<td>300,000.00</td>
											<td>0.00</td>
											<td>2017-09-23<br/>15:38:10</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3013');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr style="background-color:wheat">
											<td>10</td>
											<td>中国建设银行</td>
											<td>张增有</td>
											<td>6236683140002095158 <br>公司入款</td>
											<td>建设银行广东省分行</td>
											<td>存款</td>
											<td>银行</td>
											<td>启用</td>
											<td style="color:red">300,000.00</td>
											<td style="color:red">629,830.00</td>
											<td>2017-09-29<br/>04:03:47</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3014');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="tab-pane" id="portlet_tab2">
								<table class="table table-bordered table-striped table-condensed flip-content table-hover">
									<thead>
										<tr>
											<th>序号</th>
											<th>银行名称</th>
											<th>开户名</th>
											<th>银行账号</th>
											<th>开户行</th>
											<th>用途</th>
											<th>类型</th>
											<th>启用</th>
											<th>最大限额</th>
											<th>余额</th>
											<th>最后修改</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>中国农业银行</td>
											<td>测试</td>
											<td>xxxxx<br>测试</td>
											<td>xxxxxx</td>
											<td>存款</td>
											<td>银行</td>
											<td>禁用</td>
											<td>10,000.00</td>
											<td>1,200.00</td>
											<td>2017-08-30<br/>23:03:20</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3001');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
										<tr style="background-color:wheat">
											<td>2</td>
											<td>上海浦东发展银行</td>
											<td>丛广庆</td>
											<td>6217923152175880<br>公司入款</td>
											<td>长春西安大路支行</td>
											<td>存款</td>
											<td>银行</td>
											<td>禁用</td>
											<td style="color:red">300,000.00</td>
											<td style="color:red">532,283.82</td>
											<td>2017-09-05<br/>18:18:29</td>
											<td><a href="#AddBankCard" data-toggle="modal" onclick="editbc('3006');" class="btn btn-xs green">编辑</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="modal fade" id="AddBankCard" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="title">添加银行卡</h3>
					</div>
					<div class="modal-body">
						<form id="frmaddbankcard" class="form-horizontal" role="form">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">所属银行<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="bdict" id="bdict">
                                                                            <option value="6">中国农业银行</option>
                                                                            <option value="84">AloGatewayAlipay</option>
                                                                            <option value="82">AloGateway</option>
                                                                            <option value="83">AloGatewayWechat</option>
                                                                            <option value="28">宝付</option>
                                                                            <option value="33">币币支付</option>
                                                                            <option value="7">中国交通银行</option>
                                                                            <option value="124">百度錢包</option>
                                                                            <option value="91">必付支付</option>
                                                                            <option value="8">中国银行</option>
                                                                            <option value="20">长安银行</option>
                                                                            <option value="3">中国建设银行</option>
                                                                            <option value="15">中国光大银行</option>
                                                                            <option value="22">财付通</option>
                                                                            <option value="17">广发银行</option>
                                                                            <option value="13">兴业银行</option>
                                                                            <option value="4">中国招商银行</option>
                                                                            <option value="11">中国民生银行</option>
                                                                            <option value="5">中国中信银行</option>
                                                                            <option value="19">智付</option>
                                                                            <option value="56">多宝支付</option>
                                                                            <option value="32">易优付</option>
                                                                            <option value="92">epayTrust</option>
                                                                            <option value="127">稳联支付</option>
                                                                            <option value="105">讯通宝1.0</option>
                                                                            <option value="25">国付宝</option>
                                                                            <option value="18">广州银行</option>
                                                                            <option value="14">华夏银行</option>
                                                                            <option value="29">汇付宝</option>
                                                                            <option value="67">华仁支付</option>
                                                                            <option value="130">汇达支付</option>
                                                                            <option value="51">惠付宝</option>
                                                                            <option value="1">环迅在线支付</option>
                                                                            <option value="2">中国工商银行</option>
                                                                            <option value="123">京東錢包</option>
                                                                            <option value="85">極付</option>
                                                                            <option value="103">聚合</option>
                                                                            <option value="106">聚鑫</option>
                                                                            <option value="37">口袋支付</option>
                                                                            <option value="52">乐付宝</option>
                                                                            <option value="126">乐付支付</option>
                                                                            <option value="35">智付3.0</option>
                                                                            <option value="30">环迅4.0</option>
                                                                            <option value="63">新安全支付</option>
                                                                            <option value="71">通汇网银2.0</option>
                                                                            <option value="87">通汇支付宝2.0</option>
                                                                            <option value="86">通汇微信2.0</option>
                                                                            <option value="16">南京银行</option>
                                                                            <option value="54">秒付</option>
                                                                            <option value="31">其它银行</option>
                                                                            <option value="10">中国平安银行</option>
                                                                            <option value="12">中国邮政储蓄银行</option>
                                                                            <option value="122">QQ手机钱包</option>
                                                                            <option value="38">千网支付</option>
                                                                            <option value="64">荣付</option>
                                                                            <option value="27">支付卫士</option>
                                                                            <option value="101">速汇宝</option>
                                                                            <option value="9">上海浦东发展银行</option>
                                                                            <option value="90">超级星</option>
                                                                            <option value="43">通汇支付</option>
                                                                            <option value="128">旺付通</option>
                                                                            <option value="129">五码合一</option>
                                                                            <option value="50">华势支付</option>
                                                                            <option value="23">微信支付</option>
                                                                            <option value="46">新贝支付</option>
                                                                            <option value="24">翼海支付</option>
                                                                            <option value="26">易宝</option>
                                                                            <option value="41">易付宝</option>
                                                                            <option value="49">银宝支付</option>
                                                                            <option value="21">支付宝</option>
                                                                            <option value="55">智汇付</option>
                                                                            <option value="125">智通宝</option>
                                                                    </select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">持卡人<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="bowner" id="bowner" class="form-control" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">卡号<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="cardnum" id="cardnum" class="form-control" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">开户行<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="bankaddr" id="bankaddr" class="form-control" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">默认优惠比例<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="dealsrate" id="dealsrate" class="form-control" value="0">
											<span class="help-block">填写百分比数值，例如优惠百分之二，填写数值2.</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">余额限额提醒<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="balancelimit" id="balancelimit" class="form-control" value="0">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">二维码</label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="qrcode" id="qrcode" class="form-control" value="0">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">类型<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="ctype" id="ctype">
                                    <option value="1">银行</option>
                                    <option value="2">三方</option>
                                </select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">用途<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="usefor" id="usefor">
                                    <option value="1">存款</option>
                                    <option value="2">取款</option>
                                    <option value="3">库房</option>
                                </select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">备注<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" name="remark" id="remark" class="form-control" value="">
										</div>
									</div>
								</div>
								<div class="form-group" hidefor="ststus">
									<label class="col-md-3 control-label">状态<span
                                    class="required">*</span></label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="status" id="status">
                                    <option value="1">启用</option>
                                    <option value="2">禁用</option>
                                    <option value="3">作废</option>
                                </select>
									</div>
								</div>
								<div class="form-group" hidefor="showfield">
									<label class="col-md-3 control-label">支付支持</label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="showfield" id="showfield">
                                    <option value="1">网银/ATM</option>
                                    <option value="2">仅网银</option>
                                    <option value="3">仅ATM</option>
                                </select>
										<span class="help-block">三方存款方式设置不需要设置此参数 </span>
									</div>
								</div>
								<div class="form-group" hidefor="show">
									<label class="col-md-3 control-label">展示位置</label>

									<div class="col-md-8">
										<select class="form-control" tabindex="1" name="show" id="show">
                                    <option value="0">网页版/手机版</option>
                                    <option value="1">网页版</option>
                                    <option value="2">手机版</option>
                                </select>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary green" id="btnaddcard">确认</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="BindMC" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="dtitle">绑定三方支付接口</h3>
					</div>
					<div class="modal-body">
						<form id="frmbindmc" class="form-inline">
							<table>
								<tr>
									<td>
										<label for="bdict">选择三方支付接口</label>
									</td>
									<td>
										<select class="small" tabindex="1" name="mclist" id="mclist">
                                                                    </select>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary green" id="btnbindmc">确认</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="bankListModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3>银行列表</h3>
					</div>
					<div class="modal-body">
						<table class="table table-bordered table-striped table-condensed flip-content table-hover">
							<tr>
								<th>#</th>
								<th>银行名称</th>
								<th>排序</th>
								<th>排序</th>
							</tr>
							<tr>
								<td>1</td>
								<td>中国农业银行</td>
								<td id="order_6">0</td>
								<td><a bankname="中国农业银行" onclick="editBank(this,'6')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>2</td>
								<td>AloGatewayAlipay</td>
								<td id="order_84">1</td>
								<td><a bankname="AloGatewayAlipay" onclick="editBank(this,'84')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>3</td>
								<td>AloGateway</td>
								<td id="order_82">1</td>
								<td><a bankname="AloGateway" onclick="editBank(this,'82')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>4</td>
								<td>AloGatewayWechat</td>
								<td id="order_83">1</td>
								<td><a bankname="AloGatewayWechat" onclick="editBank(this,'83')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>5</td>
								<td>宝付</td>
								<td id="order_28">0</td>
								<td><a bankname="宝付" onclick="editBank(this,'28')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>6</td>
								<td>币币支付</td>
								<td id="order_33">1</td>
								<td><a bankname="币币支付" onclick="editBank(this,'33')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>7</td>
								<td>中国交通银行</td>
								<td id="order_7">0</td>
								<td><a bankname="中国交通银行" onclick="editBank(this,'7')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>8</td>
								<td>百度錢包</td>
								<td id="order_124">1</td>
								<td><a bankname="百度錢包" onclick="editBank(this,'124')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>9</td>
								<td>必付支付</td>
								<td id="order_91">1</td>
								<td><a bankname="必付支付" onclick="editBank(this,'91')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>10</td>
								<td>中国银行</td>
								<td id="order_8">0</td>
								<td><a bankname="中国银行" onclick="editBank(this,'8')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>11</td>
								<td>长安银行</td>
								<td id="order_20">0</td>
								<td><a bankname="长安银行" onclick="editBank(this,'20')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>12</td>
								<td>中国建设银行</td>
								<td id="order_3">0</td>
								<td><a bankname="中国建设银行" onclick="editBank(this,'3')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>13</td>
								<td>中国光大银行</td>
								<td id="order_15">0</td>
								<td><a bankname="中国光大银行" onclick="editBank(this,'15')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>14</td>
								<td>财付通</td>
								<td id="order_22">0</td>
								<td><a bankname="财付通" onclick="editBank(this,'22')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>15</td>
								<td>广发银行</td>
								<td id="order_17">0</td>
								<td><a bankname="广发银行" onclick="editBank(this,'17')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>16</td>
								<td>兴业银行</td>
								<td id="order_13">0</td>
								<td><a bankname="兴业银行" onclick="editBank(this,'13')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>17</td>
								<td>中国招商银行</td>
								<td id="order_4">0</td>
								<td><a bankname="中国招商银行" onclick="editBank(this,'4')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>18</td>
								<td>中国民生银行</td>
								<td id="order_11">0</td>
								<td><a bankname="中国民生银行" onclick="editBank(this,'11')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>19</td>
								<td>中国中信银行</td>
								<td id="order_5">0</td>
								<td><a bankname="中国中信银行" onclick="editBank(this,'5')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>20</td>
								<td>智付</td>
								<td id="order_19">0</td>
								<td><a bankname="智付" onclick="editBank(this,'19')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>21</td>
								<td>多宝支付</td>
								<td id="order_56">1</td>
								<td><a bankname="多宝支付" onclick="editBank(this,'56')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>22</td>
								<td>易优付</td>
								<td id="order_32">1</td>
								<td><a bankname="易优付" onclick="editBank(this,'32')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>23</td>
								<td>epayTrust</td>
								<td id="order_92">1</td>
								<td><a bankname="epayTrust" onclick="editBank(this,'92')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>24</td>
								<td>稳联支付</td>
								<td id="order_127">1</td>
								<td><a bankname="稳联支付" onclick="editBank(this,'127')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>25</td>
								<td>讯通宝1.0</td>
								<td id="order_105">1</td>
								<td><a bankname="讯通宝1.0" onclick="editBank(this,'105')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>26</td>
								<td>国付宝</td>
								<td id="order_25">0</td>
								<td><a bankname="国付宝" onclick="editBank(this,'25')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>27</td>
								<td>广州银行</td>
								<td id="order_18">0</td>
								<td><a bankname="广州银行" onclick="editBank(this,'18')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>28</td>
								<td>华夏银行</td>
								<td id="order_14">0</td>
								<td><a bankname="华夏银行" onclick="editBank(this,'14')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>29</td>
								<td>汇付宝</td>
								<td id="order_29">0</td>
								<td><a bankname="汇付宝" onclick="editBank(this,'29')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>30</td>
								<td>华仁支付</td>
								<td id="order_67">1</td>
								<td><a bankname="华仁支付" onclick="editBank(this,'67')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>31</td>
								<td>汇达支付</td>
								<td id="order_130">1</td>
								<td><a bankname="汇达支付" onclick="editBank(this,'130')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>32</td>
								<td>惠付宝</td>
								<td id="order_51">1</td>
								<td><a bankname="惠付宝" onclick="editBank(this,'51')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>33</td>
								<td>环迅在线支付</td>
								<td id="order_1">0</td>
								<td><a bankname="环迅在线支付" onclick="editBank(this,'1')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>34</td>
								<td>中国工商银行</td>
								<td id="order_2">0</td>
								<td><a bankname="中国工商银行" onclick="editBank(this,'2')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>35</td>
								<td>京東錢包</td>
								<td id="order_123">1</td>
								<td><a bankname="京東錢包" onclick="editBank(this,'123')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>36</td>
								<td>極付</td>
								<td id="order_85">1</td>
								<td><a bankname="極付" onclick="editBank(this,'85')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>37</td>
								<td>聚合</td>
								<td id="order_103">1</td>
								<td><a bankname="聚合" onclick="editBank(this,'103')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>38</td>
								<td>聚鑫</td>
								<td id="order_106">1</td>
								<td><a bankname="聚鑫" onclick="editBank(this,'106')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>39</td>
								<td>口袋支付</td>
								<td id="order_37">1</td>
								<td><a bankname="口袋支付" onclick="editBank(this,'37')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>40</td>
								<td>乐付宝</td>
								<td id="order_52">1</td>
								<td><a bankname="乐付宝" onclick="editBank(this,'52')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>41</td>
								<td>乐付支付</td>
								<td id="order_126">1</td>
								<td><a bankname="乐付支付" onclick="editBank(this,'126')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>42</td>
								<td>智付3.0</td>
								<td id="order_35">1</td>
								<td><a bankname="智付3.0" onclick="editBank(this,'35')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>43</td>
								<td>环迅4.0</td>
								<td id="order_30">0</td>
								<td><a bankname="环迅4.0" onclick="editBank(this,'30')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>44</td>
								<td>新安全支付</td>
								<td id="order_63">1</td>
								<td><a bankname="新安全支付" onclick="editBank(this,'63')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>45</td>
								<td>通汇网银2.0</td>
								<td id="order_71">1</td>
								<td><a bankname="通汇网银2.0" onclick="editBank(this,'71')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>46</td>
								<td>通汇支付宝2.0</td>
								<td id="order_87">1</td>
								<td><a bankname="通汇支付宝2.0" onclick="editBank(this,'87')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>47</td>
								<td>通汇微信2.0</td>
								<td id="order_86">1</td>
								<td><a bankname="通汇微信2.0" onclick="editBank(this,'86')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>48</td>
								<td>南京银行</td>
								<td id="order_16">0</td>
								<td><a bankname="南京银行" onclick="editBank(this,'16')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>49</td>
								<td>秒付</td>
								<td id="order_54">1</td>
								<td><a bankname="秒付" onclick="editBank(this,'54')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>50</td>
								<td>其它银行</td>
								<td id="order_31">0</td>
								<td><a bankname="其它银行" onclick="editBank(this,'31')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>51</td>
								<td>中国平安银行</td>
								<td id="order_10">0</td>
								<td><a bankname="中国平安银行" onclick="editBank(this,'10')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>52</td>
								<td>中国邮政储蓄银行</td>
								<td id="order_12">0</td>
								<td><a bankname="中国邮政储蓄银行" onclick="editBank(this,'12')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>53</td>
								<td>QQ手机钱包</td>
								<td id="order_122">1</td>
								<td><a bankname="QQ手机钱包" onclick="editBank(this,'122')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>54</td>
								<td>千网支付</td>
								<td id="order_38">1</td>
								<td><a bankname="千网支付" onclick="editBank(this,'38')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>55</td>
								<td>荣付</td>
								<td id="order_64">1</td>
								<td><a bankname="荣付" onclick="editBank(this,'64')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>56</td>
								<td>支付卫士</td>
								<td id="order_27">0</td>
								<td><a bankname="支付卫士" onclick="editBank(this,'27')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>57</td>
								<td>速汇宝</td>
								<td id="order_101">1</td>
								<td><a bankname="速汇宝" onclick="editBank(this,'101')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>58</td>
								<td>上海浦东发展银行</td>
								<td id="order_9">0</td>
								<td><a bankname="上海浦东发展银行" onclick="editBank(this,'9')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>59</td>
								<td>超级星</td>
								<td id="order_90">1</td>
								<td><a bankname="超级星" onclick="editBank(this,'90')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>60</td>
								<td>通汇支付</td>
								<td id="order_43">1</td>
								<td><a bankname="通汇支付" onclick="editBank(this,'43')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>61</td>
								<td>旺付通</td>
								<td id="order_128">1</td>
								<td><a bankname="旺付通" onclick="editBank(this,'128')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>62</td>
								<td>五码合一</td>
								<td id="order_129">1</td>
								<td><a bankname="五码合一" onclick="editBank(this,'129')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>63</td>
								<td>华势支付</td>
								<td id="order_50">1</td>
								<td><a bankname="华势支付" onclick="editBank(this,'50')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>64</td>
								<td>微信支付</td>
								<td id="order_23">0</td>
								<td><a bankname="微信支付" onclick="editBank(this,'23')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>65</td>
								<td>新贝支付</td>
								<td id="order_46">1</td>
								<td><a bankname="新贝支付" onclick="editBank(this,'46')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>66</td>
								<td>翼海支付</td>
								<td id="order_24">0</td>
								<td><a bankname="翼海支付" onclick="editBank(this,'24')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>67</td>
								<td>易宝</td>
								<td id="order_26">0</td>
								<td><a bankname="易宝" onclick="editBank(this,'26')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>68</td>
								<td>易付宝</td>
								<td id="order_41">1</td>
								<td><a bankname="易付宝" onclick="editBank(this,'41')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>69</td>
								<td>银宝支付</td>
								<td id="order_49">1</td>
								<td><a bankname="银宝支付" onclick="editBank(this,'49')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>70</td>
								<td>支付宝</td>
								<td id="order_21">0</td>
								<td><a bankname="支付宝" onclick="editBank(this,'21')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>71</td>
								<td>智汇付</td>
								<td id="order_55">1</td>
								<td><a bankname="智汇付" onclick="editBank(this,'55')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
							<tr>
								<td>72</td>
								<td>智通宝</td>
								<td id="order_125">1</td>
								<td><a bankname="智通宝" onclick="editBank(this,'125')" href="javascript:void(0);">排序</a>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="bankEditModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="title">银行</h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" role="form">
							<input type="hidden" id="bank_id" value="" />

							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">银行名称</label>

									<div class="col-md-7">
										<input type="text" name="bank_name" id="bank_name" class="form-control" readonly value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">排序</label>

									<div class="col-md-7">
										<input type="text" name="order" id="bank_order" class="form-control" value="">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary green" onclick="saveBank()">确认</button>
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
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner ">

	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->