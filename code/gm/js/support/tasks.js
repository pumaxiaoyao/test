$(document).ready(function(){
	getSysMessage();
});
setInterval(function(){
	getTasks();
},1000);

function getT(){
	return parseInt(Date.parse(new Date())/1000);
}

function getLastTime(){
	var t = getCookie("l_t_t");
	if(t==null){
		t = getT() - 16; 
	}
	return t;
}

var lastTaskInfo = null;
function getTasks(){
	if(getT() - getLastTime() < 15){
		setOldTaskInfo();
	}else{
		getNewTaskInfo();
}

function setOldTaskInfo(){
		if(getCookie("l_t_d")!=null){
			var data = getCookie("l_t_d").split(',');
			var darr = "rega,wtda,wtdu,dptu,dptf,actv".split(',');
			for(var x=0;x<data.length;x++){
				if(data[x]==0){
					$("#"+darr[x]).hide();
					$("#"+darr[x]+"_n").html(0);
				}else{
					$("#"+darr[x]).show();
					$("#"+darr[x]+"_n").html(data[x]);
				}
			}
			var count = parseInt(data[0])+parseInt(data[1])+parseInt(data[2])+parseInt(data[3])+parseInt(data[5]);
			$("#tasksNum1").html(count);
			$("#tasksNum2").html(count);
		}
}

function getNewTaskInfo(){
		SetCookie("l_t_t",getT());
		$.ajax({
		url :"/site/getTaskList",
		type:'post',
		dataType:'json',
		success : function(d) {

			var rega,wtda,wtdu,dptu,dptf,actv;
			var crega = 0,cwtda = 0,cwtdu = 0,cdptu = 0,cdptf = 0,cactv = 0;
			var alltasks = [];
			rega = d['rega'];
			wtda = d['wtda'];
			wtdu = d['wtdu'];
			dptu = d['dptu'];
			dptf = d['dptf'];
			actv = d['actv'];

			if(rega!=false){
				crega = rega.length;
				$.each(rega,function(i,v){alltasks=alltasks.concat(v);});
			}
			if(wtda!=false){
				cwtda = wtda.length;
				$.each(wtda,function(i,v){alltasks=alltasks.concat(v);});
			}
			if(wtdu!=false){
				cwtdu = wtdu.length;
				$.each(wtdu,function(i,v){alltasks=alltasks.concat(v);});
			}
			if(dptu!=false){
				cdptu = dptu.length;
				$.each(dptu,function(i,v){alltasks=alltasks.concat(v);});
			}
			if(dptf!=false){
				//cdptf = dptf.length;
				$.each(dptf,function(i,v){alltasks=alltasks.concat(v);});
			}
			if(actv!=false){
				cactv = actv.length;
				$.each(actv,function(i,v){alltasks=alltasks.concat(v);});
			}
			var count = crega+cwtda+cwtdu+cdptu+cactv;
			var temp = "";
			$.each(alltasks,function(i,v){
				temp += temp==""?v.tid:","+v.tid;
			});
			$("#tasksNum1").html(count);
			$("#tasksNum2").html(count);
			$.each(d, function(i, v){
				if(v==false){
					$("#"+i).hide();
					$("#"+i+"_n").html(0);
				}else{
					$("#"+i).show();
					$("#"+i+"_n").html(v.length);
				}
			});
			if(lastTaskInfo==null){
			//runbell();
			}else{
			var b = false;
			$.each(alltasks,function(i,v){
				if(lastTaskInfo.indexOf(v.tid)==-1){
					b=true;
					return false;
				}
			});
			if(b)runbell();
			SetCookie("l_t_d",crega +","+ cwtda +","+ cwtdu +","+ cdptu +","+ cdptf +","+ cactv);
			}
			lastTaskInfo = temp.split(",");
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			if(XMLHttpRequest.status==403){
				top.window.location.href="/account/login";
			}
		},
		cache : false
	});
	}
}

function runbell() {
	var tipC = document.getElementById('tipControl')
	tipC.play();
}

function showTopMessageFunc(str){
	if($("#sysMessageList").find(".external").length==0&&sysMessageNum!=0){
		$("#sysMessageList").append('<li class="external"><h3>当前有游戏平台维护</h3></li>');
	}

	$("#sysMessageList").append(str);
	if(sysMessageNum!=0)$("#sysMessageNum").html(sysMessageNum);
}



