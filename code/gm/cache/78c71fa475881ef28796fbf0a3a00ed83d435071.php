<script type="text/javascript">
    var acpid = 'i12';
</script>
<style type="text/css">
    label.checkbox-label input[type=checkbox] {
        position: relative;
        vertical-align: middle;
        bottom: 2px;
        margin-right: 5px;
        margin-left: 5px;
    }
</style>
<link rel="stylesheet" type="text/css" href="/static/css/base.css" />
<script type="text/javascript" src="/static/js/support/player/player.js"></script>
<script type="text/javascript" src="/static/js/support/player/playerdetial.js?201710"></script>
<script type="text/javascript">
    var isExchangeBtn = false;
    var s = 1;
    var account = "<?php echo e($account); ?>";
    var _ajaxcount = 0;
    var _nowcount = 0;
    var gpslist = null;
    function box_playerBalanceInfo() {
        setGps();
        $("#exchange").unbind("click").click(function () {
            if (isExchangeBtn) {
                var tempv = $("#tin").val();
                $("#tin").val($("#tout").val());
                $("#tout").val(tempv);
                setAmount($("#tout").val());
            } else {
                console.log("can not click on btn.");
            }
        });
    };
    var e = [];
    function setGps() {
        isExchangeBtn = false;
        $.post("/player/getPlatforms",
            { account: account },
            function (_data) {
                _data = JSON.parse(_data);
                resp = _data.data;
                if (resp.code == 0) {
                    gpslist = resp.data[0];
                    var data = resp.data[0];
                    var b = resp.data[1];
                    $("#amount").val(floorNum(b));
                    $("span.main-account-num").html(floorNum(b)).attr('data-val', floorNum(b));

                    $("#gps").find("tbody").html("");
                    var _html = "";
                    //array("id"=>"10000","name"=>"主账户","status"=>1,"i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>0),
                    for (var _x = 0; _x < data.length; _x++) {
                        var v = data[_x];
                        
                        if (v.id != "MAIN") {
                            if (_x % 2 == 0) {
                                _html += "<tr>";
                            }
                            var balance = v.nb == 1 ? "0.00" : "<img src=/static/image/loading.gif>";
                            if (v.status == 0 || v.flag == 2) {
                                balance = "维护";
                            }
                            //name
                            _html += "<th width='15%'>";
                            _html += v.name;
                            _html += "</th>";
                            //gp
                            _html += "<td width='22%' gpid='" + v.id + "' needget='" + (v.nb == 1 ? "false" :
                                "true") + "' data-val='0'>";
                            _html += balance;
                            _html += "</td>";
                            //cz
                            _html += "<td>";
                            if (v.status != 0 && v.flag != 2) {
                                _html += "<a gpid='" + v.id +
                                    "' transin=transin href='javascript:void(0);' class='transfer-into-btn'>一键转入</a>";
                            }
                            _html += "</td>";
                            if (_x % 2 == 1) {
                                _html += "</tr>";
                            }
                        }
                    }
                    $("#gps").find("tbody").html(_html);
                    var out = "";
                    $.each(data, function (idx, item) {
                        if (item.status != 0 && item.flag != 2) {
                            var selected = item.id == "MAIN" ? " selected " : "";
                            selected += item.i == 0 ? " t=f" : " t=i";
                            out += "<option " + selected + " value='" + item.id + "'>" + item.name +
                                "</option>";
                        }
                    });
                    $("#tin").html(out).find("option:eq(1)").attr("selected", true);
                    $("#tout").html(out);
                    getGps();
                    isExchangeBtn = true;
                } else {
                    //失败，过5秒再来一次
                    setTimeout(function () {
                        setGps();
                    }, 5000);
                }
            }
            );
        }
    function getGps() {
        $("#gps").find("td[needget=true]").each(function () {
            var _otd = $(this);
            if (_otd.html() != "维护") getGpbalance(_otd);
        });
    }
    function getGpbalance(_otd) {
        var gpid = _otd.attr("gpid");
        _otd.html("<img src=/static/image/loading.gif>").attr('data-val', 0);
        $.post("/player/getGpBalance",
            { account: account, gpid : gpid },
            function (_gf) {
                _gf = JSON.parse(_gf).data;
                var _otd = $("#gps").find("td[gpid=" + gpid + "],th[gpid=" + gpid + "]");
                if (_gf[0]) {
                    var amount = display_amount = parseFloat(_gf[2]);
                    if (isNaN(amount)) {
                        amount = 0;
                        display_amount =
                            "<img style='cursor:pointer;' refresh='refresh' src=/static/image/refresh.png >";
                    } else {
                        amount = floorNum(amount);
                        display_amount = floorNum(amount);
                        _otd.attr('data-val', amount);
                    }
                    _otd.html(amount);
                    if (gpid == "MAIN") {
                        $("span.main-account-num").html(display_amount).attr('data-val', amount);
                    }
                } else {
                    _otd.html("<img style='cursor:pointer;' refresh='refresh' src=/static/image/refresh.png >").attr(
                        'data-val', 0);
                }
            }
        );
    }

    function setAmount(_gpid) {
        if (_gpid == undefined) {
            _gpid = $("#tout").val();
        }
        if (_gpid == "MAIN") {
            var _a = $("span.main-account-num").attr('data-val');
            if (_a.indexOf("img") != -1) _a = 0;
            _a = floorNum(_a);
            $("#amount").val(_a);
        } else {
            var _a = $("#gps").find("td[gpid=" + _gpid + "]").attr('data-val');
            if (_a.indexOf("img") != -1) _a = 0;
            if ($("#tout").find("option:selected").attr("t") == "f") {
                _a = floorNum(_a);
            } else {
                _a = parseInt(_a);
            }
            $("#amount").val(_a);
        }
    }
    $("#tout").change(function () {
        setAmount($("#tout").val());
    });
    $(".form-box").unbind("click").on('click', 'img[refresh=refresh]', function () {
        var _otd = $(this).parent();
        getGpbalance(_otd);
    });
    $("body").delegate('a[transin]', "click", function () {
        // 一键转入
        // 使用delegate是因为这里的html元素是页面动态新增的，不能直接绑定，只能从父级节点进行处理
        var _btn = $(this);
        $.notific8("资金转入中，请稍后");
        var vtout = parseFloat($("span.main-account-num").attr('data-val'));
        var gpid = _btn.attr("gpid");
        var _btn_dataObj = $("#gps").find("td[gpid=" + gpid + "]");
        var vtin = parseFloat(_btn_dataObj.attr("data-val"));
        console.log("transfer amount " + vtout + " to " + gpid);
        var data = {
            tout: "MAIN",
            tin: gpid,
            amount: vtout,
            account: account,
        };
        console.log(data);
        if (vtout == 0) {
            $.notific8("您当前没有足够的余额，请先充值", {theme: 'ruby'});
            $.unblockUI();
            return false;
        } else {
            $.ajax({
                url: "/player/doTransfer",
                type: "POST",
                data: data,
                success: function (data) {
                    data = JSON.parse(data);
                    data = data.data;
                    if (data.c == 0) {
                        console.log("gpid - " + gpid + ", transfer amount is - " + vtout + ", tin amount is - " + vtin);
                        vtin += parseFloat(vtout);
                        console.log("gpid - " + gpid + " amount is - " + vtin);
                        _btn_dataObj.text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                        $("span.main-account-num").html(floorNum(0)).attr('data-val',floorNum(0));
                        $.unblockUI();
                        $.notific8("转账成功");
                        setAmount();
                        search();
                    } else {
                        _btn_dataObj.text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                        $("span.main-account-num").html(floorNum(vtout)).attr('data-val',floorNum(vtout));
                        $.unblockUI();
                        $.notific8(data.m, {theme: 'ruby'});
                    }
                },
                error: function (e) {
                    _btn_dataObj.text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                    $("span.main-account-num").html(floorNum(vtout)).attr('data-val',floorNum(vtout));
                    $.unblockUI();
                }
            });
        }
    });
    $(".form-box").unbind("click").on('click', 'a[reclaim=reclaim]', function () {
        var _btn = $(this);
        $.notific8("资金回收中，请稍候");
        _ajaxcount = $("#gps").find("td[needget=true]").length;
        _nowcount = 0;
        if (_ajaxcount == _nowcount) {
            $.notific8("您当前没有余额，请先充值。");
            $.unblockUI();
            return false;
        }
        $("#gps").find("td[needget=true]").each(function () {
            var _gpid = $(this).attr("gpid");
            var _gpamount = floorNum($("#gps").find("td[gpid=" + _gpid + "]").attr('data-val'));
            console.log("准备回收" + _gpid + " -- 资金额度为 " + _gpamount);
            if (_btn.attr("gpid") != _gpid && _gpamount != "0.00" && $("#gps").find("td[gpid=" + _gpid +
                    "]").html() != "维护") {
                console.log("发送回收请求 - " + _gpid + "， 回收资金 - " + _gpamount);
                $.ajax({
                    url: "/player/fundReclaim",
                    type: "POST",
                    dataType: "json",
                    data: {
                        gpid: _gpid,
                        account: account,
                        amount: _gpamount
                    },
                    success: function (data) {
                        data = data.data;
                        if (data[0]) {
                            $("#gps").find("td[gpid=" + _gpid + "]").html("0.00").attr(
                                'data-val', 0);
                        } else {
                            $("#gps").find("td[gpid=" + _gpid + "]").html(
                                "<img style='cursor:pointer;' refresh='refresh' src=/static/image/refresh.png >"
                            ).attr('data-val', 0);
                        }
                    }
                }).done(function () {
                    _nowcount++;
                    if (_ajaxcount == _nowcount) {
                        if (_btn.attr("gpid") != "MAIN") {
                            getGpbalance($("span[gpid=MAIN]"), _btn.attr("gpid"));
                        } else {
                            notify("执行完毕");
                            getGpbalance($("span[gpid=MAIN]"));
                            search();
                            $.unblockUI();
                        }
                    }
                });
            } else {
                _nowcount++;
                if (_ajaxcount == _nowcount) {
                    if (_btn.attr("gpid") != "MAIN") {
                        getGpbalance($("span[gpid=MAIN]"), _btn.attr("gpid"));
                    } else {
                        $.notific8("执行完毕");
                        getGpbalance($("span[gpid=MAIN]"));
                        $.unblockUI();
                    }
                }
            }
        });
    });
    function dotransfer(tout, tin, amount) {
        if (!amount) {
            amount = $("#amount").val();
        }
        if (!tout) {
            tout = $("#tout").find('option:selected').val();
        }
        if (!tin) {
            tin = $("#tin").find('option:selected').val();
        }
        console.log("from " + tout + " to " + tin);
        //预检查平台转账余额是否充足
        var checkAmount = true;
        $.each(gpslist, function (idx, item) {
            if (item.id == tout) {
                var itemVal = parseFloat($("span[gpid=" + tout + "]").attr('data-val'));
                amount = parseFloat(amount);
                console.log("plat id - " + item.id + " itemVal is - " + itemVal + " transfer is " + amount);
                if (itemVal < 1) {
                    checkAmount = false;
                }
                if (amount < 1) {
                    checkAmount = false;
                }
                if (itemVal < amount) {
                    checkAmount = false;
                }
            }
        });
        if (!checkAmount) {
            $.unblockUI();
            $.notific8(getError(1051, 'member_transfer'), {
                theme: 'ruby'
            });
            return false;
        }
        if (tin == "MAIN") {
            var vtin = parseFloat($("span[gpid=" + tin + "]").attr('data-val'));
            var display_vtin = parseFloat($("span[gpid=" + tin + "]").text());
            $("span[gpid=" + tin + "]").html("<img src=/static/image/loading.gif>").attr('data-val', 0);
        } else {
            var vtin = parseFloat($("td[gpid=" + tin + "]").attr('data-val'));
            var display_vtin = parseFloat($("td[gpid=" + tin + "]").text());
            $("td[gpid=" + tin + "]").html("<img src=/static/image/loading.gif>").attr('data-val', 0);
        }
        if (tout == "MAIN") {
            var vtout = parseFloat($("span[gpid=" + tout + "]").attr('data-val'));
            var display_vtout = parseFloat($("span[gpid=" + tout + "]").text());
            $("span[gpid=" + tout + "]").html("<img src=/static/image/loading.gif>").attr('data-val', 0);
        } else {
            var vtout = parseFloat($("td[gpid=" + tout + "]").attr('data-val'));
            var display_vtout = parseFloat($("td[gpid=" + tout + "]").text());
            $("td[gpid=" + tout + "]").html("<img src=/static/image/loading.gif>").attr('data-val', 0);
        }
        console.log("amount is " + amount);
        console.log("vtin is " + vtin);
        console.log("vtout is " + vtout);
        $.ajax({
            url: "/player/doTransfer",
            type: "POST",
            data: {
                tout: tout,
                tin: tin,
                amount: amount,
                account: account,
            },
            success: function (data) {
                data = JSON.parse(data);
                data = data.data;
                if (data.c == 0) {
                    $.unblockUI();
                    $.notific8("转账成功");
                    vtin = vtin + parseFloat(amount);
                    display_vtin += parseFloat(amount);
                    vtout = vtout - parseFloat(amount);
                    display_vtout -= parseFloat(amount);
                    if (tin == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtin)).attr('data-val', floorNum(
                            vtin));
                    } else {
                        $("td[gpid=" + tin + "]").text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                    }
                    if (tout == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtout)).attr('data-val', floorNum(
                            vtout));
                    } else {
                        $("td[gpid=" + tout + "]").text(floorNum(vtout)).attr('data-val', floorNum(vtout));
                    }
                    setAmount();
                    search();
                } else {
                    if (tin == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtin)).attr('data-val', floorNum(
                            vtin));
                    } else {
                        $("td[gpid=" + tin + "]").text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                    }
                    if (tout == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtout)).attr('data-val', floorNum(
                            vtout));
                    } else {
                        $("td[gpid=" + tout + "]").text(floorNum(vtout)).attr('data-val', floorNum(vtout));
                    }
                    $.unblockUI();
                    $.notific8(data.m, {
                        theme: 'ruby'
                    });
                }
            },
            error: function (e) {
                if (tin == "MAIN") {
                    $("span.main-account-num").html(floorNum(display_vtin)).attr('data-val', floorNum(
                        vtin));
                } else {
                    $("td[gpid=" + tin + "]").text(floorNum(vtin)).attr('data-val', floorNum(vtin));
                }
                if (tout == "MAIN") {
                    $("span.main-account-num").html(floorNum(display_vtout)).attr('data-val', floorNum(
                        vtout));
                } else {
                    $("td[gpid=" + tout + "]").text(floorNum(vtout)).attr('data-val', floorNum(vtout));
                }
                $.unblockUI();
            }
        });
    }
    function transfer() {
        if ($("#amount").val() == '' && !isNaN($("#amount").val())) {
            alert("请填写正确的转账金额");
            return false;
        }
        if (parseFloat($("#amount").val()) == 0) {
            alert("转账金额不能为0！");
            return false;
        }
        if ($("#tout").val() == $("#tin").val()) {
            alert("不能对同一个账户进行操作！");
            return false;
        }
        // $.blockUI({
        //     message: '转账进行中，请稍候.'
        // });
        console.log("click on transfer button");
        $.notific8("转账进行中，请稍候.");
        dotransfer();
    }
    function load_history(start, end, status, index, out_id, in_id) {
        $('#trans_history').load('/fund/tHistory?start=' + start + '&end=' + end + '&curIndex=' + index + '&out_id=' +
            out_id + '&in_id=' + in_id + '&status=' + status);
    }
    function search() {
        var start = new Date($('#start').val()).getTime() / 1000;
        var end = new Date($('#end').val()).getTime() / 1000;
        var out_id = $('#gp_out').find('option:selected').val();
        var in_id = $('#gp_in').find('option:selected').val();
        start = !isNaN(start) ? start : 0;
        end = !isNaN(end) ? end : 0;
        var status = 0;
        load_history(start, end, status, 1, out_id, in_id);
    }
    function floorNum(num) {
        return (Math.floor((parseFloat(num) * 100).toFixed(4)) / 100).toFixed(4);
    }
    function notify(msg, type) {
        // if (!type) {
        //     type = 'info';
        // }
        // Messenger().post({
        //     message: msg,
        //     type: type,
        //     showCloseButton: true
        // });
    }
