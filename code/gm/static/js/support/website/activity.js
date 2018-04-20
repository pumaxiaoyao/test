KindEditor.ready(function(K) {
    window.editor = K.create('#editor_id',

    {
        afterBlur: function () { this.sync(); },
        allowImageUpload:false,
        allowFlashUpload:false,
        allowMediaUpload:false,
        allowFileUpload:false,
        allowFileManager:false
    });
});


$(document).ready(function(){
    
    $('#activityPic').uploadify({
        'formData'     : {
        },
        'swf'      : '/static/js/uploadify/uploadify.swf',
        'uploader' : '/activity/uploadPic',
        'buttonText'    :   '选择照片',  
        'method'        :   'post',  
        'buttonClass'   :  'upload_button',  
        'fileTypeDesc'  :   '图片文件',  
        'fileTypeExts'  :   '*.gif;*.jpg;*.png;*.bmp', 
        "onUploadSuccess" : function(file, data, response) { // 上传成功回调函数
            data = JSON.parse(data);
            data = data.data;
            $('#activityPicShow').attr('src', data.path).show();
            $('#picUrl1').val(data.path);
        },
        "onUploadError": function(file, errorCode, errorMsg, errorString) { // 上传失败回调函数
            $('#activityPicShow').attr('src', '').hide();
            $('#activityPic').val('');
            $('#picUrl1').val('');
            alert('上传失败，请重试！');
        }
    });
    
    $('#headActivityPic').uploadify({
        'formData'     : {
        },
        'swf'      : '/static/js/uploadify/uploadify.swf',
        'uploader' : '/activity/uploadPic',
        'buttonText'    :   '选择照片',  
        'method'            :   'post',  
        'buttonClass'   :  'upload_button',  
        'fileTypeDesc'  :   '图片文件',  
        'fileTypeExts'  :   '*.gif;*.jpg;*.png;*.bmp',  
        "onUploadSuccess" : function(file, data, response) { // 上传成功回调函数
            data = JSON.parse(data);
            data = data.data;
            $('#headActivityPicShow').attr('src', data.path).show();
            $('#picUrl2').val(data.path);
        },
        "onUploadError": function(file, errorCode, errorMsg, errorString) { // 上传失败回调函数
            $('#headActivityPicShow').attr('src', '').hide();
            $('#headActivityPic').val('');
            $('#picUrl2').val('');
            alert('上传失败，请重试！');
        }
    });

    if($('#status_list').find('span.checked').length == 0){
        $('#status_list').find('div.radio > span:first').addClass('checked').click();
    }

    if($('#type_list').find('span.checked').length == 0){
        $('#type_list').find('div.radio > span:first').addClass('checked').click();
    }

    initGroupinfo();
    initAgentInfo();

    $("#selectagent").select2({
        theme: "classic",
      ajax: {
        url: "/agent/listAjaxS",
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
      templateResult: function(repo){return repo.code;},
      templateSelection: function(repo){
          nowSelectAgent = repo.id;
          nowSelectAname = repo.code;
          return repo.id || repo.text;
      }
    });

    $("input[name=group]").change(function(){initGroupinfo()});

    $("#headActivitySelect").change(function(){
        checkHeadActivity();
    });

    checkHeadActivity();
    redirectURL();
});

function checkHeadActivity(){
    if ($("#headActivity").val() == "1") {
        $("#headActivityUpload").css("display", "block");;
        $("#headActivityShow").css("display", "block");;
    } else {
        $("#headActivityUpload").css("display", "none");
        $("#headActivityShow").css("display", "none");
    }
}

function redirectURL() {
    if ($("#redirect_to").val() == "2") {
        $(".redirect_url_column").css("display", "block");
    } else {
        $(".redirect_url_column").css("display", "none");
    }
}

var nowSelectAgent = 0;var nowSelectAname = "";
$("#addagent").click(function(){
    // roleIds.push( parseInt($("#selectagent").select2('val')) );
    // console.log(roleIds);
    if(nowSelectAgent!=0&&nowSelectAgent){
        if($("#agentlist").find("a[actid="+nowSelectAgent+"]").length==0)addAgent(nowSelectAgent,nowSelectAname);
    }
});



function addAgent(id,name){
    $("#agentlist").append("<A href='javascript:void(0);' style='padding:10px;' onclick='$(this).remove();initAgentInfo();' actid='"+id+"'><i class='fa fa-check-square-o'></i>"+name+"</a>");
    initAgentInfo();

}


$('#activity_edit').ajaxForm({
    beforeSubmit: function (arr, $form, options) {
        $.blockUI();

    },
    error: function () {
        $.unblockUI();
    },
    success: function (data) {
        $.unblockUI();
        
        if (data[0]) {
            
            $.notific8('编辑活动成功！');
            history.back();
            // window.location.href='/activity/activities';
        }else{
            $.notific8("error", {theme: 'ebony'});
        }
    }
});

// 初始化用户层级选择的信息
function initGroupinfo(){

    var groupids=[];
    $("input[name=group]:checked").each(function(){
        groupids.push(parseInt($(this).val()));
    });
    var groupidsStr = (groupids[0] && groupids[0] !="") ? JSON.stringify(groupids) : "";
    $("#groupids").val(groupidsStr);

}

// 初始化代理选择的信息
function initAgentInfo(){
    var roleIds=[];
    $("#agentlist a").each(function( index, element){
        // roleIds.push(parseInt($(this).val()));
        roleIds.push( parseInt( $(this).attr('actid') ) );
    });
    var roleIdsStr = (roleIds[0] && roleIds[0] != "") ? JSON.stringify(roleIds) : "";
    $("#agentcodes").val(roleIdsStr);
}
