<div class="modal fade" id="adjustBalance" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h3 id="myModalLabel">调整余额:
                        <font show=uname></font>
                    </h3>
                </div>
                <div class="modal-body">
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="form-section">
                                        调整余额 </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">加减</label>
                                        <select class="form-control" id="atype1">
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">数值</label>
                                        <input type="text" id="ja1" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">银行卡</label>
                                        <select class="form-control" id="cardId">
                                            <option limit="100000.00" balance="901083.5700" value="3000">
                                                存款-卡尼奥普-智付3.0-卡尼奥普 - (901,083.57)</option>
                                            <option limit="100000.00" balance="260644.1300" value="3002">
                                                存款-LY-依儿-微信支付-lo** - (260,644.13)</option>
                                            <option limit="100000.00" balance="605666.5300" value="3005">
                                                存款-QQ微信支付宝扫码-支付宝-888888 - (605,666.53)</option>
                                            <option limit="100000.00" balance="9506.6100" value="3008">
                                                存款-用于旧路易会员转移额度至新路易-中国农业银行-000000000 - (9,506.61)</option>
                                            <option limit="300000.00" balance="348895.9200" value="3009">
                                                存款-王轶兵-上海浦东发展银行-6217933180010298 - (348,895.92)</option>
                                            <option limit="300000.00" balance="3672028.2300" value="3010">
                                                存款-王轶兵-中国招商银行-6214834316226456 - (3,672,028.23)</option>
                                            <option limit="10000000.00" balance="3737.0000" value="3011">
                                                存款-i12-速汇宝-6000016833 - (3,737.00)</option>
                                            <option limit="300000.00" balance="0.0000" value="3012">
                                                取款-李想-上海浦东发展银行-6217933180066670 - (0.00)</option>
                                            <option limit="300000.00" balance="0.0000" value="3013">
                                                取款-徐立洋-中国招商银行-6214833116622971 - (0.00)</option>
                                            <option limit="300000.00" balance="571462.0000" value="3014">
                                                存款-张增有-中国建设银行-6236683140002095158 - (571,462.00)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="float:right;margin-right: 5px;">
                                <label id="showLimit" style="color: #ff0000;display: none;"></label>
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
                                        <input type="text" id="jb1" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">确认</label>
                                        <input type="text" id="jc1" readonly value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">加减</label>
                                        <select class="form-control" id="jj1">
                                            <option value="1">+</option>
                                            <option value="2">-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">数值</label>
                                        <input type="text" id="jz1" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">确认</label>
                                        <input type="text" readonly id="jv1" value="0" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" id="gpid1">
                                            <option value="">不限平台</option>
                                            @foreach( $games as $id => $name)
                                                <option value="{{$id}}">{{$name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">备注</label>
                                        <input type="text" id="remark1" class="form-control" placeholder="请说明调整原因，已经调整的结果">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary green" onclick="SaveConfig(1,this);">确认</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                </div>
            </div>
        </div>
    </div>