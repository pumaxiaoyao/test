<div class="modal fade bs-modal-lg" id="WCheck" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button id="WCheckVerify" class="close" type="button" onclick="endverifytask();" data-dismiss="modal">×</button>
                <button id="WCheckNoVerify" class="close" type="button" data-dismiss="modal">×</button>
                <h3>流水检查</h3>
                <!-- <div id="limit"></div> -->
            </div>
            <div class="modal-body">
                <div id="waterDetialTable" style="display:none;">
                    <div class="col-md-6" name="check">
                        <table class="table table-striped table-bordered table-hover table-full-width">
                            <thead>
                                <tr>
                                    <th>限制平台</th>
                                    <th>金额</th>
                                    <th>还需流水</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" name="water">
                        <table class="table table-striped table-bordered table-hover table-full-width">
                            <thead>
                                <tr>
                                    <th>游戏平台</th>
                                    <th>金额</th>
                                    <th>剩余</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-full-width" id="wtable">
                    <thead>
                        <tr>
                            <th>单号</th>
                            <th>时间</th>
                            <th>类型</th>
                            <th>说明</th>
                            <th>限制平台</th>
                            <th>活动</th>
                            <th>流水要求</th>
                            <th>未完成流水</th>
                            <th>流水抵扣明细</th>
                            <th>账户总余额</th>
                            <th>是否完成</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary red" id="submitCheckResult" onclick="submitCheckResult(this);">提交检查结果 </button>
                <button id="WCheckCancel" class="btn" data-dismiss="modal" onclick="endverifytask();" aria-hidden="true">取消</button>
                <button id="WCheckNoCancel" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
            </div>
        </div>
    </div>
</div>
<script>
    var a =
        '10000,420987656202,350808494186211,350808494186212,350808494186213,350808494186214,387122175998732,387122175998733,8246252097638400,11964220589608960,350808494186210,9283948292830,520723134101,550123423101,550223423201,773562192801,773562192802,940256904101,7589283920390,7821359015601,38712217599873024'
        .split(",");
    var b =
        '主账户,newPT电游,BB视讯,BB彩票,BB3D,BB机率,AG电游,AG捕鱼,沙巴体育,MG电游,BB体育,欧博真人,KG,IM捕鱼,IM电子,申博真人,申博老虎机,新EBet,双赢彩票,蚂蚁彩票,AG真人'
        .split(",");
    var haspt = 'true';
</script>