<div class="page-content-wrapper">
	<div class="page-content" id="a_pageContent">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-globe"></i>第三方平台设置 </div>
				<div class="actions">
					<a class="btn green small" id="platform_list" href="javascript:void(0);">三方平台列表</a>
					<a class="btn green small" onclick="addmc();" href="#AddMC" data-toggle="modal">添加三方支付接口</a>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-bordered table-striped table-condensed flip-content table-hover">
					<thead>
						<tr>
							<th>序号</th>
							<th>三方支付平台</th>
							<th>商号ID</th>
							<th>三方支付绑定商城域名</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr id="tr_373284699495616512">
							<td>1</td>
							<td>智付3.0</td>
							<td>2070098872</td>
							<td>pay.kanao.top</td>
							<td><a href="#AddMC" data-toggle="modal" class="btn btn-xs green" onclick="editmc('api_payplugin_newdinpay','373284699495616512')">编辑</a>
								<a href="javascript:void(0);" class="btn btn-xs red" onclick="delAccount(1012,'373284699495616512')">删除</a>
							</td>
						</tr>
						<tr id="tr_382345347739308032">
							<td>2</td>
							<td>速汇宝</td>
							<td>6000016833</td>
							<td></td>
							<td><a href="#AddMC" data-toggle="modal" class="btn btn-xs green" onclick="editmc('api_payplugin_shuhuibaopay','382345347739308032')">编辑</a>
								<a href="javascript:void(0);" class="btn btn-xs red" onclick="delAccount(2049,'382345347739308032')">删除</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="AddMC" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="title">添加三方支付接口</h3>
					</div>
					<div class="modal-body">
						<form id="frmaddmc" class="form-horizontal" role="form">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">三方支付平台</label>

									<div class="col-md-9">
										<select class="form-control" tabindex="1" name="ppid" id="ppid">
                                                                            <option value="1000">环迅</option>
                                                                            <option value="1001">智付</option>
                                                                            <option value="1002">翼海</option>
                                                                            <option value="1003">易宝</option>
                                                                            <option value="1004">国付宝</option>
                                                                            <option value="1005">支付卫士</option>
                                                                            <option value="1006">宝付</option>
                                                                            <option value="1007">汇付宝</option>
                                                                            <option value="1008">环迅4.0</option>
                                                                            <option value="1009">易优付</option>
                                                                            <option value="1010">币币支付</option>
                                                                            <option value="1012">智付3.0</option>
                                                                            <option value="1014">口袋支付</option>
                                                                            <option value="1015">千网支付</option>
                                                                            <option value="1018">易付宝</option>
                                                                            <option value="1020">通汇支付</option>
                                                                            <option value="1021">新贝支付</option>
                                                                            <option value="1024">银宝支付</option>
                                                                            <option value="1025">华势支付</option>
                                                                            <option value="2000">秒付</option>
                                                                            <option value="2001">乐付宝</option>
                                                                            <option value="2003">惠付宝</option>
                                                                            <option value="2005">智汇付</option>
                                                                            <option value="2008">多宝支付</option>
                                                                            <option value="2012">新安全支付</option>
                                                                            <option value="2013">荣付</option>
                                                                            <option value="2015">华仁支付</option>
                                                                            <option value="2019">通汇网银2.0</option>
                                                                            <option value="2030">AloGateway</option>
                                                                            <option value="2031">AloGatewayWechat</option>
                                                                            <option value="2032">AloGatewayAlipay</option>
                                                                            <option value="2033">極付</option>
                                                                            <option value="2034">通汇微信2.0</option>
                                                                            <option value="2035">通汇支付宝2.0</option>
                                                                            <option value="2038">超级星</option>
                                                                            <option value="2039">必付支付</option>
                                                                            <option value="2040">epayTrust</option>
                                                                            <option value="2049">速汇宝</option>
                                                                            <option value="2051">聚合</option>
                                                                            <option value="2053">讯通宝1.0</option>
                                                                            <option value="2054">聚鑫</option>
                                                                            <option value="2070">智通宝</option>
                                                                            <option value="2071">乐付支付</option>
                                                                            <option value="2072">稳联支付</option>
                                                                            <option value="2073">旺付通</option>
                                                                            <option value="2074">汇达支付</option>
                                                                    </select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">商号ID</label>

									<div class="col-md-9">
										<input type="text" name="merchantcode" id="merchantcode" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">商户账号邮箱</label>

									<div class="col-md-9">
										<input type="text" name="email" id="email" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">平台号</label>

									<div class="col-md-9">
										<input type="text" name="platformid" id="platformid" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">提交域名(Domain)</label>

									<div class="col-md-9">
										<input type="text" name="domain" id="domain" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">会话状态(Session)</label>

									<div class="col-md-9">
										<input type="text" name="session" id="session" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">交易账户</label>

									<div class="col-md-9">
										<input type="text" name="account" id="account" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">终端ID</label>

									<div class="col-md-9">
										<input type="text" name="terminalid" id="terminalid" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">终端ID</label>

									<div class="col-md-9">
										<input type="text" name="terminalcode" id="terminalcode" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-md-3 control-label">商户卡号</label>
									<div class="col-md-9">
										<input type="text" name="merchantcard" id="merchantcard" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">证书或密匙</label>

									<div class="col-md-9">
										<textarea name="cert" id="cert" class="form-control"></textarea>
										<span class="help-block" style="color: red">密钥默认隐藏，如果不修改证书或密钥，此处留空白！ </span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">智付公钥</label>

									<div class="col-md-9">
										<textarea name="dinpaypubkey" id="dinpaypubkey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">智汇付公钥</label>

									<div class="col-md-9">
										<textarea name="zhihuipaypubkey" id="zhihuipaypubkey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">华仁平台公钥</label>

									<div class="col-md-9">
										<textarea name="huarenpublickey" id="huarenpublickey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">华仁商户私钥</label>

									<div class="col-md-9">
										<textarea name="huarenprivatekey" id="huarenprivatekey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">服务器公钥</label>

									<div class="col-md-9">
										<textarea name="serverpublickey" id="serverpublickey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">超级星公钥</label>

									<div class="col-md-9">
										<textarea name="superstarpublickey" id="superstarpublickey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">超级星私钥</label>

									<div class="col-md-9">
										<textarea name="superstarprivatekey" id="superstarprivatekey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">商户公钥</label>

									<div class="col-md-9">
										<textarea name="merchantpublickey" id="merchantpublickey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">商户私钥</label>

									<div class="col-md-9">
										<textarea name="merchantprivatekey" id="merchantprivatekey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">RSA公钥</label>

									<div class="col-md-9">
										<textarea name="rsapubkey" id="rsapubkey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">RSA私钥</label>

									<div class="col-md-9">
										<textarea name="rsaprikey" id="rsaprikey" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">商户识别码</label>

									<div class="col-md-9">
										<input type="text" name="verficationCode" id="verficationCode" class="form-control" value="">
										<span class="help-block" style="color: red">默认隐藏，如果不修改商户识别码，此处留空白！ </span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">国付宝转入账户</label>

									<div class="col-md-9">
										<input type="text" name="virCardNoIn" id="virCardNoIn" class="form-control" value="">
									</div>
								</div>
								<div class="form-group" style="display: none">
									<label class="col-md-3 control-label">银行网页地址（BQ專用）</label>

									<div class="col-md-9">
										<input type="text" name="suburl" id="suburl" class="form-control" value="">
										<span class="help-block">例如: http://www.abchina.com/cn</span>
									</div>
								</div>
								<div class="form-group" style="display: none">
									<label class="col-md-3 control-label">Mo宝接入地址</label>

									<div class="col-md-9">
										<input type="text" name="payurl" id="payurl" class="form-control" value="">
										<span class="help-block">例如: https://trade.mobaopay.com/cgi-bin/netpayment/pay_gate.cgi </span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">三方支付绑定商城域名</label>

									<div class="col-md-9">
										<input type="text" name="merchanthost" id="merchanthost" class="form-control" value="">
										<span class="help-block">例如: pay.shop.com 不需要带http:// </span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">账号开通管道</label>

									<div class="col-md-9">
										<div class="radio-list" id="banklist">
											<label class="radio-inline" val="1"><input type="checkbox" name="bank" value="1">
                                        银行卡</label>
											<label class="radio-inline" val="2"><input type="checkbox" name="bank" value="2">
                                        支付宝</label>
											<label class="radio-inline" val="3"><input type="checkbox" name="bank" value="3">
                                        财付通</label>
											<label class="radio-inline" val="4"><input type="checkbox" name="bank" value="4">
                                        微信支付</label>
											<label class="radio-inline" val="5"><input type="checkbox" name="bank" value="5">
                                        wap微信支付</label>
											<label class="radio-inline" val="6"><input type="checkbox" name="bank" value="6">
                                        支付卡</label>
											<label class="radio-inline" val="7"><input type="checkbox" name="bank" value="7">
                                        QQ手机钱包</label>
											<label class="radio-inline" val="8"><input type="checkbox" name="bank" value="8">
                                        快捷支付</label>
											<label class="radio-inline" val="9"><input type="checkbox" name="bank" value="9">
                                        支付宝H5</label>
											<label class="radio-inline" val="10"><input type="checkbox" name="bank" value="10">
                                        微信H5</label>
											<label class="radio-inline" val="11"><input type="checkbox" name="bank" value="11">
                                        百度扫码</label>
											<label class="radio-inline" val="12"><input type="checkbox" name="bank" value="12">
                                        wap支付宝支付</label>
											<label class="radio-inline" val="13"><input type="checkbox" name="bank" value="13">
                                        wapQQ手机钱包</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">商品名称</label>

									<div class="col-md-9">
										<input type="text" name="productname" id="productname" class="form-control" value="">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary green" id="btnaddmc">确认</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="platformModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="title">三方支付平台</h3>
					</div>
					<div class="modal-body">
						<table class="table table-bordered table-striped table-condensed flip-content table-hover">
							<thead>
								<tr>
									<th>序号</th>
									<th>三方支付平台</th>
									<th>展示名称</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td id="name_1000">环迅</td>
									<td id="alias_1000">在线支付一</td>
									<td id="status_1000" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1000')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td id="name_1001">智付</td>
									<td id="alias_1001">在线支付二</td>
									<td id="status_1001" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1001')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>3</td>
									<td id="name_1002">翼海</td>
									<td id="alias_1002">在线支付三</td>
									<td id="status_1002" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1002')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>4</td>
									<td id="name_1003">易宝</td>
									<td id="alias_1003">在线支付四</td>
									<td id="status_1003" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1003')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>5</td>
									<td id="name_1004">国付宝</td>
									<td id="alias_1004">在线支付五</td>
									<td id="status_1004" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1004')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>6</td>
									<td id="name_1005">支付卫士</td>
									<td id="alias_1005">在线支付六</td>
									<td id="status_1005" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1005')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>7</td>
									<td id="name_1006">宝付</td>
									<td id="alias_1006">在线支付七</td>
									<td id="status_1006" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1006')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>8</td>
									<td id="name_1007">汇付宝</td>
									<td id="alias_1007">在线支付八</td>
									<td id="status_1007" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1007')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>9</td>
									<td id="name_1008">环迅4.0</td>
									<td id="alias_1008">在线支付九</td>
									<td id="status_1008" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1008')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>10</td>
									<td id="name_1009">易优付</td>
									<td id="alias_1009">在线支付十</td>
									<td id="status_1009" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1009')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>11</td>
									<td id="name_1010">币币支付</td>
									<td id="alias_1010">在线支付十一</td>
									<td id="status_1010" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1010')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>12</td>
									<td id="name_1012">智付3.0</td>
									<td id="alias_1012">QQ/微信/网银充值</td>
									<td id="status_1012" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1012')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>13</td>
									<td id="name_1014">口袋支付</td>
									<td id="alias_1014">口袋支付</td>
									<td id="status_1014" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1014')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>14</td>
									<td id="name_1015">千网支付</td>
									<td id="alias_1015">千网支付</td>
									<td id="status_1015" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1015')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>15</td>
									<td id="name_1018">易付宝</td>
									<td id="alias_1018">易付宝</td>
									<td id="status_1018" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1018')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>16</td>
									<td id="name_1020">通汇支付</td>
									<td id="alias_1020">通汇支付</td>
									<td id="status_1020" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1020')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>17</td>
									<td id="name_1021">新贝支付</td>
									<td id="alias_1021">新贝支付</td>
									<td id="status_1021" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1021')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>18</td>
									<td id="name_1024">银宝支付</td>
									<td id="alias_1024">银宝支付</td>
									<td id="status_1024" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1024')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>19</td>
									<td id="name_1025">华势支付</td>
									<td id="alias_1025">华势支付</td>
									<td id="status_1025" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('1025')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>20</td>
									<td id="name_2000">秒付</td>
									<td id="alias_2000">秒付</td>
									<td id="status_2000" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2000')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>21</td>
									<td id="name_2001">乐付宝</td>
									<td id="alias_2001">乐付宝</td>
									<td id="status_2001" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2001')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>22</td>
									<td id="name_2003">惠付宝</td>
									<td id="alias_2003">惠付宝</td>
									<td id="status_2003" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2003')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>23</td>
									<td id="name_2005">智汇付</td>
									<td id="alias_2005">智汇付</td>
									<td id="status_2005" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2005')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>24</td>
									<td id="name_2008">多宝支付</td>
									<td id="alias_2008">多宝支付</td>
									<td id="status_2008" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2008')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>25</td>
									<td id="name_2012">新安全支付</td>
									<td id="alias_2012">新安全支付</td>
									<td id="status_2012" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2012')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>26</td>
									<td id="name_2013">荣付</td>
									<td id="alias_2013">荣付</td>
									<td id="status_2013" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2013')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>27</td>
									<td id="name_2015">华仁支付</td>
									<td id="alias_2015">华仁支付</td>
									<td id="status_2015" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2015')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>28</td>
									<td id="name_2019">通汇网银2.0</td>
									<td id="alias_2019">通汇网银2.0</td>
									<td id="status_2019" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2019')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>29</td>
									<td id="name_2030">AloGateway</td>
									<td id="alias_2030">AloGateway</td>
									<td id="status_2030" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2030')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>30</td>
									<td id="name_2031">AloGatewayWechat</td>
									<td id="alias_2031">AloGatewayWechat</td>
									<td id="status_2031" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2031')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>31</td>
									<td id="name_2032">AloGatewayAlipay</td>
									<td id="alias_2032">AloGatewayAlipay</td>
									<td id="status_2032" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2032')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>32</td>
									<td id="name_2033">極付</td>
									<td id="alias_2033">極付</td>
									<td id="status_2033" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2033')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>33</td>
									<td id="name_2034">通汇微信2.0</td>
									<td id="alias_2034">通汇微信2.0</td>
									<td id="status_2034" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2034')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>34</td>
									<td id="name_2035">通汇支付宝2.0</td>
									<td id="alias_2035">通汇支付宝2.0</td>
									<td id="status_2035" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2035')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>35</td>
									<td id="name_2038">超级星</td>
									<td id="alias_2038">超级星</td>
									<td id="status_2038" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2038')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>36</td>
									<td id="name_2039">必付支付</td>
									<td id="alias_2039">必付支付</td>
									<td id="status_2039" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2039')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>37</td>
									<td id="name_2040">epayTrust</td>
									<td id="alias_2040">epayTrust</td>
									<td id="status_2040" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2040')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>38</td>
									<td id="name_2049">速汇宝</td>
									<td id="alias_2049">速汇宝</td>
									<td id="status_2049" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2049')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>39</td>
									<td id="name_2051">聚合</td>
									<td id="alias_2051">聚合</td>
									<td id="status_2051" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2051')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>40</td>
									<td id="name_2053">讯通宝1.0</td>
									<td id="alias_2053">讯通宝1.0</td>
									<td id="status_2053" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2053')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>41</td>
									<td id="name_2054">聚鑫</td>
									<td id="alias_2054">聚鑫</td>
									<td id="status_2054" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2054')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>42</td>
									<td id="name_2070">智通宝</td>
									<td id="alias_2070">智通宝</td>
									<td id="status_2070" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2070')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>43</td>
									<td id="name_2071">乐付支付</td>
									<td id="alias_2071">乐付支付</td>
									<td id="status_2071" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2071')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>44</td>
									<td id="name_2072">稳联支付</td>
									<td id="alias_2072">稳联支付</td>
									<td id="status_2072" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2072')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>45</td>
									<td id="name_2073">旺付通</td>
									<td id="alias_2073">旺付通</td>
									<td id="status_2073" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2073')">编辑</a>
									</td>
								</tr>
								<tr>
									<td>46</td>
									<td id="name_2074">汇达支付</td>
									<td id="alias_2074">汇达支付</td>
									<td id="status_2074" status="1">启用</td>
									<td><a href="javascript:void(0);" onclick="editPlatform('2074')">编辑</a>
									</td>
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

		<div class="modal fade" id="platformEditModal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="title">三方支付平台</h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" role="form">
							<input type="hidden" id="edit_ppid" value="" />

							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">类型</label>

									<div class="col-md-7">
										<input type="text" name="ptname" id="edit_name" class="form-control" readonly value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">展示名称</label>

									<div class="col-md-7">
										<input type="text" name="ptalias" id="edit_alias" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">状态</label>

									<div class="col-md-7">
										<div id="status_list" class="radio-list">
											<label class="radio-inline">
                                        <input type="radio" name="status" value="1"/>启用
                                    </label>
											<label class="radio-inline">
                                        <input type="radio" name="status" value="0"/>停用
                                    </label>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary green" onclick="savePlatform()">确认</button>
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