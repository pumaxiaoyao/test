var Login = function () {
    return {
        //main function to initiate the module
        init: function () {
        	
           $('.login-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                csname: {
	                    required: true
	                },
	                cspwd: {
	                    required: true
	                },
	                verifycode: {
	                    required: false
	                }
	            },

	            messages: {
	                csname: {
	                    required: "请输入用户名."
	                },
	                cspwd: {
	                    required: "请输入密码."
	                },
	                verifycode: {
	                    required: "请输入验证码."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-error', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {

					var name = $('#csname').val();
					var pwd = $('#cspwd').val();
					var verifycode = $('#verifycode').val();
					$.ajax({
						url: '/kzb/admin/login?r=' + Math.random(),
						type: 'post',
						data: {"csname":name, "cspwd":pwd, "verifycode":verifycode},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							console.log("error login.");
							console.log(textStatus);
							console.log(errorThrown);
							//enable_login(login_btn,member_login);
						},
						success: function (da) {
							da = JSON.parse(da);						
							if(da.c == 0){
								alert("登录成功！");
								window.location.href='/message/platform';
							}else if(da.c == 1007){
								alert("用户名或密码错误，您还可以登录"+da.m+"次");
								$("#vcode").attr('src','/kzb/admin/verifycode');//?'+Math.random());
							}else{
								alert(errorMsg(da));
								$("#vcode").attr('src','/kzb/admin/verifycode');//?'+Math.random());
							}
						}
					});
				},
		   }),
	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                	 $('.login-form').submit(); // 会调用submitHandle
	                }
	                return false;
	            }
	        });
        }
    };
}();

function result(da,key){
    var code = da.c;
    var msg = getError(code,key);
    notify(msg);
}

$(document).ready(function(){
	$("#vcode").click(function(){
		$(this).attr('src','/kzb/admin/verifycode');//?'+Math.random());
	});
});