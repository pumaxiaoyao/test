<?php     
session_start();

function showHeader(){
    $page = file_get_contents('./html/header.html');
    echo $page;
};

function showSportsPage(){
    $page = file_get_contents('./html/sportsbook.html');
    echo $page;
};

function showFooter(){
    $page = file_get_contents('./html/footer.html');
    echo $page;
};

function showSports(){
    $header = showheader();
    $page = showSportsPage();
    $footer = showFooter();
    echo $header.$page.$footer;
};

function showIndex(){
    $page = file_get_contents('./html/index.html');
    echo $page;
};

function showLogin(){
    $acc = $_SESSION["account"];
    $pwd = $_SESSION["password"];
    echo "account is ".$acc.", and password is ".$pwd;
}

function send_post($url, $post_data){
    //$postdata = http_build_query($post_data);
    $post_json = json_encode($post_data);
    echo $post_json;
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-type:application/json;charset=utf-8",
            "content"=> $post_json,
            "timeout"=> 5
            )
        );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

function showTestLogin(){
    echo '准备跳转登录';
    // echo "<meta http-equiv=\"refresh\" content=\"0.5;url=/login.php\">"; 
    $logindata = array(1,2,3,"4");
    echo send_post('http://192.168.0.107:7878', $logindata);
}

function showTest(){
    $page = "<form action='index.php' method='post'>
    <input type='hidden' value='login' name='m'/>
    <input type='submit' value='发送' />
    </form>";
    echo $page;
}
function showTestArgus(){
    $args1 = $_POST['argus1'];
    $args2 = $_POST['argus2'];
    $args3 = $_POST['argus3'];
    
    echo json_encode(array('args1'=>$args1, 'args2'=>$args2, 'args3'=>$args3));
}
function showTest2(){
    $page = "<form action='index.php' method='post'>
    参数1：<input type='text' value='argus1' name='argus1'/><br/>
    参数2：<input type='text' value='argus2' name='argus2'/><br/>
    参数3：<input type='text' value='argus3' name='argus3'/><br/>
    <input type='submit' value='发送' />
    </form>";
    echo $page;
}

function showSportsBook(){
    $url = "http://xj-sb-asia.prdasbbwla1.com/zh-cn/default.html";
    echo file_get_contents($url, false);
}

function showTestSports(){

}

function showTest3(){
    $header = showheader();
    $page = showIndex();
    $footer = showFooter();
    echo $header.$page.$footer;
}

if (isset($_POST['m'])){
    showTestLogin();
	exit;
}elseif(isset($_POST['argus1'])){
    showTestArgus();
    exit;
}elseif(isset($_GET['page'])){
    $PAGECODE = $_GET['page'];
    switch ($PAGECODE){
        case "1":
            showIndex();
            break;
        case "2":
            showTest2();
            break;
        case "index":
            showTest3();
            break;
        case "sports":
            // showTest3();
            showSports();
            break;
        case "sportsbook":
            showSportsBook();
            break;
        case "3":
            showTestSports();
            break;
    }
    exit;
}else{
    showTest();
    exit;
};
?>   