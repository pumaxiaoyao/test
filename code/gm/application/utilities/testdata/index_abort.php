<?php
session_start();
class Index{
   
    function betdaily(){
        
        $betdaily_json = '{
            "theme": "light",
            "type": "serial",
            "autoMargins": false,
            "marginLeft": 80,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "pathToImages": "/incloud/global/plugins/amcharts/amcharts/images/",
            "dataProvider": [],
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left"
            }],
            "graphs": [{
                "balloonText": "[[category]]<br><b>value: [[value]]</b>",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletBorderColor": "#FFFFFF",
                "hideBulletsCount": 50,
                "lineThickness": 2,
                "lineColor": "#fdd400",
                "negativeLineColor": "#67b7dc",
                "valueField": "输赢"
            }],
            "chartScrollbar": {},
            "chartCursor": {},
            "categoryField": "日期",
            "categoryAxis": {
                "axisAlpha": 0,
                "minHorizontalGap": 60
            }
        }';

        $betdaily_json = json_decode($betdaily_json, true);
        $betdaily_json["dataProvider"] = json_decode(
           ' [            {
                "日期": "09-10",
                "输赢": 0            },
                        {
                "日期": "09-11",
                "输赢": 31459.13            },
                        {
                "日期": "09-12",
                "输赢": -2235.67            },
                        {
                "日期": "09-13",
                "输赢": 5833.01            },
                        {
                "日期": "09-14",
                "输赢": 48307.66            },
                        {
                "日期": "09-15",
                "输赢": -45444.71            },
                        {
                "日期": "09-16",
                "输赢": 8579.91            },
                        {
                "日期": "09-17",
                "输赢": 118526.19            },
                        {
                "日期": "09-18",
                "输赢": -140612.99            },
                        {
                "日期": "09-19",
                "输赢": 61782.43            },
                        {
                "日期": "09-20",
                "输赢": 152371.30            },
                        {
                "日期": "09-21",
                "输赢": 46668.87            },
                        {
                "日期": "09-22",
                "输赢": -38361.91            },
                        {
                "日期": "09-23",
                "输赢": 161397.86            },
                        {
                "日期": "09-24",
                "输赢": 178059.47            },
                        {
                "日期": "09-25",
                "输赢": -27274.78            },
                        {
                "日期": "09-26",
                "输赢": 120908.46            },
                        {
                "日期": "09-27",
                "输赢": 6335.86            },
                        {
                "日期": "09-28",
                "输赢": 42710.35            },
                        {
                "日期": "09-29",
                "输赢": 109089.22            },
                        {
                "日期": "09-30",
                "输赢": 4650.29            },
                        {
                "日期": "10-01",
                "输赢": 56956.31            },
                        {
                "日期": "10-02",
                "输赢": 62656.69            },
                        {
                "日期": "10-03",
                "输赢": 31957.21            },
                        {
                "日期": "10-04",
                "输赢": 80364.17            },
                        {
                "日期": "10-05",
                "输赢": 14638.37            },
                        {
                "日期": "10-06",
                "输赢": 16984.44            },
                        {
                "日期": "10-07",
                "输赢": -4088.03            },
                        {
                "日期": "10-08",
                "输赢": 25737.26            },
                        {
                "日期": "10-09",
                "输赢": 70686.10            },
            {
            "日期": "10-10",
            "输赢": -47362.12        }]', true
        );
        
        echo json_encode($betdaily_json);
    }

    function dw(){
        $dw_json = '{"type": "serial",
            "addClassNames":true,
            "theme": "none",
            "pathToImages": "/incloud/global/plugins/amcharts/amcharts/images/",
            "autoMargins": false,
            "marginLeft":80,
            "marginRight":8,
            "marginTop":10,
            "marginBottom":26,
            "dataProvider": [],
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left"
            }],
            "startDuration": 1,
            "graphs": [],
            "chartScrollbar": {},
            "pathToImages": "/incloud/global/plugins/amcharts/amcharts/images/",
            "categoryField": "日期",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha":0,
                "tickLength":0
            }
        }';
        $dw_json = json_decode($dw_json, true);
        $dw_json["dataProvider"] = json_decode('[        {
            "日期": "09-11",
            "存款": 175035.37,
            "取款": 123652.00        },
                {
            "日期": "09-12",
            "存款": 168529.50,
            "取款": 140214.00        },
                {
            "日期": "09-13",
            "存款": 157483.30,
            "取款": 175059.00        },
                {
            "日期": "09-14",
            "存款": 173960.20,
            "取款": 190467.00        },
                {
            "日期": "09-15",
            "存款": 90932.30,
            "取款": 149706.00        },
                {
            "日期": "09-16",
            "存款": 116315.72,
            "取款": 64576.00        },
                {
            "日期": "09-17",
            "存款": 302742.33,
            "取款": 199379.00        },
                {
            "日期": "09-18",
            "存款": 178202.00,
            "取款": 330476.00        },
                {
            "日期": "09-19",
            "存款": 341012.26,
            "取款": 282245.00        },
                {
            "日期": "09-20",
            "存款": 291265.18,
            "取款": 176540.77        },
                {
            "日期": "09-21",
            "存款": 214959.91,
            "取款": 110093.00        },
                {
            "日期": "09-22",
            "存款": 180696.30,
            "取款": 210707.00        },
                {
            "日期": "09-23",
            "存款": 263010.07,
            "取款": 84556.00        },
                {
            "日期": "09-24",
            "存款": 236153.71,
            "取款": 132988.00        },
                {
            "日期": "09-25",
            "存款": 167514.20,
            "取款": 161600.00        },
                {
            "日期": "09-26",
            "存款": 188868.50,
            "取款": 98463.00        },
                {
            "日期": "09-27",
            "存款": 124692.00,
            "取款": 135889.00        },
                {
            "日期": "09-28",
            "存款": 141504.60,
            "取款": 80364.00        },
                {
            "日期": "09-29",
            "存款": 155138.40,
            "取款": 95226.00        },
                {
            "日期": "09-30",
            "存款": 127499.12,
            "取款": 89344.00        },
                {
            "日期": "10-01",
            "存款": 212055.10,
            "取款": 244452.00        },
                {
            "日期": "10-02",
            "存款": 188731.00,
            "取款": 147703.00        },
                {
            "日期": "10-03",
            "存款": 88798.10,
            "取款": 50203.00        },
                {
            "日期": "10-04",
            "存款": 111349.50,
            "取款": 57125.33        },
                {
            "日期": "10-05",
            "存款": 137562.20,
            "取款": 72278.00        },
                {
            "日期": "10-06",
            "存款": 145864.95,
            "取款": 184749.00        },
                {
            "日期": "10-07",
            "存款": 148193.30,
            "取款": 139175.00        },
                {
            "日期": "10-08",
            "存款": 203123.47,
            "取款": 209500.00        },
                {
            "日期": "10-09",
            "存款": 195254.70,
            "取款": 141862.00        },
        {
            "日期": "10-10",
            "存款": 105943.20,
            "取款": 153811.00        }        ]', true);
        
        $graph_tpl = json_decode('
        {   "id":"graph1",
            "balloonText": "",
            "bullet": "round",
            "lineThickness": 3,
            "bulletSize": 7,
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "useLineColorForBulletBorder": true,
            "bulletBorderThickness": 3,
            "fillAlphas": 0,
            "lineAlpha": 1,
            "title": "存款",
            "valueField": "存款"
         }', true);
         $graph_tpl["balloonText"] = "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b> [[additional]]</span>";
         for($x=0;$x<2;$x++){
            $dw_json["graphs"][0] = $graph_tpl;
            $dataidx = $x+1;
            $dw_json["graphs"][0]["id"] = "graph".(string)$dataidx;
         }

        echo json_encode($dw_json);
    }

    function cost(){
        $cost_json = '{"type": "serial",
            "theme": "none",
            "pathToImages": "/incloud/global/plugins/amcharts/amcharts/images/",
            "legend": {
                "horizontalGap": 10,
                "maxColumns": 10,
                "position": "bottom",
                "useGraphSettings": true,
                "markerSize": 10
            },
            "dataProvider": [],
            "valueAxes": [{
                "stackType": "regular",
                "axisAlpha": 0.3,
                "gridAlpha": 0
            }],
            "startDuration": 1,
            "graphs": [],
            "chartScrollbar": {},
            "pathToImages": "/incloud/global/plugins/amcharts/amcharts/images/",
            "categoryField": "日期",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0,
                "position": "left"
            },
            "exportConfig":{
                "menuTop":"20px",
                "menuRight":"20px",
                "menuItems": [{
                "icon": "/incloud/global/plugins/amcharts/amcharts/images/export.png",
                "format": "png"   
                }]  
            }
        }';
        $cost_json = json_decode($cost_json, true);
        $cost_json["dataProvider"] = json_decode(
           '[        {
            "日期": "09-10",
            "返水": 0,
            "存款优惠": 0,
            "红利": 0        },
                {
            "日期": "09-11",
            "返水": 0,
            "存款优惠": 1328.80,
            "红利": 118.00        },
                {
            "日期": "09-12",
            "返水": 0,
            "存款优惠": 867.94,
            "红利": 84.00        },
                {
            "日期": "09-13",
            "返水": 0,
            "存款优惠": 1020.85,
            "红利": 84.00        },
                {
            "日期": "09-14",
            "返水": 0,
            "存款优惠": 1434.60,
            "红利": 156.00        },
                {
            "日期": "09-15",
            "返水": 0,
            "存款优惠": 648.57,
            "红利": 28.00        },
                {
            "日期": "09-16",
            "返水": 0,
            "存款优惠": 786.16,
            "红利": 0        },
                {
            "日期": "09-17",
            "返水": 0,
            "存款优惠": 2051.26,
            "红利": 100.00        },
                {
            "日期": "09-18",
            "返水": 0,
            "存款优惠": 1214.18,
            "红利": 0        },
                {
            "日期": "09-19",
            "返水": 0,
            "存款优惠": 1723.17,
            "红利": -232.00        },
                {
            "日期": "09-20",
            "返水": 0,
            "存款优惠": 2094.71,
            "红利": 0        },
                {
            "日期": "09-21",
            "返水": 0,
            "存款优惠": 1342.11,
            "红利": 200.00        },
                {
            "日期": "09-22",
            "返水": 0,
            "存款优惠": 1145.89,
            "红利": 100.00        },
                {
            "日期": "09-23",
            "返水": 0,
            "存款优惠": 2305.28,
            "红利": 0        },
                {
            "日期": "09-24",
            "返水": 0,
            "存款优惠": 2075.75,
            "红利": 100.00        },
                {
            "日期": "09-25",
            "返水": 0,
            "存款优惠": 1461.27,
            "红利": 0        },
                {
            "日期": "09-26",
            "返水": 0,
            "存款优惠": 1649.26,
            "红利": 100.00        },
                {
            "日期": "09-27",
            "返水": 0,
            "存款优惠": 1102.47,
            "红利": 0        },
                {
            "日期": "09-28",
            "返水": 0,
            "存款优惠": 1172.12,
            "红利": 100.00        },
                {
            "日期": "09-29",
            "返水": 0,
            "存款优惠": 1091.02,
            "红利": 2510.00        },
                {
            "日期": "09-30",
            "返水": 0,
            "存款优惠": 1072.78,
            "红利": 436.02        },
                {
            "日期": "10-01",
            "返水": 0,
            "存款优惠": 1695.26,
            "红利": 288.00        },
                {
            "日期": "10-02",
            "返水": 0,
            "存款优惠": 1417.38,
            "红利": 676.00        },
                {
            "日期": "10-03",
            "返水": 0,
            "存款优惠": 702.64,
            "红利": 20.00        },
                {
            "日期": "10-04",
            "返水": 0,
            "存款优惠": 809.99,
            "红利": 0        },
                {
            "日期": "10-05",
            "返水": 0,
            "存款优惠": 1218.25,
            "红利": 476.00        },
                {
            "日期": "10-06",
            "返水": 0,
            "存款优惠": 1300.47,
            "红利": 1866.00        },
                {
            "日期": "10-07",
            "返水": 0,
            "存款优惠": 1211.83,
            "红利": 1866.00        },
                {
            "日期": "10-08",
            "返水": 0,
            "存款优惠": 1192.51,
            "红利": 1666.00        },
                {
            "日期": "10-09",
            "返水": 0,
            "存款优惠": 1372.34,
            "红利": 1666.00        },
        {
            "日期": "10-10",
            "返水": 0,
            "存款优惠": 893.93,
            "红利": 1002.00        }]', true
        );
        $graph_tpl = json_decode('
        {
            "balloonText": ""
            "fillAlphas": 0.8,
            "lineAlpha": 0.3,
            "title": "返水",
            "type": "column",
            "color": "#000000",
            "valueField": "返水"
        }', true);

        $graph_tpl["balloonText"] = "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
        $arraynames = array("返水", "存款优惠", "红利");
        $arrayCount = count($arraynames) + 1;
        for($x=1;$x<$arrayCount;$x++){
            $cost_json["graphs"][$x] = $graph_tpl;
            $cost_json["graphs"][$x]["title"] = $arraynames[$x-1];
            $cost_json["graphs"][$x]["valueField"] = $arraynames[$x-1];
            
        }
        echo json_encode($cost_json);
    }
}



?>