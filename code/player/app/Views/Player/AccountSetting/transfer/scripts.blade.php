
<script type="text/javascript">
    var s = 1;
    var partnerCodeArr = [{!! $ValidPlatforms !!}];
    var account = "{{ $LoginMemberName }}";
    var _urlbalance = "/kzb/gp/balance?account={{ $LoginMemberName }}&gpid=";
    var _urlreclaim = "/kzb/gp/fundreclaim";
    var _ajaxcount = 0;
    var _nowcount = 0;
    var gpslist = null;
    $(document).ready(function () {
        setGps();
        $("#exchange").click(function () {
            var tempv = $("#tin").val();
            $("#tin").val($("#tout").val());
            $("#tout").val(tempv);
            setAmount($("#tout").val());
        });
    });
    var e = [];
    function setGps() {
        
        $.post("/common/GetPlatforms",
            function (_data) {
                if (_data.code == 200) {
                    gpslist = _data.data[0];
                    var data = _data.data[0];
                    // var b = _data.data[1];
                    var _html = "";
                    //array("id"=>"10000","name"=>"主账户","status"=>1,"i"=>"0","s"=>"","e"=>"","flag"=>1,"nb"=>0),
                    for (var _x = 0; _x < data.length; _x++) {
                        var v = data[_x];
                        if (_x == 0) {
                            _html += "<tr>";
                            // $("#amount").val(floorNum(b));
                            // $("span.main-account-num").html(floorNum(b)).attr('data-val', floorNum(b));
                        } else {
                            if (_x % 2 == 1 && _x != 1) {
                                _html += "<tr>";
                            }
                            var balance = v.nb == 1 ? "0.00" : "<img src=/static/img/loading.gif>";
                            if (v.status == 0 || v.flag == 2) {
                                balance = "维护";
                            }
                            //name
                            _html += "<th width='50px'>";
                            _html += v.name;
                            _html += "</th>";
                            //gp
                            _html += "<td width='50px' gpid='" + v.id + "' needget='" + (v.nb == 1 ? "false" :
                                "true") + "' data-val='0'>";
                            _html += balance;
                            _html += "</td>";
                            //cz
                            _html += "<td>";
                            if (v.status != 0 && v.flag != 2) {
                                _html += "<a gpid='" + v.id +
                                    "' href='javascript:void(0);' class='transfer-into-btn'>一键转入</a>";
                            }
                            _html += "</td>";
                            if (_x % 2 == 0) {
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
                    // getGps();
                } else {
                    // //失败，过5秒再来一次
                    // setTimeout(function () {
                    //     setGps();
                    // }, 60000);
                }
            }, "json");
    }
    function getGps() {
        // $("#gps").find("td[needget=true]").each(function () {
        //     var _otd = $(this);
        //     // if (_otd.html() != "维护") getGpbalance(_otd);
        // });
    }
    // function getGpbalance(_otd, _outid) {
    //     var gpid = _otd.attr("gpid");
    //     _otd.html("<img src=/static/img/loading.gif>").attr('data-val', 0);
    //     $.ajax({
    //         url: "/common/RefreshBalance?account=%ACCOUNT%&gpid=" + gpid,
    //         cache: false,
    //         success: function (_gf) {
    //             _gf = JSON.parse(_gf);
    //             var _otd = $("#gps").find("td[gpid=" + gpid + "],th[gpid=" + gpid + "]");
    //             if (_gf.code == 0) {
    //                 var amount = display_amount = parseFloat(_gf.data.val);
    //                 if (isNaN(amount)) {
    //                     amount = 0;
    //                     display_amount =
    //                         "<img style='cursor:pointer;' refresh='refresh' src=/static/img/refresh.png >";
    //                 } else {
    //                     amount = floorNum(amount);
    //                     display_amount = floorNum(amount);
    //                     _otd.attr('data-val', amount);
    //                 }
    //                 _otd.html(amount);
    //                 if (gpid == "MAIN") {
    //                     $("span.main-account-num").html(display_amount).attr('data-val', amount);
    //                 }
    //                 if (_outid && _outid != "MAIN") {
    //                     dotransfer("MAIN", _outid, amount);
    //                 } else {
    //                     setAmount();
    //                 }
    //             } else {
    //                 _otd.html("<img style='cursor:pointer;' refresh='refresh' src=/static/img/refresh.png >").attr(
    //                     'data-val', 0);
    //             }
    //         },
    //         error: function () {
    //             _otd.html("<img style='cursor:pointer;' refresh='refresh' src=/static/img/refresh.png >").attr(
    //                 'data-val', 0);
    //         }
    //     });
    // }
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
    $(".form-box").on('click', 'img[refresh=refresh]', function () {
        var _otd = $(this).parent();
        getGpbalance(_otd);
    });
    $(".form-box").on('click', 'a[gpid]', function () {
        var _btn = $(this);
        // $.unblockUI();
        // $.blockUI({
        //     message: '转账进行中，请稍候.'
        // });
        $.notific8("资金回收中，请稍候")
        _ajaxcount = $("#gps").find("td[needget=true]").length;
        _nowcount = 0;
        if (_ajaxcount == _nowcount) {
            $.notific8("您当前没有余额，请先充值。");
            // notify("您当前没有余额，请先充值。");
            $.unblockUI();
            return false;
        }
        $("#gps").find("td[needget=true]").each(function () {
            var _gpid = $(this).attr("gpid");
            console.log("准备回收" + _gpid + " -- 资金额度为 " + $("#gps").find("td[gpid=" + _gpid + "]").attr('data-val'));
            if (_btn.attr("gpid") != _gpid && floorNum($("#gps").find("td[gpid=" + _gpid + "]").attr(
                    'data-val')) != "0.00" && $("#gps").find("td[gpid=" + _gpid + "]").html() != "维护") {
                console.log("发送回收请求 - " + _gpid);
                $.ajax({
                    url: _urlreclaim,
                    type: "POST",
                    dataType: "json",
                    data: {
                        gpid: _gpid,
                        account: account
                    },
                    success: function (data) {
                        console.log(data);
                        //data = JSON.parse(data);
                        if (data.c == 0) {
                            $("#gps").find("td[gpid=" + _gpid + "]").html("0.00").attr(
                                'data-val', 0);
                        } else {
                            $("#gps").find("td[gpid=" + _gpid + "]").html(
                                "<img style='cursor:pointer;' refresh='refresh' src=/static/img/refresh.png >"
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
            tout = $("#tout").val();
        }
        if (!tin) {
            tin = $("#tin").val();
        }
        
        $.each(gpslist, function (idx, item) {
            console.log("idx is " + idx + "item is " + item);
            if (item.i != 0 && (item.id == tout || item.id == tin)) {
                amount = parseInt(amount);
            }
        });
        if (parseFloat(amount) < 1) {
            $.unblockUI();
            $.notific8(getError(1051, 'member_transfer'),{theme: 'ruby'});
            return false;
        }
        var vtin = parseFloat($("td[gpid=" + tin + "],span[gpid=" + tin + "]").attr('data-val'));
        var vtout = parseFloat($("td[gpid=" + tout + "],span[gpid=" + tout + "]").attr('data-val'));
        var display_vtin = parseFloat($("td[gpid=" + tin + "],span[gpid=" + tin + "]").text());
        var display_vtout = parseFloat($("td[gpid=" + tout + "],span[gpid=" + tout + "]").text());
        console.log("amount is " + amount);
        console.log("vtin is " + vtin);
        console.log("vtout is " + vtout);
        $("td[gpid=" + tin + "],span[gpid=" + tin + "]").html("<img src=/static/img/loading.gif>").attr('data-val', 0);
        $("td[gpid=" + tout + "],span[gpid=" + tout + "]").html("<img src=/static/img/loading.gif>").attr('data-val', 0);
        $.ajax({
            url: "/common/DoTransfer",
            type: "POST",
            data: {
                tout: tout,
                tin: tin,
                amount: amount,
                account: account,
            },
            success: function (data) {
                
                if (data.c == 0) {
                    $.unblockUI();
                    $.notific8("转账成功");
                    vtin = vtin + parseFloat(amount);
                    display_vtin += parseFloat(amount);
                    vtout = vtout - parseFloat(amount);
                    display_vtout -= parseFloat(amount);
                    $("td[gpid=" + tin + "],th[gpid=" + tin + "]").text(floorNum(vtin)).attr('data-val',
                        floorNum(vtin));
                    $("td[gpid=" + tout + "],th[gpid=" + tout + "]").text(floorNum(vtout)).attr('data-val',
                        floorNum(vtout));
                    if (tin == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtin)).attr('data-val', floorNum(
                            vtin));
                    }
                    if (tout == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtout)).attr('data-val', floorNum(
                            vtout));
                    }
                    setAmount();
                    search();
                } else {
                    console.log("vtin is " + vtin);
                    console.log("vtout is " + vtout);
                    $("td[gpid=" + tin + "],th[gpid=" + tin + "]").html(floorNum(vtin)).attr('data-val',
                        floorNum(vtin));
                    $("td[gpid=" + tout + "],th[gpid=" + tout + "]").html(floorNum(vtout)).attr('data-val',
                        floorNum(vtout));
                    if (tin == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtin)).attr('data-val', floorNum(
                            vtin));
                    }
                    if (tout == "MAIN") {
                        $("span.main-account-num").html(floorNum(display_vtout)).attr('data-val', floorNum(
                            vtout));
                    }
                    $.unblockUI();
                    $.notific8(getError(data.c, 'member_transfer'), {theme: 'ruby'});
                }
            },
            error: function (e) {
                $("td[gpid=" + tin + "],th[gpid=" + tin + "]").html(floorNum(vtin)).attr('data-val',
                    floorNum(vtin));
                $("td[gpid=" + tout + "],th[gpid=" + tout + "]").html(floorNum(vtout)).attr('data-val',
                    floorNum(vtout));
                $.unblockUI();
            }
        });
    }
    function transfer() {
        if ($("#amount").val() == '' && !isNaN($("#amount").val())) {
            alert("请填写正确的转账金额");
            return false;
        }
        if (parseInt($("#amount").val()) == 0) {
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
        return (Math.floor((parseFloat(num) * 100).toFixed(2)) / 100).toFixed(2);
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
<script src="/static/js/player/balance.js?201801201505"></script>
<script src="/static/js/player/transfer.js?201801201505"></script>
<link rel="stylesheet" type="text/css" href="/static/js/plugins/jquery-notific8/jquery.notific8.min.css" />
<script src="/static/js/plugins/jquery-notific8/jquery.notific8.min.js"></script>
<script type="text/javascript">
    $.notific8('configure', {
  life: 5000,
  theme: 'lime',
  icon: 'minus-circle',
  sticky: false,
  horizontalEdge: 'bottom',
  verticalEdge: 'right',
  zindex: 11000,
  closeText: 'x'
});
</script>