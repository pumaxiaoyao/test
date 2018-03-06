function referto(page) {
    if (page == "bm") {
        var html = '<iframe style="height:1080px;width:100%" src="bmtest.php" />';
    } else if (page == "login") {
        var html = '<iframe style="height:1080px;width:100%" src="logintest.php" />';
    } else if (page == "reco") {
        var html = '<iframe style="height:1080px;width:100%" src="recotest.php" />';
    } else if (page == "php") {
        var html = '<iframe style="height:1080px;width:100%" src="httpsTest.html" />';
    }
    document.getElementById("page").innerHTML = html;
}

function genLoginMd5() {
    var action = document.getElementById("action").value;
    var uno = document.getElementById("uno").value;
    var pw = document.getElementById("pw").value;
    var refurl = document.getElementById("refurl").value;

    var postStr = "a="+action+"&uno=" + uno + "&pw=" + pw + "&refurl=" + refurl;
    ajax("/genmd5.php", postStr, function (result) {
        console.log(result);
        document.getElementById("signstr").value = result;
        // document.getElementById("urlall").value = result;
    });
}

function genRecoMd5(){
    var action = document.getElementById("action").value;
    var uno = document.getElementById("uno").value;
    var recoid = document.getElementById("recoid").value;
    var date = document.getElementById("dt").value;
    var gameType = document.getElementById("gametype").value;

    var postStr = "a="+action+"&uno=" + uno + "&recoid=" + recoid + "&dt=" + date+ "&gametype=" + gameType;
    ajax("/genmd5.php", postStr, function (result) {
        console.log(result);
        document.getElementById("signstr").value = result;
    });
}

function genBmMd5(){
    var action = document.getElementById("action").value;
    var uno = document.getElementById("uno").value;
    var pwd = document.getElementById("pw").value;
    var opstyle = document.getElementById("opstyle").value;
    var qty = document.getElementById("qty").value;
    var orderid = document.getElementById("orderid").value;

    var postStr = "a="+action+"&uno=" + uno + "&pw=" + pwd + "&opstyle=" + opstyle+ "&qty=" + qty+ "&orderid=" + orderid;
    ajax("/genmd5.php", postStr, function (result) {
        console.log(result);
        document.getElementById("signstr").value = result;
    });
}

function ajax(url, postStr, onsuccess) {
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //创建XMLHTTP对象，考虑兼容性。XHR
    xmlhttp.open("POST", url, true); //“准备”向服务器的GetDate1.ashx发出Post请求（GET可能会有缓存问题）。这里还没有发出请求

    //AJAX是异步的，并不是等到服务器端返回才继续执行
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) //readyState == 4 表示服务器返回完成数据了。之前可能会经历2（请求已发送，正在处理中）、3（响应中已有部分数据可用了，但是服务器还没有完成响应的生成）
        {
            if (xmlhttp.status == 200) //如果Http状态码为200则是成功
            {
                onsuccess(xmlhttp.responseText);
            } else {
                alert("AJAX服务器返回错误！");
            }
        }
    }
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //不要以为if (xmlhttp.readyState == 4) {在send之前执行！！！！
    xmlhttp.send(postStr); //这时才开始发送请求。并不等于服务器端返回。请求发出去了，我不等！去监听onreadystatechange吧！
}