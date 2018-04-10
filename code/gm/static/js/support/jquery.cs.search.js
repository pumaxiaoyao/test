var target = [];

(function ($) {
    $.fn.extend({
        search: function (options) {
            var action = $(this).attr("action");
            if (!action || action == '#') {
                // console.log("url error! action:" + action);
                return;
            }

            var queryData = {};
            var _fnCallback = function (resp) {
            };

            function fnServerData(sSource, aoData, fnCallback) {
                queryData['data'] = aoData;
                $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": queryData,
                    "success": function (resp) {
                        fnCallback(resp);
                        _fnCallback(resp);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.log(textStatus);
                        if (XMLHttpRequest.status == 403) {
                            top.window.location.href = "/account/login";
                        }
                    },
                    cache: false
                });
            }

            var defaults = {
                "oLanguage": {
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "抱歉， 没有找到",
                    "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                    "sInfoEmpty": "没有数据",
                    "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    },
                    "sZeroRecords": "没有检索到数据",
                    "oAria": {
                        "sSortAscending": " - click/return to sort ascending",
                        "sSortDescending": " - click/return to sort descending"
                    },
                    "sProcessing": "正在加载,请稍等...."
                },
                "bServerSide": true,
                "bSort": false, // 排序功能
                "bLengthChange": true,
                "aLengthMenu": [[20, 50, 100], [20, 50, 100]],// 定义每页显示数据数量
                "sAjaxSource": action,
                // *如果加上下面这段内容，则使用post方式传递数据
                "fnServerData": fnServerData,
                "bStateSave": false,// 状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容
                'bPaginate': true, // 是否分页。
                "bProcessing": true, // 当datatable获取数据时候是否显示正在处理提示信息。
                'bFilter': false, // 是否使用内置的过滤功能
                "iDisplayLength": 20, // 单页行数的初始值
                "bInfo": true,// 页脚信息
                "bAutoWidth": false,// 自动宽度
                "sPaginationType": "bootstrap2", // 分页样式 full_numbers
                "param": null,
                "_fnCallback": null,
                "aoColumnDefs": null//隐藏列
            };

            var defaults_en = {
                "oLanguage": {
                    "sLengthMenu": "Display _MENU_ records",
                    "sZeroRecords": "No matching records found",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "sInfoEmpty": "No entries to show",
                    "sInfoFiltered": "(filtered from _MAX_ total entries)",
                    "oPaginate": {
                        "sFirst": "First",
                        "sPrevious": "Previous",
                        "sNext": "Next",
                        "sLast": "Last"
                    },
                    "sZeroRecords": "No matching records found",
                    "oAria": {
                        "sSortAscending": " - click/return to sort ascending",
                        "sSortDescending": " - click/return to sort descending"
                    },
                    "sProcessing": "Processing..."
                },
                "bServerSide": true,
                "bSort": false, // 排序功能
                "bLengthChange": true,
                "aLengthMenu": [[20, 50, 100], [20, 50, 100]],// 定义每页显示数据数量
                "sAjaxSource": action,
                // *如果加上下面这段内容，则使用post方式传递数据
                "fnServerData": fnServerData,
                "bStateSave": false,// 状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容
                'bPaginate': true, // 是否分页。
                "bProcessing": true, // 当datatable获取数据时候是否显示正在处理提示信息。
                'bFilter': false, // 是否使用内置的过滤功能
                "iDisplayLength": 20, // 单页行数的初始值
                "bInfo": true,// 页脚信息
                "bAutoWidth": false,// 自动宽度
                "sPaginationType": "bootstrap2", // 分页样式 full_numbers
                "param": null,
                "_fnCallback": null,
                "aoColumnDefs": null//隐藏列
            };


            if(la_language=='en'){
                defaults = defaults_en;
            }

            var options = $.extend(defaults, options);

            if (options['_fnCallback'] == undefined
                || options['_fnCallback'] == "undefined"
                || options['_fnCallback'] == null) {
                _fnCallback = function () {
                };
            } else {
                _fnCallback = options['_fnCallback'];
            }
            var datatable = null;

            function _search() {
                queryData['s_btype'] = "";

                var s_search = 's_search';
                if('s_search' in options){
                    s_search = options['s_search'];
                }

                $.each($("#"+s_search).formToArray(), function (i, n) {
                    if (n.name == "s_btype") {
                        if (queryData[n.name] == undefined)queryData[n.name] = "";
                        queryData[n.name] = queryData[n.name] == "" ? n.value : queryData[n.name] + "," + n.value;
                    } else {
                        queryData[n.name] = n.value;
                    }
                });

                if (datatable == undefined || datatable == "undefined"
                    || datatable == null) {

                } else {
                    datatable.fnDestroy();
                }

                var data = 'data';
                if('tbId' in options){
                    data = options['tbId'];
                }

                //特殊处理，非fnreload的时候，清除定位。
                var curl = window.location.href.split("/");
                var path = curl[curl.length-2];
                var ckeys=document.cookie.match(/[^ =;]+(?=\=)/g); 
                var cfstring = "SpryMedia_DataTables_";
                if (ckeys) { 
                for (var i = ckeys.length; i--;) 
                    if(ckeys[i].substr(0,cfstring.length)==cfstring){
                    document.cookie=ckeys[i]+'=0;path=/'+path+'/;expires=' + new Date(0).toUTCString();
                    }
                } 


                datatable = $('#'+data).dataTable({
                    "sCookiePrefix": "SpryMedia_DataTables_"+new Date().getTime()+"_",
                    "bRetrieve": true,
                    "oLanguage": options['oLanguage'],
                    "bServerSide": options['bServerSide'],
                    "bSort": options['bSort'], // 排序功能
                    "bLengthChange": options['bLengthChange'],
                    "aLengthMenu": options['aLengthMenu'],// 定义每页显示数据数量
                    "sAjaxSource": options['sAjaxSource'],
                    // *如果加上下面这段内容，则使用post方式传递数据
                    "fnServerData": options['fnServerData'],
                    "bStateSave":true,// 状态保存，使用了翻页或者改变了每页显示数据数量，会保存在cookie中，下回访问时会显示上一次关闭页面时的内容
                    'bPaginate': options['bPaginate'], // 是否分页。
                    "bProcessing": options['bProcessing'], // 当datatable获取数据时候是否显示正在处理提示信息。
                    'bFilter': options['bFilter'], // 是否使用内置的过滤功能
                    "iDisplayLength": options['iDisplayLength'], // 单页行数的初始值
                    "bInfo": options['bInfo'],// 页脚信息
                    "bAutoWidth": options['bAutoWidth'],// 自动宽度
                    "sPaginationType": options['sPaginationType'], // 分页样式
                    "aoColumnDefs": options['aoColumnDefs']//隐藏列
                });

                if('target' in options){
                    target[options['target']] = datatable;
                }else{
                    target[1] = datatable;
                }
            }
            _search();
            $(this).on("submit", function (e) {
                _search();
                return false;
            });
            return $(this);
        }
    });
})(jQuery);