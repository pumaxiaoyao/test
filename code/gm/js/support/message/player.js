$(document).ready(function () {
    $("#s_search").search();

    $('#groupBtn').on('click', function () {
        $('#groupModal').modal();
    });

    $("#selectplayer").select2({
        ajax: {
            url: "/player/listAjaxS",
            dataType: 'json',
            //delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: function (repo) {
            return repo.name;
        },
        templateSelection: function (repo) {

            if (nowSelectPlayer != repo.id) {
                nowSelectPlayer = repo.id;
                if ($('#usernames').val() != "") {
                    $('#usernames').append('\n');
                }
                if (repo.name)$('#usernames').append(repo.name);
            }
            return repo.name || repo.text;
        }
    });
});

var nowSelectPlayer = 0;

function sendGroupMessage() {
    $.blockUI({baseZ: 20000});
    var title = $('#groupTitle').val();
    var content = $('#groupContent').val();
    var groupIds = '';
    $("input[name=group]:checked").each(function () {
        groupIds += $(this).val() + ',';
    });
    $.post('/message/sendGroup', {title: title, content: content, groupIds: groupIds}, function (data) {
        if (data.success) {
            $.notific8(data.msg);
            $("#s_submit").click();
            $('#groupModal').modal('hide');
        } else {
            $.notific8(data.msg, {theme: 'ebony'});
        }
        $.unblockUI();
    });
}

function sendMessage(data, flag) {

    if (data == '' || $("#messagecontent").val() == "" || $("#messagetitle").val() == "") {
        $.notific8("请选择发送对象并完善内容！", {theme: 'ebony'});

        return false;
    }


    udata = data.split('\n');
    listaddresults = new Array();
    listaddresultr = new Array();
    //开始
    $.blockUI({baseZ: 20000});
    $(document).queue([]);

    $(udata).each(function (i, v) {
        $(document).queue("ajaxRequests", function () {
            var uid = udata[i].split(':')[1];
            var uname = udata[i].split(':')[0];
            if (uid == '未找到该用户') {
                listaddresultr.push(udata[i]);
                $(document).dequeue("ajaxRequests");
            } else {
                $.ajax({
                    url: "/message/addPlayerMessage",
                    type: 'post',
                    dataType: 'json',
                    data: {playerid: uid, content: $("#messagecontent").val(), title: $("#messagetitle").val()},
                    success: function (data) {
                        $.unblockUI();
                        if (data.c == 0) {
                            listaddresults.push(uname);
                        } else {
                            listaddresultr.push(uname);
                        }
                        $(document).dequeue("ajaxRequests");
                    },
                    error: function () {
                        listaddresultr.push(uname);
                        $(document).dequeue("ajaxRequests");
                    },
                    cache: false
                });
            }
        });
    });

    $(document).dequeue("ajaxRequests");
    $(document).queue("ajaxRequests", function () {
        if (listaddresultr.length > 0) {
            $('#usernames').val(listaddresultr.toString().replace(/,/g, '\n'));
            alert('共成功' + listaddresults.length + '个用户,已将失败用户重新填写到用户输入框');
        } else {
            alert('共成功' + listaddresults.length + '个用户');
            $(flag).next().click();
        }
        $("#s_submit").click();
        $.unblockUI();
    });

}

//用户名检查
function CheckUsername(o) {
    var usernames = $('#usernames').val().toLowerCase();
    if (usernames == "") {
        $.notific8("请输入正确的用户名列表", {theme: 'ebony'});
        return false;
    }
    $.blockUI({baseZ: 20000});
    usernames = usernames.split('\n');
    $(usernames).each(function (i, v) {
        usernames[i] = v.replace(/ /g, '');
        if (v.indexOf(":") != -1 && v != "") {
            usernames[i] = v.split(":")[0];
        }
    });
    usernames = uniq(usernames);
    $.ajax({
        url: '/player/findplayerbynames',
        type: 'post',
        data: "usernames=" + usernames.toString(),
        dataType: 'json',
        success: function (data) {
            var reallist = new Array();
            if (data.length == 0) {
                $.notific8("未找到有效的用户", {theme: 'ebony'});
                $.unblockUI();
                return false;
            }

            $(usernames).each(function (i, v) {
                reallist[i] = new Array();
                reallist[i]['name'] = v;
                reallist[i]['id'] = 0;
                $(data).each(function (ii, vv) {
                    if (v == data[ii]['playername']) {
                        reallist[i]['id'] = data[ii]['playerid'];
                    }
                });
            });
            var out = '';
            reallist = reallist.sort();
            $(reallist).each(function (i, v) {
                var d = reallist[i];
                var id = d['id'] == 0 ? '未找到该用户' : d['id'];
                out += out == '' ? (d['name'] + ':' + id) : ('\n' + d['name'] + ':' + id);
            });
            $('#usernames').val(out);
            $.unblockUI();
            if (out == ":未找到该用户") {
                $.notific8("请输入正确的用户名列表", {theme: 'ebony'});
            } else {
                sendMessage(out, o);
            }
        },
        error: function () {
            $.unblockUI();
            $.notific8("查询用户失败，请稍后再试", {theme: 'ebony'});
        },
        cache: false
    });
}
//数组去重
var uniq = function (arr) {
    var a = [],
        o = {},
        i,
        v,
        len = arr.length;
    if (len < 2) {
        return arr;
    }
    for (i = 0; i < len; i++) {
        v = arr[i];
        if (o[v] !== 1) {
            a.push(v);
            o[v] = 1;
        }
    }
    return a;
}