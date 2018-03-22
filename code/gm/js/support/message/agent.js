$(document).ready(function() {
	$("#s_search").search();

	$("#selectagent").select2({
	  ajax: {
	    url: "/agent/listAjax",
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
	  escapeMarkup: function (markup) { return markup; }, 
	  minimumInputLength: 1,
	  templateResult: function(repo){return repo.name;},
	  templateSelection: function(repo){
		  nowSelectAgent = repo.id;
	      return repo.name || repo.text;
  	  } 
	});
});

var nowSelectAgent = 0;

function sendMessage(flag){
	
	if(nowSelectAgent==0||$("#messagecontent").val()==""||$("#messagetitle").val()==""){
		$.notific8("请选择发送对象并完善内容！", {theme: 'ebony'});
		return false;
	}
	$.blockUI();
	$.ajax({
		url :"/message/addAgentMessage",
		type:'post',
		dataType:'json',
		data:{agentid:nowSelectAgent,content:$("#messagecontent").val(),title:$("#messagetitle").val(),agentNames:$('#agentNames').val()},
		success : function(data) {
			$.unblockUI();
			if(data.c==0){
				$.notific8("操作成功");
				$("#s_search").search();
			}else{
				$.notific8(data.m, {theme: 'ebony'});
			}
			$(flag).next().click();
			$("#s_submit").click();
		},
		cache : false
	});
}
