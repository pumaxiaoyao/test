<?php     
session_start();

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


function makePage($headtpl, $contenttpl, $foottpl){
    $Header = file_get_contents('./html/header.html');
    if (strlen($headtpl) > 0){
        $HeaderScriptContent = file_get_contents('./html/tpl/'.$headtpl.'.tpl');
    }else{
        $HeaderScriptContent = '';
    }
    $Header = str_replace('%HeaderScriptContent%', $HeaderScriptContent,  $Header);  
    
    $Footer = file_get_contents('./html/footer.html');
    if (strlen($foottpl) > 0){
        $FooterScriptContent = file_get_contents('./html/tpl/'.$foottpl.'.tpl');
    }else{
        $FooterScriptContent = '';
    }
    $Footer = str_replace('%FooterScriptContent%',$FooterScriptContent,  $Footer);  

    $Page = file_get_contents('./html/'.$contenttpl.'.html');
    return $Header.$Page.$Footer;

}
function showIndexPage(){
    echo makePage('HomePageHeader', 'index', 'HomePageFooter');
};

function showSportsBook(){
    echo makePage('SportsBookHeader', 'sportsbook', 'SportsBookFooter');
};

function showCasino(){
    echo makePage('CasinoHeader', 'casino', 'CasinoFooter');
};

function showkeno(){
    echo makePage('KenoHeader', 'keno', 'KenoFooter');
};

function showHuntFish(){
    echo makePage('', 'huntfish', 'HuntFishFooter');
};

function showSlots(){
    echo makePage('SlotHeader', 'slots', '');
};

function showPromotions(){
    echo makePage('PromotionsHeader', 'promotions', 'PromotionsFooter');
}

function getProductLogin(){

}

if(isset($_GET['p'])){
    $PAGECODE = $_GET['p'];
    switch ($PAGECODE){
        case "index":
            showIndexPage();
            break;
        case "sportsbook":
            showSportsBook();
            break;
        case "casino":
            showCasino();
            break;
        case "keno":
            showkeno();
            break;
        case "huntfish":
            showHuntFish();
            break;
        case "slots":
            showSlots();
            break;
        case "promotions":
            showPromotions();
            break;
        default:
            showIndexPage();
            break;
    }
    exit;

}elseif(isset($_GET['t'])){
    $PAGECODE = $_GET['t'];
    switch ($PAGECODE){
        case "test1":
            showTestLogin();
            break;
        default:
            showTestLogin();
            break;
    }
    exit;
}
else{
    showIndexPage();
    exit;
};
?>   