var accountid = 0;
$("#btnaddmc").click(function () {
    var accId = accountid;
    var ppId = $("#ppid > option:selected").val();
    var url = getUrl(ppId, accId);
    if (ppId > 1019 && accId == 0) {
        $.get("/kzb/bank/id", function (data) {
            if (data.c == 0) {
                savePayInfo(data.m, url);
            } else {
                $.notific8("生成ID失败！", {theme: 'ebony'});
            }
        });
    } else {
        savePayInfo(accountid, url);
    }
});

function savePayInfo(accId, url) {
    var data = $("#frmaddmc").serialize();
    var bankList = get_bank_list();
    var dinPayType = 'direct_pay';
    $.ajax({
        url: url,
        type: 'post',
        data: data + "&accountid=" + accId + '&host=demo.com&banklist=' + bankList + '&paytype=' + dinPayType,
        success: function (data) {
            if (data.c == 0) {
                $.notific8("保存成功");
                window.location.reload();
            } else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        cache: false
    });
}

function getUrl(ppId, accId) {
    var url
    if (ppId > 1019) {
        url = accId == 0 ? "/pay/create" : "/pay/edit"
    } else {
        url = accId == 0 ? "/kzb/bank/addmerchant" : "/kzb/bank/editmerchant"
    }
    return url;
}

function addmc() {
    accountid = 0;
    $("#frmaddmc").find("input").val("");
    $("#title").text("添加三方支付接口");
    init_form();
}


function editmc(t, id) {
    accountid = id;
    $("#title").text("编辑三方支付接口");
    $("#frmaddmc").find("input").val("");
    $.getJSON("/bank/getPayInfo?t=" + t + "&id=" + id, function (data) {
        $('#banklist').find('span[class=checked]').removeClass('checked');
        $.each(data, function (i, item) {
            if ($("#" + i).length > 0) {
                if (i == 'banklist') {
                    init_bank_list(item);
                } else if (i == 'paytype') {
                    init_paytype(item);
                } else {
                    $("#" + i).val(item);
                }
            }
        });
        init_form();
    });
}

function get_bank_list() {
    var banks = '';
    $('#banklist').find('span[class=checked]').each(function () {
        banks += $(this).parent().parent().attr('val') + ',';
    });
    return banks;
}

function get_dinpay_type() {
    var paytype = '';
    $('#paytype').find('span[class=checked]').each(function () {
        paytype += $(this).parent().parent().attr('val') + ',';
    });
    return paytype;
}

function init_bank_list(item) {
    $(banks).find('span[class=checked]').removeClass('checked');
    if (item.length > 0) {
        var list = item.split(',');
        var banks = $('#banklist');
        for (var i = 0; i < list.length; i++) {
            if (list[i].length > 0) {
                $(banks).find('label[class=radio-inline][val=' + list[i] + ']').find('span').addClass('checked');
            }
        }
    }
}

function init_paytype(item) {
    if (item.length > 0) {
        var list = item.split(',');
        var banks = $('#paytype');
        $(banks).find('span[class=checked]').removeClass('checked');
        for (var i = 0; i < list.length; i++) {
            if (list[i].length > 0) {
                $(banks).find('label[class=radio-inline][val=' + list[i] + ']').find('span').addClass('checked');
            }
        }
    }
}

$('#ppid').on('change', function () {
    init_form();
});

function init_form() {
    var ppid = $('#ppid').val();
    if (ppid == 1001 || ppid == 1007 || ppid == 1008 || ppid == 1012) {
        $('#productname').parent().parent().show();
    } else {
        $('#productname').parent().parent().hide();
    }

    if (ppid == 1004) {
        $('#virCardNoIn').parent().parent().show();
        $('#verficationCode').parent().parent().show();
        $('#cert').parent().parent().hide();
    } else {
        $('#virCardNoIn').parent().parent().hide();
        $('#verficationCode').parent().parent().hide();
        $('#cert').parent().parent().show();
    }

    if (ppid == 1005 || ppid == 1009 || ppid == 1013 || ppid == 1015) {
        $('#merchanthost').parent().parent().hide();
    } else {
        $('#merchanthost').parent().parent().show();
    }

    if (ppid == 1006) {
        $('#terminalid').parent().parent().show();
    } else {
        $('#terminalid').parent().parent().hide();
    }

    if (ppid == 2038) {
        $('#terminalcode').parent().parent().show();
    } else {
        $('#terminalcode').parent().parent().hide();
    }


    if (ppid == 1008 || ppid == 2040) {
        $('#account').parent().parent().show();
    } else {
        $('#account').parent().parent().hide();
    }

    if (ppid == 1025 || ppid == 2074) {
        $('#email').parent().parent().show();
    } else {
        $('#email').parent().parent().hide();
    }

    //1：网银，2：支付宝，3：财付通，4：微信支付，5：wap微信，6：支付卡，7：QQ手机钱包, 8:快捷支付, 9:支付宝H5, 10:微信H5, 11:百度扫码, 12:wap支付宝, 13:wapQQ手机钱包

    var showArr = {
        1009: 1, 1007: 1, 1008: 1, 1018: 1, 1020: 1, 1021: 1, 1024: 1, 1025: 1,
        2001: 1, 2003: 1, 2005: 1, 2008: 1, 2015: 1, 2017: 1, 2019: 1, 2020: 1,
        2021: 1, 2022: 1, 2023: 1, 2024: 1, 2025: 1, 2026: 1, 2027: 1,
        2028: 1, 2029: 1, 2030: 1, 2033: 1, 2034: 1, 2035: 1, 2036: 1, 2038: 1, 2039: 1,
        2040: 1, 2041: 1, 2042: 1, 2044: 1, 2045: 1, 2049: 1, 2050: 1, 2051:1, 2052:1, 2053: 1,
        2060: 1, 2061: 1, 2062: 1, 2063: 1, 2064: 1, 2065: 1, 2066: 1, 2067: 1, 2068: 1,
        2069: 1, 2055:1, 2056:1, 2057:1, 2058:1,2054: 1, 2070: 1, 2071: 1, 2072: 1, 2073:1, 2074:1, 2012:1
    }

    if (ppid in showArr) {
        var bandList = $('#banklist');
        bandList.find('label[val=1]').show();
        bandList.find('label[val=6]').hide();
        bandList.find('label[val=7]').hide();
        bandList.find('label[val=8]').hide();
		bandList.find('label[val=9]').hide();
        bandList.find('label[val=10]').hide();
		bandList.find('label[val=11]').hide();
		bandList.find('label[val=12]').hide();
		bandList.find('label[val=13]').hide();
        if (ppid in {2040: 1, 2041: 1, 2051:1, 2012:1}) { // 1：网银
            bandList.find('label[val=2]').hide();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').hide();
            bandList.find('label[val=5]').hide();
        } else if (ppid == 1007) {
            bandList.find('label[val=2]').hide();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=5]').show();
        } else if (ppid in {1018: 1}) {
            bandList.find('label[val=2]').hide();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=5]').hide();
        } else if (ppid in {
                1020: 1,
                1025: 1,
                1008: 1,
                2001: 1,
                2003: 1,
                2015: 1,
                2017: 1,
                2019: 1,
                2033: 1,
                2039: 1,
		1021: 1
            }) {
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=5]').hide();
        } else if (ppid in {2038: 1}) {
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=7]').show();
        } else if (ppid in {2013: 1, 2036: 1}) {
            bandList.find('label[val=1]').hide();
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
        } else if (ppid in {2035: 1, 2056: 1}) { // 2：支付宝
            bandList.find('label[val=1]').hide();
            bandList.find('label[val=2]').show();
            bandList.find('label[val=2] div span').addClass("checked");
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').hide();
            bandList.find('label[val=5]').hide();
        } else if (ppid in {2034: 1, 2045: 1}) { // 4：微信支付
            bandList.find('label[val=1]').hide();
            bandList.find('label[val=2]').hide();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=4] div span').addClass("checked");
            bandList.find('label[val=5]').hide();
        } else if ((ppid > 2019 && ppid < 2030) || (ppid > 2059 && ppid < 2070)) {
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=6]').show();
            bandList.find('label[val=7]').show();
            bandList.find('label[val=8]').show();
        } else if (ppid in {2005: 1, 2008: 1, 2058:1, 2053: 1, 2072: 1, 2073: 1, 2074:1}) {
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=6]').hide();
            bandList.find('label[val=7]').show();
        } else if (ppid in {2049: 1}) {
            bandList.find('label[val=1]').show();
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=6]').hide();
            bandList.find('label[val=7]').show();
          }else if(ppid in {2054: 1}){
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').show();
            bandList.find('label[val=6]').hide();
            bandList.find('label[val=7]').show();
            bandList.find('label[val=12]').show();
            bandList.find('label[val=13]').show();
        } else if(ppid in {2030: 1}){
            bandList.find('label[val=1]').hide();
            bandList.find('label[val=2]').hide();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').hide();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=7]').show();
        } else if(ppid in {2044: 1}){
            bandList.find('label[val=1]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=2]').show();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=7]').show();
            bandList.find('label[val=8]').hide();
        }else if(ppid in {2042: 1}){
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=6]').hide();
            bandList.find('label[val=7]').show();
            bandList.find('label[val=8]').show();
        }else if(ppid in {2050: 1}){
            bandList.find('label[val=2]').show();
            bandList.find('label[val=3]').hide();
            bandList.find('label[val=4]').show();
            bandList.find('label[val=5]').hide();
            bandList.find('label[val=6]').hide();
            bandList.find('label[val=7]').show();
            bandList.find('label[val=8]').hide();
        }else if (ppid in {2052:1}) {
			bandList.find('label[val=2]').show();
			bandList.find('label[val=3]').hide();
			bandList.find('label[val=4]').show();
			bandList.find('label[val=5]').hide();
			bandList.find('label[val=6]').hide();
			bandList.find('label[val=7]').show();
			bandList.find('label[val=8]').hide();
			bandList.find('label[val=9]').hide();
			bandList.find('label[val=10]').hide();
			bandList.find('label[val=11]').hide();
		} else if (ppid in {2055:1}) {
			bandList.find('label[val=1]').hide();
			bandList.find('label[val=2]').hide();
			bandList.find('label[val=3]').hide();
			bandList.find('label[val=4]').show();
			bandList.find('label[val=5]').hide();
			bandList.find('label[val=7]').show();
			bandList.find('label[val=11]').show();
		}else if (ppid in {2057:1}) { //微信H5， 支付宝H5
			bandList.find('label[val=1]').hide();
			bandList.find('label[val=2]').hide();
			bandList.find('label[val=3]').hide();
			bandList.find('label[val=4]').hide();
			bandList.find('label[val=5]').hide();
			bandList.find('label[val=9]').show();
			bandList.find('label[val=10]').show();
		}else if (ppid in {2070:1}) {
			bandList.find('label[val=1]').show();
			bandList.find('label[val=2]').show();
			bandList.find('label[val=3]').hide();
			bandList.find('label[val=4]').show();
			bandList.find('label[val=5]').hide();
			bandList.find('label[val=7]').show();
			bandList.find('label[val=9]').hide();
			bandList.find('label[val=10]').hide();
		}else if (ppid in {2071:1}) {
			bandList.find('label[val=2]').show();
			bandList.find('label[val=3]').hide();
			bandList.find('label[val=4]').show();
			bandList.find('label[val=5]').hide();
			bandList.find('label[val=7]').show();
			bandList.find('label[val=9]').show();
			bandList.find('label[val=10]').show();
		} else {
			bandList.find('label[val=2]').show();
			bandList.find('label[val=3]').show();
			bandList.find('label[val=5]').hide();
		}
        bandList.parent().parent().show();
    } else {
        $('#banklist').parent().parent().hide();
    }
    if (ppid == 2014 || ppid == 2030 || ppid == 2031 || ppid == 2032 || ppid == 2043) {
        $('#banklist').parent().parent().hide();
    }

	if(ppid == 2039 || ppid == 2015){
		 bandList.find('label[val=8]').show();
	}

    if (ppid == 1012) {
        $('#paytype').parent().parent().show();
        $('#dinpaypubkey').parent().parent().show();
    } else {
        $('#paytype').parent().parent().hide();
        $('#dinpaypubkey').parent().parent().hide();
    }

    if (ppid == 2013) {
        $('#session').parent().parent().show();
    } else {
        $('#session').parent().parent().hide();
    }

    // if (ppid == 1017) {
    //     $('#platformid').parent().parent().show();
    //     $('#payurl').parent().parent().show();
    // } else {
    //     $('#platformid').parent().parent().hide();
    //     $('#payurl').parent().parent().hide();
    // }

    // if (ppid == 2017 || (ppid > 2019 && ppid < 2030)) $('#domain').parent().parent().show();
    // else $('#domain').parent().parent().hide();

    if (ppid == 2017 || (ppid > 2019 && ppid < 2030) || (ppid > 2059 && ppid < 2070)) {
        $('#domain').parent().parent().show();
    }
    else {
        $('#domain').parent().parent().hide();
    }

    if ((ppid > 2019 && ppid < 2030) || (ppid > 2059 && ppid < 2070)) {
        $('#suburl').parent().parent().show();
        $('#merchanthost').parent().parent().hide();
    }
    else {
        $('#suburl').parent().parent().hide();
        $('#merchanthost').parent().parent().show();
    }

    if (ppid == 1017 || ppid == 2001 || ppid == 2003 || ppid == 2017 || (ppid > 2019 && ppid < 2030) || (ppid > 2059 && ppid < 2070)) {
        $('#platformid').parent().parent().show();
    } else {
        $('#platformid').parent().parent().hide();
    }

    if (ppid == 1017) {
        $('#payurl').parent().parent().show();
    } else {
        $('#payurl').parent().parent().hide();
    }
    if (ppid == 2005) {
        $('#zhihuipaypubkey').parent().parent().show();
    } else {
        $('#zhihuipaypubkey').parent().parent().hide();
    }
    if (ppid == 2007 || ppid == 2050 || ppid == 2070) {
        $('#rsapubkey').parent().parent().show();
    } else {
        $('#rsapubkey').parent().parent().hide();
    }
    if (ppid == 2050) {
        $('#rsaprikey').parent().parent().show();
    } else {
        $('#rsaprikey').parent().parent().hide();
    }
    if (ppid == 2015) {
        $('#huarenpublickey').parent().parent().show();
        $('#huarenprivatekey').parent().parent().show();
    } else {
        $('#huarenpublickey').parent().parent().hide();
        $('#huarenprivatekey').parent().parent().hide();
    }

	if(ppid == 2038 || ppid == 2049){
		$('#serverpublickey').parent().parent().show();
	}else{
		$('#serverpublickey').parent().parent().hide();
	}

    if (ppid == 2038) {
        $('#superstarpublickey').parent().parent().show();
        $('#superstarprivatekey').parent().parent().show();
    } else {
        $('#superstarpublickey').parent().parent().hide();
        $('#superstarprivatekey').parent().parent().hide();
    }

	if (ppid == 2049) {
		$('#cert').parent().parent().hide();
        $('#merchantpublickey').parent().parent().show();
        $('#merchantprivatekey').parent().parent().show();
    } else {
        $('#merchantpublickey').parent().parent().hide();
        $('#merchantprivatekey').parent().parent().hide();
    }

    $('#host').parent().parent().hide();
}

