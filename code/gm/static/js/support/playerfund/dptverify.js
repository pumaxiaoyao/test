var nowdno = 0;

var __balance__;
var __limit__;

function dosearch(){
    var total1 = 0;
    var total2 = 0;
    $("#s_search1").search({
        'tbId':'data1',
        's_search':'s_search1',
        'stateSave':true,
        'target':1,
        "_fnCallback": function (resp) {
            console.log(resp);
            // $('#data1 tbody > tr').find('td:eq(5)').css('text-align','right');
            //$('#data1 tbody > tr').find('td:eq(4),td:eq(6)').css('text-align','left');
            
            total1 = parseInt(resp.totalAll);
            $("#total").text(total1);
        }
    });
}
$(document).ready(function () {
    dosearch();
    
});
// setInterval(function(){
// 	refreshDPT();
// },15000);

function refreshDPT(){
    console.log("refresh");
    
    $.ajax({
        url: '/playerfund/dptVerifyAjax',
        type: 'post',
        data: {s_StartTime: 0, s_EndTime:0,  },
        success: function (data) {
            if (data.success) {
            } else {
                //alert(data.m);
            }
        },
        cache: false
    });
    dosearch();
}

var sf = false;
$("#sf").click(function(){
    if(sf==false){
        sf=true;
        $("#s_search2").search({
        'tbId':'data2',
        's_search':'s_search2',
        'stateSave':true,
        'target':2,
        "_fnCallback": function (resp) {
            $('#data2 tbody > tr').find('td:eq(5)').css('text-align','right');
            //$('#data2 tbody > tr').find('td:eq(4),td:eq(6)').css('text-align','left');
            
            total2 = parseInt(resp.iTotalRecords);
            $("#total").text(total2);
        }
    });
    }
});

