<script src="/static/js/agent/agentAccountSetting.js?201803182380"></script>

<script>
    
    <?php if($PhoneCodeInterval > 0): ?>
    var LastPhoneCode=true; 
    var PhoneCodeInterval=<?php echo e($PhoneCodeInterval); ?>;
    <?php else: ?>
    var LastPhoneCode=false; 
    var PhoneCodeInterval=0;
    <?php endif; ?>
    
    <?php if($unPhoneCodeInterval > 0): ?>
    var LastUnPhoneCode=true; 
    var UnPhoneCodeInterval=<?php echo e($unPhoneCodeInterval); ?>;
    <?php else: ?>
    var LastUnPhoneCode=false; 
    var UnPhoneCodeInterval=0;
    <?php endif; ?>
    
    <?php if($EMailCodeInterval > 0): ?>
    var LastMailCode=true; 
    var MailCodeInterval=<?php echo e($EMailCodeInterval); ?>;
    <?php else: ?>
    var LastMailCode=false; 
    var MailCodeInterval=0;
    <?php endif; ?>

    
    <?php if($unEMailCodeInterval > 0): ?>
    var LastUnMailCode=true; 
    var UnMailCodeInterval=<?php echo e($unEMailCodeInterval); ?>;
    <?php else: ?>
    var LastUnMailCode=false; 
    var UnMailCodeInterval=0;
    <?php endif; ?>
</script>


<script>
        $(function () {
            agentPageinit();

            addClasson('.left_nav_one');
            addClasson('.left_nav_two');
            addClasson('.left_nav_three');
            $(".nr_left_nav").find("dl").find(".on").parent().prev().toggleClass("on");
            $(".nr_left_nav").find("dl").find(".on").parent().show();
        })
        // $("#setting_history_box").delegate('#choose', "click", function () {
        //     console.log(12311);
        // });
        // // $('#setting_history_box').find('select#choose').change(function(){
        //     console.log("this choose value is ");
        // });
        // // $("#choose").change(function () {
            
            
        
            
        // });
    
        function addClasson(id) {
            $(id).find('.left_nav_title').click(function () {
                var $left_nav_one = $(id);
                $(this).toggleClass("on");
                if (!$(this).hasClass("on")) {
                    $left_nav_one.find('dl').slideUp()
                } else {
                    $left_nav_one.find('dl').slideDown()
                }
            })
        }
    
        function agentPageinit() {
            var settingactive = GetAgentQueryString("setting");
            var currentPage = pageName();
            console.log("currentPage is ", currentPage);
            var referpage = "memberlist";
            if (currentPage.toLowerCase() == "memberreports") {
                referpage = "memberlist";
            } else if (currentPage.toLowerCase() == "accountsetting") {
                referpage = "basicinfo";
            } else if (currentPage.toLowerCase() == "agentwithdrawl") {
                referpage = "tk";
            } else if (currentPage.toLowerCase() == "benifitreports") {
                referpage = "benifitreports";
            } else if (currentPage.toLowerCase() == "agentinfo") {
                referpage = "agentinfo";
            } else if (currentPage.toLowerCase() == "agentreports") {
                referpage = "agentreports";
            } else {
                referpage = ""
            }
            if (settingactive != null) {
                selectAgentSettingBox(settingactive);
            } else {
                selectAgentSettingBox(referpage);
            }
        }
    
        function GetAgentQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[1]);
            return null;
        }
    
        function selectAgentSettingBox(type) {
            console.log(type);
            $(".as_menu_icon").attr("class", "as_triangle_down");
            $(".as_info").attr("class", "as_info");
            $("#setting_" + type + "_bt").attr("class", "as_info as_info_select");
            $("#setting_" + type + "_icon").attr("class", "as_menu_icon zx_icon as_" + type);
    
            $(".setting_box_div").hide();
            $("#setting_" + type + "_box").show();
            console.log("switch to " + type);
            if (type == "memberlist") {
                searchMember();
            } else if (type == "history") {
                searchHistoryRecord();
            } else if (type == "daily") {
                searchDailyReport();
            } else if (type == "wdHistory") {
                searchwdHistoryRecord();
            } else if (type == "benifitreports") {
                searchBenifitReport();
            } else if (type == "agentinfo") {
                searchAgentInfo();
            } else if (type == "agentreports") {
                searchAgentReport();
            }
        }
    
        function addNewAgent() {
            window.location.href = "/agent/apply";
        }
    </script>
    
    <script src="/static/js/player/Accountmenu.js?201803182345"></script>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/static/css/agent/agentInfo.css?201801082062" rel="stylesheet" />
    <link href="/static/font-awesome/css/font-awesome.min.css?201801082031" rel="stylesheet" />
    