var sysMessageNum = 0;
var sysMessageList = "";
function getSysMessage(){
// $.ajax({
// 		url :'/kzb/bc/mt?tps=30',
// 		type:'get',
// 		dataType: 'json',
// 		success : function(data) {
// 			if(data.code==0){
// 				var content="";
// 				sysMessageNum = sysMessageNum + data.data.length;
// 				$.each(data.data,function(i,v){
// 					var html='<li>';
// 					html+='<a href="/message/platform">';
// 					// html+='<span class="time">'+v.start+'-'+v.end+'</span>';
// 					html+='<span class="details">';
// 					html+='<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>';
// 					html+=v.title;
// 					html+='</span></a>';
// 					html+='</li>';
// 					content+=html;
// 				});
// 				showTopMessageFunc(content);
// 			}
// 		},
// 		cache : false
// 	});

$.ajax({
		url :'/kzb/bc/mt?new=1&tps=10,11,20,21,30,99,100',
		type:'get',
		dataType: 'json',
		success : function(data) {
			// if(data.code==0){
			// 	var content="";
			// 	var readids = getCookie('readids');
			// 	var ids = [];
			// 	if(readids!=null&&readids!=""){
			// 		ids = readids.split(",");
			// 	}
			// 	//sysMessageNum = sysMessageNum + data.data[0].length;
			// 			if(data.data[0]){
			// 				$.each(data.data[0],function(i,v){
			// 					if(ids.indexOf(v.id+"")==-1){
			// 						sysMessageNum = sysMessageNum + 1;
			// 					}
			// 					var html='<li>';
			// 						html+='<a href="/message/platform">';
			// 						// html+='<span class="time">'+v.start+'-'+v.end+'</span>';
			// 						html+='<span class="details">';
			// 						html+='<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>';
			// 						html+=v.title;
			// 						html+='</span></a>';
			// 						html+='</li>';
			// 						content+=html;
								
			// 				});
			// 			}

			// 			//if(data.data[1]){
			// 			//	sysMessageNum = sysMessageNum + data.data[1].length;
			// 			//	$.each(data.data[1],function(i,v){
			// 			//		var html='<li>';
			// 			//		html+='<a href="/message/platform">';
			// 			//		// html+='<span class="time">'+v.start+'-'+v.end+'</span>';
			// 			//		html+='<span class="details">';
			// 			//		html+='<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>';
			// 			//		html+=v.name +'-' + (v.flag==2?'维护中':v.start+'维护');
			// 			//		html+='</span></a>';
			// 			//		html+='</li>';
			// 			//		content+=html;
			// 			//	});
			// 			//}

			// 			if(data.data[2]){
			// 				$.each(data.data[2],function(i,v){
			// 					if(v.id!="5707231341449216"&&v.id!="285467739648"){
			// 						if(ids.indexOf(v.id+"")==-1){
			// 							sysMessageNum = sysMessageNum + 1;
			// 						}
			// 						var html='<li>';
			// 							html+='<a href="/message/platform">';
			// 							// html+='<span class="time">'+v.start+'-'+v.end+'</span>';
			// 							html+='<span class="details">';
			// 							html+='<span class="label label-sm label-icon label-danger"><i class="fa fa-bolt"></i></span>';
			// 							html+=v.name +'-' + (v.flag==2?'维护至':v.start+'维护') + v.end;
			// 							html+='</span></a>';
			// 							html+='</li>';
			// 							content+=html;
			// 					}
								
			// 				});
			// 			}

					
			// 	showTopMessageFunc(content);
			// }
		},
		cache : false
	});
}

function clearNoNum(obj){
    obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符  
    obj.value = obj.value.replace(/^\./g,"");  //验证第一个字符是数字而不是. 
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的.   
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    if(obj.value=="")obj.value=0;
}

function SetCookie(name,value) 
{ 
    var Days = 365; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";path=/;expires=" + exp.toGMTString(); 
} 


function delCookie(name)
{
var exp = new Date();
exp.setTime(exp.getTime() - 1);
var cval=getCookie(name);
if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

function getCookie(name)
{
var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
if(arr != null)
return unescape(arr[2]);
return null;
}