$(function () {
    $('#platform_list').on('click', function () {
        $('#platformModal').modal();
    });
});

function editPlatform(ppid) {
    $('#edit_ppid').val(ppid);
    $('#edit_name').val($('#name_' + ppid).text());
    $('#edit_alias').val($('#alias_' + ppid).text());
    var status = $('#status_' + ppid).attr("status");
    var statusList = $('#status_list');
    statusList.find("span").removeClass("checked");
    statusList.find("input[value=" + status + "]").parent().addClass("checked");
    $('#platformEditModal').modal();
}

function savePlatform() {
    var ppid = $('#edit_ppid').val();
    var alias = $('#edit_alias').val();
    var status = $('#status_list').find("span.checked > input").val();
    $.post('/bank/editPlatform', {ppid: ppid, alias: alias, status: status}, function (data) {
        if (data.success) {
            $.notific8('编辑成功！');
            $('#alias_' + ppid).text(alias);
            var statusStr = status == 0 ? "停用" : "启用";
            $('#status_' + ppid).attr("status", status).text(statusStr);
            $('#platformEditModal').modal('hide');
        } else {
            $.notific8('编辑失败！', {theme: 'ebony'});
        }
    })
}

function delAccount(ppid, accid) {
    if (confirm("确认删除？")) {
        $.post("/bank/delAccount", {ppid: ppid, accid: accid}, function (data) {
            if (data.success) {
                $.notific8('删除三方账号成功！');
                $('#tr_' + accid).remove();
            } else {
                $.notific8('删除三方账号失败！', {theme: 'ebony'});
            }
        });
    }
}

var getHostName = function (url) {

    //scheme : // [username [: password] @] hostame [: port] [/ [path] [? query] [# fragment]]*/

    var e = new RegExp('^(?:(?:https?|ftp):)/*(?:[^@]+@)?([^:/#]+)'),

        matches = e.exec(url);

    return matches ? matches[1] : url;

};
