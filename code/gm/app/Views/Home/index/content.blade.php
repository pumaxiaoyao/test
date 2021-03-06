<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number" style="font-size:18px;" id="firstAmt">
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月首存 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number" style="font-size:18px;" id="dptAmt">
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月存款 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number" style="font-size:18px;" id="wtdAmt">
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月提款 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number" style="font-size:18px;" id="betAmt">
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月投注 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number" id='winLoss' style="font-size:18px;">
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月输赢 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number" style="font-size:18px;" id='fee'>
                            <img src="/static/image/loading.gif">
                        </div>
                        <div class="desc">
                            月成本 </div>
                    </div>
                    <a class="more" href="/report/companyDaily">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <!-- BEGIN PORTLET-->
                <div class="portlet solid bordered grey-cararra">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bar-chart-o"></i>公司总输赢 </div>
                        <!-- <div class="actions">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn grey-steel btn-sm">
                            <input type="radio" name="options" class="toggle" id="option1">New</label>
                            <label class="btn grey-steel btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option2">Returning</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="portlet-body">
                        <div id="theBETDChartsPages">
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
            <div class="col-md-6 col-sm-6">
                <!-- BEGIN PORTLET-->
                <div class="portlet solid grey-cararra bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bullhorn"></i>玩家存款提款 </div>
                    </div>
                    <div class="portlet-body">
                        <div id="theDWChartsPages">
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-6 col-sm-6">
                <div class="portlet box purple-wisteria">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-calendar"></i>红利及返水成本 </div>

                    </div>
                    <div class="portlet-body">
                        <div id="theCostChartsPages">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-sm-6">
                <div class="portlet box red-sunglo">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-calendar"></i>新增及首存玩家 </div>

                    </div>
                    <div class="portlet-body">
                        <div id="theNewChartsPages">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box red-sunglo">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-calendar"></i>游戏平台投注量 </div>

                    </div>
                    <div class="portlet-body">
                        <div id="theBETChartsPages"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box red-sunglo">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-calendar"></i>游戏平台公司总输赢 </div>

                    </div>
                    <div class="portlet-body">
                        <div id="theWLTotalChartsPages">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->