</script>

<script type="text/javascript">
    $("#s_TimeFliBox").change(function(){
            if(this.value=="ClearDate"){
                $("#box_StartTime").val('');
                $("#box_EndTime").val('');
            }
            if(this.value=="LastWeek"){
                var s=getLastWeekStartDate()+" 00:00:00",e=getLastWeekEndDate()+" 23:59:59";
                $("#box_StartTime").val(s);
                $("#box_EndTime").val(e);
                //$('#s_StartTime').datetimepicker('setEndDate',s);
                $('#box_EndTime').datetimepicker('setStartDate',e);
            }
            if(this.value=="LastMonth"){
                var s=getLastMonthStartDate()+" 00:00:00",e=getLastMonthEndDate()+" 23:59:59";
                $("#box_StartTime").val(s);
                $("#box_EndTime").val(e);
                //$('#s_StartTime').datetimepicker('setEndDate',s);
                $('#box_EndTime').datetimepicker('setStartDate',e);
            }
            if(this.value=="Yesterday"){
                var s=getDate(0)+" 00:00:00",e=getDate(0)+" 23:59:59";
                $("#box_StartTime").val(s);
                $("#box_EndTime").val(e);
                //$('#s_StartTime').datetimepicker('setEndDate',s);
                $('#box_EndTime').datetimepicker('setStartDate',e);
            }
            if(this.value=="Today"){
                var s=getDate(-1)+" 00:00:00",e=getDate(-1)+" 23:59:59";
                $("#box_StartTime").val(s);
                $("#box_EndTime").val(e);
                //$('#s_StartTime').datetimepicker('setEndDate',s);
                $('#box_EndTime').datetimepicker('setStartDate',e);
            }
        });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).ready(function () {
            $('#tab_5').find('label[attr=ip]').each(function(){
                var tip = $(this);
                var ip = $(this).html();
                if (ip != "" && ip != null) {
                    if (ip.indexOf(".") != -1) {
                        ip = ip.split(".");
                        ip = ip[0] + "." + ip[1] + "." + ip[2] + ".1";
                        $.ajax({
                            url: '/home/getIpInfo',
                            type: 'get',
                            dataType: 'json',
                            data: {
                                ip: ip
                            },
                            cache: true,
                            error: function () {
                            },
                            success: function (data) {
                                var text = '获取IP信息失败!';
                                if (data.code == 0) {
                                    text = data.data['country'] + data.data['region'] + data.data['city'];
                                    if (data.data['region'] + data.data['city'] == "" ) {
                                        // $.ajax({
                                        //     url: '/site/getIpInfoTB',
                                        //     type: 'get',
                                        //     dataType: 'json',
                                        //     data: {
                                        //         ip: ip
                                        //     },
                                        //     cache: true,
                                        //     error: function () {},
                                        //     success: function (data) {
                                        //         tip.attr('flag',1);
                                        //         var text = '获取IP信息失败!';
                                        //         if (data.code == 0) {
                                        //             text = data['country'] + data.data['region'] +data.data['city'];
                                        //         }
                                        //         var td = $(tip).parent();
                                        //         //$(td).css('width',180);
                                        //         $(td).find('label[attr=addr]').html(text);
                                        //     }
                                        // });
                                    }
                                }
                                var td = $(tip).parent();
                                $(td).css('width', 180);
                                $(td).find('label[attr=addr]').html(
                                    text);
                                }
                        });
                    }};
            });
        });
    });
</script>