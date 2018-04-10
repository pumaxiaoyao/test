<script type="text/javascript">
    var _has_bbin_gp_ = false;
            var _has_bbin_ac_ = false;
            var _bbin_gpid = ['350808494186210', '350808494186211', '350808494186212', '350808494186213', '350808494186214',
                '350808494186215'
            ];
            $(document).ready(function () {
                $.ajax({
                    url: '/home/mt',
                    type: 'post',
                    data: {new:1, tps:"10,11,20,21,30,99,100"}
                    dataType: 'json',
                    success: function (data) {
                        var resp = data.data;
                        if (resp[0]){
                            return ;
                        } else {
                            return ;
                        }


                        if (data.code == 0) {
                            var bbin_count = 0;
                            $.each(data.data[1], function (i, v) {
                                var is_bbin = _bbin_gpid.indexOf(v.id) >= 0;
                                if (is_bbin) {
                                    bbin_count++;
                                }
                            });
                            if (bbin_count == 5) { //判断是不是所有的都在维护
                                _has_bbin_gp_ = true;
                            }
                            var content = "";
                            var readids = "";
                            if (data.data[0]) {
                                $.each(data.data[0], function (i, v) {
                                    var st = v.start == "0" ? '长期' : formatDateDW(new Date(v.start * 1000));
                                    var et = v.end == "0" ? '长期' : formatDateDW(new Date(v.end * 1000));
                                    readids += readids == "" ? v.id : ',' + v.id;
                                    var html = '<div class="alert alert-info">';
                                    html += '<h3>' + v.title + '</h3>';
                                    html += '<h4>' + st + ' ------ ' + et + '</h4>';
                                    html += '<p>';
                                    html += v.content;
                                    html += '</p>';
                                    html += '<h5>游戏平台</h5>';
                                    html += '</div>';
                                    content += html;
                                });
                            }
                            //				if(data.data[1]){
                            //					$.each(data.data[1],function(i,v){
                            //						var is_bbin = _bbin_gpid.indexOf(v.id) >= 0;
                            //						if(!is_bbin || !_has_bbin_gp_){
                            //							var html='<div class="alert alert-info">';
                            //							html+='<strong>'+v.start+'-'+v.end+'</strong>';
                            //							html+='<strong>'+v.name +'-' + (v.flag==2?'维护中':'即将开始维护')+'</strong>';
                            //							html+='<p>';
                            //							html+=v.content;
                            //							html+='</p>';
                            //							html+='<h5>游戏</h5>';
                            //							html+='</div>';
                            //							content+=html;
                            //							if(is_bbin){
                            //								_has_bbin_gp_ = true;
                            //							}
                            //						}
                            //
                            //					});
                            //				}
                            if (data.data[2]) {
                                $.each(data.data[2], function (i, v) {
                                    readids += readids == "" ? v.id : ',' + v.id;
                                    var is_bbin = _bbin_gpid.indexOf(v.id) >= 0;
                                    if (!is_bbin || !_has_bbin_ac_) {
                                        var st = v.start.length == 8 ? '每天 ' + v.start : formatDateDW(new Date(v.start.replace(/-/g, '/')));
                                        var et = v.end.length == 8 ? '每天 ' + v.end : formatDateDW(new Date(v.end.replace(/-/g, '/')));
                                        var html = '<div class="alert alert-info">';
                                        html += '<h3>' + v.name + ' ------ ' + (v.flag == 2 ? '维护中' : '即将开始维护') + '</h3>';
                                        html += '<h4>' + st + ' ------ ' + et + '</h4>';
                                        html += '<p>';
                                        html += v.content;
                                        html += '</p>';
                                        html += '<h5>游戏平台</h5>';
                                        html += '</div>';
                                        content += html;
                                        if (is_bbin) {
                                            _has_bbin_ac_ = true;
                                        }
                                    }
                                });
                            }
                            $("#msgs").append(content);
                            SetCookie('readids', readids);
                        }
                    },
                    cache: false
                });
            });
</script>