//https://github.com/MikeMcl/bignumber.js +-*/ plus minus times dividedBy
$("select[id^=jj]").change(function () {
    var id = $(this).attr("id").replace("jj", "");
    getv(id);
});
$("input[id^=jz]").change(function () {
    var id = $(this).attr("id").replace("jz", "");
    getv(id);
});
$("select[id^=jb],input[id^=jb]").change(function () {
    var id = $(this).attr("id").replace("jb", "");
    gett(id, true);
});
function gett(id, b) {
    var l = $("#jv1").val();
    if (l == 0) {
        return false;
    }
    if (id == 4) {
        var jv1 = getnum("#jv1");
        var jv2 = getnum("#jv2");
        var jv3 = getnum("#jv3");
        l = jv1.plus(jv2).plus(jv3);
    }
    var v = getnum("#jb" + id);
    var b = id == "3" ? v.dividedBy(100) : v;
    v = b.times(l);
    $("#jl" + id).val(v);
    if (b)getv(id);
}
function getv(id) {
    var jl = getnum("#jl" + id);
    var jz = getnum("#jz" + id);
    var v = $("#jj" + id).val() == "+" ? jl.plus(jz) : jl.minus(jz);
    $("#jv" + id).val(v);
    if (id != 4) {
        gett(4);
    }
    if (id == 1) {
        gett(2, false);
        gett(3, false);
    }
}
function getnum(o) {
    var v = $(o).val();
    if (v == "")v = 0;
    if (isNaN(v))v = 0;
    return new BigNumber(v);
}
function resetf(am) {
    $("select[id^=j]").find("option:first").attr("selected", true);
    $("input[id^=j]").val("0");
    $("#jl1").val(am);
    $("#jv1").val(am);
    $("#jl4").val(am);
    $("#jv4").val(am);
    $("#jb4").val(1);
}
$("#config").click(function () {
    var data = $("#configform").serialize();
    $.ajax({
        url: '/kzb/fund/addadjust',
        type: 'post',
        data: data,
        success: function (data) {
            if (data.c == 0) {
                $.notific8("成功");
            } else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        cache: false
    });
});


$('#jj1').change(function () {
    limitShow();
});

$('#jz1').change(function () {
    limitShow();
});

function limitShow() {
    var temp = __balance__ + parseFloat($('#jv1').val());
    if (__limit__ > 0 && temp >= __limit__) {
        $('#limitShow').show();
        $('#limitShow').html('余额超限尽快转出，当前=' + temp + '，限额=' + __limit__);
    } else {
        $('#limitShow').hide();
    }
}


function init_balance(obj) {
    __balance__ = parseFloat($(obj).attr('cb'));
    __limit__ = parseFloat($(obj).attr('limit'));

    __balance__ = isNaN(__balance__) ? 0 : __balance__;
    __limit__ = isNaN(__limit__) ? 0 : __limit__;
    if (__limit__ > 0 && __balance__ >= __limit__) {
        $('#limitShow').show();
        $('#limitShow').html('余额超限尽快转出，当前=' + __balance__ + '，限额=' + __limit__);
    }
}


function startverifytask(obj, dno, amount, acode, bowner, cardnum,userbank,deposituser) {
//模式窗是自动弹出，这里只处理下赋值
    nowdno = dno;
    $('#limitShow').hide();
    init_balance(obj);
    init();
    resetf(amount);
    $("#acode").html(acode.replace(/<[^>].*?>/g,""));
    $("#bowner").html(bowner);
    $("#cardnum").html(cardnum);
    $("#userbank").html(userbank);
    $("#deposituser").html(deposituser);
    init_deals_rate($(obj).attr('dealsrate'));
    $('#VerifyModal').modal();
    $.ajax({
        url: '/task/deposit',
        type: 'post',
        data: {dno: nowdno},
        success: function (data) {
            if (data.success) {
            } else {
                //alert(data.m);
            }
        },
        cache: false
    });
}

function istartverifytask(dno){
    if(confirm("当前任务他人审核中,若您领走，其他人当前审核状态将被中断")){
    nowdno = dno;
    $.ajax({
        url: '/task/deposit',
        type: 'post',
        data: {dno: nowdno},
        success: function (data) {
            if (data.success) {
                $.notific8("成功");
                // window.location.reload();
                target[1].fnReloadAjax();
            } else {
                $.notific8(data.m);
            }
        },
        cache: false
    });
    }
}

function init(){
    $('input[type=radio][name=checkDpt]').prop('checked',false).parent().removeClass('checked');
    $('#btn_pass').hide();
    $('#btn_refuse').hide();
    $('#pass_content').hide();
    $('#remark').hide();
}

$(function(){
    $('input[type=radio][name=checkDpt]').on('click',function(){
        if($(this).val() == 1){
            $('#btn_pass').show();
            $('#btn_refuse').hide();
            $('#pass_content').show();
            $('#dealremark').val('客服通过');
        }else{
            $('#pass_content').hide();
            $('#btn_pass').hide();
            $('#btn_refuse').show();
            $('#dealremark').val('客服拒绝');
        }
        $('#remark').show();
    });
});

function cverifytask(obj, dno, amount, acode, bowner, cardnum,userbank,deposituser) {
    $("#acode").html(acode.replace(/<[^>].*?>/g,""));
    $("#bowner").html(bowner);
    $("#cardnum").html(cardnum);
    $("#userbank").html(userbank);
    $("#deposituser").html(deposituser);
    nowdno = dno;
    $('#limitShow').hide();
    init_balance(obj);
    resetf(amount);
    init_deals_rate($(obj).attr('dealsrate'));
    init();
    $('#VerifyModal').modal();
}

/**
 * 初始化优惠比例
 * @param rate
 */
function init_deals_rate(rate){
    rate = parseFloat(rate);
    var rates = $.parseJSON($('#dealsrates').val());;
    if(rate != NaN && rate > 0){
        var name = rate + '%';
        rate = rate * 1.0 / 100;
        rates[rate] = name;
    }
    var keys = [];
    for(var key in rates){
        keys.push(key);
    }
    keys.sort();
    $('#jb2 > option').remove();
    for(var i = 0;i < keys.length; i++){
        var key = keys[i];
        if(rate != key){
            $('#jb2').append('<option value="'+key+'">'+rates[key]+'</option>');
        }else{
            $('#jb2').append('<option selected value="'+key+'">'+rates[key]+'</option>');
        }
    }
    $('#jb2').change();
}

function endverifytask() {
    $.ajax({
        url: '/kzb/fund/freetask',
        type: 'post',
        data: {dno: nowdno},
        success: function (data) {
            if (data.c == 0) {
            } else {
//alert(data.m);
            }
        },
        cache: false
    });
}
function passverify() {
    var dealremark = $("#dealremark").val();
    var actual = $("#jv1").val();
    var ddeals = $("#jv2").val();
    var dgpid = $("#dgpid").val();
    var bgpid = $("#bgpid").val();
    var bonus = $("#jv3").val();
    var flows = $("#jv4").val();
    // var reason = $("#reason").val();

    if (dealremark == "") {
        $.notific8("请填写备注！", {theme: 'ebony'});
        return;
    }
    $.blockUI({baseZ: 20000});
    var actid = $("#actid").val();
    $.ajax({
        url: '/player/pass',
        type: 'post',
        data: {
            dno: nowdno,
            actual: actual,
            actid: actid,
            ddeals: ddeals,
            dealremark: dealremark,
            dgpid: dgpid,
            bgpid: bgpid,
            bonus: bonus,
            flows: flows
        },
        success: function (data) {
            data = JSON.parse(data);
            data = data.data;
            $.unblockUI();
            if (data.c == 0) {
                $.notific8("成功");
                // window.location.reload();
                $("#btn_cancel").click();
                target[1].fnReloadAjax();
                target[2].fnReloadAjax();
            }
            else {
                $.notific8(data.m, {theme: 'ebony'});
                // $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        error:function(){
            $.unblockUI();
        },
        cache: false
    });
}
function refuseverify() {
    var dealremark = $("#dealremark").val();
    if (dealremark == "") {
        $.notific8("请填写备注！", {theme: 'ebony'});
        return;
    }
    $.blockUI({baseZ: 20000});
    $.ajax({
        url: '/player/refuse',
        type: 'post',
        data: {dno: nowdno, dealremark: dealremark},
        success: function (data) {
            data = JSON.parse(data);
            data = data.data;
             $.unblockUI();
            if (data.c == 0) {
                $.notific8("成功");
                // window.location.reload();
                $("#btn_cancel").click();
                // console.log(target[1]);
                target[1].fnReloadAjax();
                target[2].fnReloadAjax();
            }
            else {
                $.notific8(data.m, {theme: 'ebony'});
                // $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        error:function(){
            $.unblockUI();
        },
        cache: false
    });
}

$("#selectall1").click(function(){
    if($(this).parent().hasClass("checked")){
        $("#data1").find("input[name=list]").attr("checked",false);
    }else{
        $("#data1").find("input[name=list]").attr("checked",true);
    }
});

$("#selectall2").click(function(){
    if($(this).parent().hasClass("checked")){
        $("#data2").find("input[name=list]").attr("checked",false);
    }else{
        $("#data2").find("input[name=list]").attr("checked",true);
    }
});

var nowselectdata = 1;

function startrefuseAll(n){
    if(confirm("确定要拒绝这些申请吗？拒绝后将无法恢复.")){
        $.blockUI();
        nowselectdata = n;
        console.log(n);
        refuseAll();
    }
}

function refuseAll(){
var o = $("#data"+nowselectdata).find("input[name=list]:checked:first");
// console.log(o);
nowdno = o.attr("dno");
// conso
o.attr("checked",false);
if(o.length==0){
    $.unblockUI();
    $.notific8('批量拒绝完毕，现在刷新页面。');
    // window.location.reload();
    target[nowselectdata].fnReloadAjax();
    return false;
}
$.ajax({
        // url: '/task/deposit',
        // type: 'post',
        // data: {dno: nowdno},
        // success: function (data) {
        //     if (data.success) {
        //         $.ajax({
        url: '/player/refuse',
        type: 'post',
        data: {dno: nowdno, dealremark: '客服批量处理'},
        success: function (data) {
            data = JSON.parse(data);
            data = data.data;
            if (data.c == 0) {
                //window.location.reload();
            }
            else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
            refuseAll();
        },
        cache: false
        });
    //         } else {
    //              refuseAll();
    //         }
    //     },
    //     cache: false
    // });
}
