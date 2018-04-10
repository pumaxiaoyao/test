/**
 * Created by cz on 15/4/15.
 */


$(function(){
    $('#add_agent_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            aname: {
                username: true,
                required: true
            },
            apwd:{
                required:true,
                password:true
            },
            password1:{
                required:true,
                equalTo:'#apwd',
                password:true
            }
        },

        errorPlacement: function (error, element) { // render error placement for each input type
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight

        },

        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            icon.removeClass("fa-warning").addClass("fa-check");
        }
    });
});


$(function(){
    $('#birthday').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
});

function addAgent(){

    var flag = $('#add_agent_form').valid();
    if(flag){
        var formData = $('#add_agent_form').serialize();

        $.post('/agent/addAgent',formData,function(rep){
            var data = JSON.parse(rep);
            data = data.data;
            if (data.code == 200) {
                window.location.href='/agent/verify';
                $.notific8('添加代理成功！');
            }else{
                $.notific8(data.Message, {theme: 'ebony'});
            }
        });
    }
}

function parseISO8601(dateStringInRange) {
    var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,
        date = new Date(NaN), month,
        parts = isoExp.exec(dateStringInRange);
    if(parts) {
        month = +parts[2];
        date.setFullYear(parts[1], month - 1, parts[3]);
        if(month != date.getMonth() + 1) {
            date.setTime(NaN);
        }
    }
    return date;
}