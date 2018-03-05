<link href="/static/css/bootstrap.min.css" rel="stylesheet" /><link href="/static/css/index.css" rel="stylesheet" /><link href="/static/css/slots.css" rel="stylesheet" />
        <script type="text/javascript" src="/static/js/ptslot.js"></script>
        <script type="text/javascript" src="/static/js/animateBackground-plugin.js"></script>

        <script type="text/javascript">
        var num = 2318875300;
        $(function(){
        	getdata();

        	setInterval('getdata()', 3000);
        });

        function getdata(){
            var numpot  =Math.floor(Math.random()*1000)

                num=    num +numpot;
        	show_num(num)
//        	$.ajax({
//        	    url: 'data.php',
//        		type: 'POST',
//        		dataType: "json",
//        		data:{'total':num},
//        		cache: false,
//        		timeout: 10000,
//        		error: function(){},
//        		success: function(data){
//        			show_num(data.count);
//        	    }
//           	});
        }

        function show_num(n){
        	var it = $(".t_num i");
        	var len = String(n).length;
        	for(var i=0;i<len;i++){
        		if(it.length<=i){
        			$(".t_num").append("<i></i>");
        		}
        		var num=String(n).charAt(i);
        		var y = -parseInt(num)*30;
        		var obj = $(".t_num i").eq(i);
        		obj.animate({
        			backgroundPosition :'(0 '+String(y)+'px)'
        			}, 'slow','swing',function(){}
        		);
        	}
        	$("#cur_num").val(n);
        }
        </script>

