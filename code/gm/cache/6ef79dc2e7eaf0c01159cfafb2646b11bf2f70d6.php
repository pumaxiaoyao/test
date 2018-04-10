<script type="text/javascript" src="/static/js/support/settings/agentlevel.js?201801231542"></script>
<script>
    /**
     * 录入完成后，输入模式失去焦点后对录入进行判断并强制更改，并对小数点进行0补全
     **/
    function overFormat(th) {
        var v = th.value;
        if (v === '') {
            // v = '0.00';
        } else if (v === '0') {
            v = '0.00';
        } else if (v === '0.') {
            v = '0.00';
        } else if (/^0+\d+\.?\d*.*$/.test(v)) {
            v = v.replace(/^0+(\d+\.?\d*).*$/, '$1');
            // v = inp.getRightPriceFormat(v).val;
        } else if (/^0\.\d$/.test(v)) {
            v = v + '0';
        } else if (!/^\d+\.\d{2}$/.test(v)) {
            if (/^\d+\.\d{2}.+/.test(v)) {
                v = v.replace(/^(\d+\.\d{2}).*$/, '$1');
            } else if (/^\d+$/.test(v)) {
                v = v + '.00';
            } else if (/^\d+\.$/.test(v)) {
                v = v + '00';
            } else if (/^\d+\.\d$/.test(v)) {
                v = v + '0';
            } else if (/^[^\d]+\d+\.?\d*$/.test(v)) {
                v = v.replace(/^[^\d]+(\d+\.?\d*)$/, '$1');
            } else if (/\d+/.test(v)) {
                v = v.replace(/^[^\d]*(\d+\.?\d*).*$/, '$1');
                ty = false;
            } else if (/^0+\d+\.?\d*$/.test(v)) {
                v = v.replace(/^0+(\d+\.?\d*)$/, '$1');
                ty = false;
            } else {
                v = '0.00';
            }
        }
        if (v < 0) {
            v = "0.00";
        } else if (v > 100) {
            v = "100.00";
        }
        th.value = v;
    }

    function setLineFloat() {
        $("#brokerageModalTitle").attr("modalTag", "linefee");
        var layerid = $("#apportionForm").attr("layerid");
        var lineFloatStr = $("#agentLayerCommon" + layerid).attr("linefloatStr");
        setFloatData(lineFloatStr);
    }

    function setFloatData(floatStr) {
        console.log(floatStr);
        var mtag = $("#brokerageModalTitle").attr("modalTag");
        if (mtag == "linefee") {
            $("#FloatSettingTitle").html(
                "线路阶梯比例设置<br/><font color=red>【请注意：此阶梯比例根据代理总输赢数值计算阶梯，而不是单平台的输赢】</font>"
            );
            $("#FloatSettingTitle").attr("settingtag", "linefee");
        } else if (mtag == "commision") {
            $("#FloatSettingTitle").html(
                "抽佣阶梯比例设置<br/><font color=red>【请注意：此阶梯比例根据代理总输赢数值计算阶梯，而不是单平台的输赢】</font>"
            );
            $("#FloatSettingTitle").attr("settingtag", "commision");
        } else if (mtag == "water") {
            var game = $("#FloatSettingTitle").attr("gameTag");
            $("#FloatSettingTitle").html(
                game + "抽水阶梯比例设置<br/><font color=red>【请注意：此阶梯比例根据代理总输赢数值计算阶梯，而不是单平台的输赢】</font>"
            );
            $("#FloatSettingTitle").attr("settingtag", "water");
        }
        $("#t_waterlever").find("tbody").html("");
        if (typeof (floatStr) != "undefined" && floatStr.length > 0 && isContains(floatStr, "_")) {
            var nsfloat = floatStr.split("|");
            for (var i = 0; i < nsfloat.length; i++) {
                var nd = nsfloat[i].split("_");
                addlevertr(nd[0], (nd[1] * 100).toFixed(2));
            }
        }

    }

    function isContains(str, substr) {
        return str.indexOf(substr) >= 0;
    }

    function showRate(floatStr) {
        var newfloatStr = "暂无数据";
        if (typeof (floatStr) != "undefined" && floatStr.length > 0 && isContains(floatStr, "_")) {
            var nsfloat = floatStr.split("|");
            var perc = [];
            for (var i = 0; i < nsfloat.length; i++) {
                var nd = nsfloat[i].split("_");
                perc.push((nd[1] * 100).toFixed(2));
            }
            var maxV = Math.max.apply(null, perc);
            var minV = Math.min.apply(null, perc);
            newfloatStr = minV + "% ~ " + maxV + "%";
        }
        return newfloatStr;
    }

    function updateSelect(opt, val, elName) {
        var layerid = $("#apportionForm").attr("layerid");
        var dataObj = $("#" + elName + "ratedata");
        var selectObj = $("#" + elName + "Choose");
        selectObj.val(opt);
        var floatRate = $("#agentLayerCommon" + layerid).attr("floatStr");
        var linefloatRate = $("#agentLayerCommon" + layerid).attr("linefloatStr");
        if (opt == 0) {
            dataObj.hide();
            dataObj.attr("onblur", "");
            if (elName == "linefee") {
                $("#linefeeconfig").hide();
            }
        } else if (opt == 1) {
            dataObj.show();
            dataObj.attr("readonly", false);
            dataObj.css('background', '#ffffff');
            dataObj.attr("onblur", "overFormat(this)");

            dataObj.val(val * 100);
            if (elName == "linefee") {
                $("#linefeeconfig").hide();
            }
        } else if (opt == 2) {
            dataObj.show();
            dataObj.attr("readonly", true);
            dataObj.css('background', "#C0C0C0");
            dataObj.attr("onblur", "");
            if (elName == "linefee") {
                $("#linefeeconfig").show();
                dataObj.val(showRate(linefloatRate));
            } else {
                dataObj.val(showRate(floatRate));
            }
        }
    }

    $(document).ready(function () {
        $("#depositChoose").change(function () {
            var selectVal = $(this).children('option:selected').val();
            updateSelect(selectVal, "", "deposit");
        });
        $("#bonusChoose").change(function () {
            var selectVal = $(this).children('option:selected').val();
            updateSelect(selectVal, "", "bonus");
        });
        $("#rebateChoose").change(function () {
            var selectVal = $(this).children('option:selected').val();
            updateSelect(selectVal, "", "rebate");
        });
        $("#linefeeChoose").change(function () {
            var selectVal = $(this).children('option:selected').val();
            updateSelect(selectVal, "", "linefee");
        });

        $("#apportionModal").delegate("a", "click", function (o) {
            var modalTag = $(this).attr("modalTag");
            if (modalTag == "linefee") {
                $("#brokerageModalTitle").attr("modalTag", "linefee");
                var layerid = $("#apportionForm").attr("layerid");
                var lineFloatStr = $("#agentLayerCommon" + layerid).attr("linefloatStr");
                setFloatData(lineFloatStr);
            }
        });


    });
</script>