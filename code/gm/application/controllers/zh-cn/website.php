<?php

/**
 * MVC路由功能简单实现
 * @desc 简单实现MVC路由功能
 */
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper"));

class Website
{

    public function cf()
    {
        $page = array(
            makeHeaderPage(""),
            readHtml("website/cf"),
            makeFooterPage(""),
        );
        output(join("", $page));
    }

    public function getFile()
    {

    }

    public function upload()
    {
        $page = array(
            makeHeaderPage(""),
            readHtml("website/upload"),
            makeFooterPage(""),
        );
        output(join("", $page));
    }

    public function fileListAjax()
    {
        $ret = array("sEcho" => "1", "iTotalRecords" => "13", "iTotalDisplayRecords" => "13",
            "aaData" => array(
                array("16", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u9996\u9875\u4f53\u80b2", "<a id=\"url16\" key=\"url16\" href=\"#none\" class=\"copy\">\/fimg\/i20170917156b0c9ab34bb48d36760f6b6c3ecd.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i20170917156b0c9ab34bb48d36760f6b6c3ecd.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-10 01:12:24", "<a href=\"javascript:void(0)\" onclick=\"deletefile(16)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("15", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u9996\u9875\u8f6e\u64ad \u8db3\u7403", "<a id=\"url15\" key=\"url15\" href=\"#none\" class=\"copy\">\/fimg\/i201709f81c69141c614203988f5801e966ed09.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201709f81c69141c614203988f5801e966ed09.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-10 01:05:40", "<a href=\"javascript:void(0)\" onclick=\"deletefile(15)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("14", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u5fae\u4fe1LY-\u5c0f\u6613", "<a id=\"url14\" key=\"url14\" href=\"#none\" class=\"copy\">\/fimg\/i2017093888624ac95c41d1bc4d6a22f7153252.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i2017093888624ac95c41d1bc4d6a22f7153252.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-08 23:37:27", "<a href=\"javascript:void(0)\" onclick=\"deletefile(14)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("13", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "app\u4e8c\u7dad", "<a id=\"url13\" key=\"url13\" href=\"#none\" class=\"copy\">\/fimg\/i20170939bc89e9183542f59ade2207cc60c8b9.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i20170939bc89e9183542f59ade2207cc60c8b9.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-05 20:14:20", "<a href=\"javascript:void(0)\" onclick=\"deletefile(13)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("12", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u9996\u9875\u8f6e\u64ad", "<a id=\"url12\" key=\"url12\" href=\"#none\" class=\"copy\">\/fimg\/i201709ba2c9bb7771c4238a88170c857ac9571.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201709ba2c9bb7771c4238a88170c857ac9571.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-03 21:09:00", "<a href=\"javascript:void(0)\" onclick=\"deletefile(12)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("11", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u6c11\u4e50\u652f\u4ed8", "<a id=\"url11\" key=\"url11\" href=\"#none\" class=\"copy\">\/fimg\/i201709d20a04b2b944470eb01189001432a222.png<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201709d20a04b2b944470eb01189001432a222.png\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-09-01 00:00:43", "<a href=\"javascript:void(0)\" onclick=\"deletefile(11)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("10", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u89c6\u8baf\u9996\u98751", "<a id=\"url10\" key=\"url10\" href=\"#none\" class=\"copy\">\/fimg\/i201708b73bf5729e3a40c79ba91bc4d70cbbb0.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201708b73bf5729e3a40c79ba91bc4d70cbbb0.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-28 18:27:15", "<a href=\"javascript:void(0)\" onclick=\"deletefile(10)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("8", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u9996\u9875\u8f6e\u64ad\u56fe1", "<a id=\"url8\" key=\"url8\" href=\"#none\" class=\"copy\">\/fimg\/i201708a99a788788984af4b384009d028f7f6a.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201708a99a788788984af4b384009d028f7f6a.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-28 02:14:51", "<a href=\"javascript:void(0)\" onclick=\"deletefile(8)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("7", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u9996\u9875\u8f6e\u64ad1", "<a id=\"url7\" key=\"url7\" href=\"#none\" class=\"copy\">\/fimg\/i2017085e964aaf4a964908ac351828c7d27ba4.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i2017085e964aaf4a964908ac351828c7d27ba4.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-28 01:04:55", "<a href=\"javascript:void(0)\" onclick=\"deletefile(7)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("5", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "\u6536\u6b3e\u5fae\u4fe1LY\u4f9d\u513f", "<a id=\"url5\" key=\"url5\" href=\"#none\" class=\"copy\">\/fimg\/i201708163a0fb7c5ca424e96af7dfb31c988e2.jpg<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201708163a0fb7c5ca424e96af7dfb31c988e2.jpg\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-26 16:36:16", "<a href=\"javascript:void(0)\" onclick=\"deletefile(5)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("4", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "app\u4e8c\u7dad0824new", "<a id=\"url4\" key=\"url4\" href=\"#none\" class=\"copy\">\/fimg\/i201708c079897cfacf48c1886ea1950576bf88.png<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201708c079897cfacf48c1886ea1950576bf88.png\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-24 15:57:29", "<a href=\"javascript:void(0)\" onclick=\"deletefile(4)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("3", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "web\u4e8c\u7dad0824", "<a id=\"url3\" key=\"url3\" href=\"#none\" class=\"copy\">\/fimg\/i201708f935b08a0b9a44378e13e3d3abaa47e0.png<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i201708f935b08a0b9a44378e13e3d3abaa47e0.png\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-24 15:36:07", "<a href=\"javascript:void(0)\" onclick=\"deletefile(3)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
                array("1", "<a href=\"javascript:void(0);\" class=\"btn blue\">\u56fe\u7247<\/a>", "app\u4e8c\u7dad0824", "<a id=\"url1\" key=\"url1\" href=\"#none\" class=\"copy\">\/fimg\/i20170834871ff85547450ea29703fbf3da6d8d.png<\/a>", "<a href=\"#ViewModal\" data-toggle=\"modal\" onclick=show(\"\/fimg\/i20170834871ff85547450ea29703fbf3da6d8d.png\") class=\"btn blue\">\u70b9\u6b64\u9884\u89c8<\/a>", "2017-08-24 15:20:15", "<a href=\"javascript:void(0)\" onclick=\"deletefile(1)\"  class=\"btn mini green\"><i class=\"icon-trash\"><\/i>\u5220\u9664<\/a>"),
            ),
        );
        echo json_encode($ret);
    }
}
