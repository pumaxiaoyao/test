<div class="promotions_main">
        <div class="m_ad">
            @if (count($headActs) == 0 && count($nomarlActs) == 0)  
            <div class="flex-center full-height">
                    抱歉，暂无可参与的活动！感谢您的关注！
            </div>
            @endif
            @if (count($headActs)>0)

            <div class="mi_banner_img">
                <a>
                    <div class="m_logo" style="background-position-y: -60px;"></div>
                </a>
                @foreach ($headActs as $headact)
                    <div class="bannerp hidd" view_banner="{{ $loop->index }}" 
                        @if ($loop->first)
                            banner_crt="1" style="display: block; opacity: 1; background:url({{ $headact["picUrl2"] }})">
                        @else
                            banner_crt="0" style="display: none; opacity: 0; background:url({{ $headact["picUrl2"] }})">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mi_banner_ctrl">
                @foreach ($headActs as $headact)
                    <div class="mikc_icon  
                    @if ($loop->first) 
                        mi_select 
                    @elseif ($loop->count < 3)
                        mikc_icon_middle
                    @elseif ($loop->last)
                        last
                    @else
                        mikc_icon_middle
                    @endif" onclick="changeImg({{ $loop->index }},'banner')" banner_ctrl="{{ $loop->index }}"></div>
                @endforeach
            </div>
            @endif
        </div>
        
        <div class="p_m_content">
                @if (count($nomarlActs) > 0)
            <div class="p_m_type">
                <div class="p_m_type_line">
                </div>
            </div>
            <div class="p_m_list">
                @foreach( $nomarlActs as $act)
                    @if ((($loop->index) % 2) == 0)
                    <div class="p_m_list_row">
                        <div class="p_m_list_row_left">
                            <div class="p_m_list_box">
                                <div class="p_m_list_box_title">{{ $act["name"] }}
                                    @if ($act["isActive"] == 1) 
                                    <a href="javascript:joinActivity({{ $act["id"]}})" class="p_m_list_box_btn">立即申请</a>
                                    @endif
                                </div>
                                
                                <div class="p_m_list_box_msg" onclick="showMessage({{ $act["id"] }})">
                                    <div class="p_m_list_box_resume">{{ $act["desc"] }}</div>
                                    <img class="p_m_list_box_img" src="{{ $act["picUrl1"] }}"/>
                                </div>
                            </div>
                            <div class="p_m_list_row_left_timebox">
                                <div class="p_m_list_row_left_time">{!! $act["listTime"] !!}</div>
                                <img class="p_m_list_row_left_across" src="/static/img/promotions/line_03.png" />
                            </div>
                        </div>
                    @else
                        <div class="p_m_list_row_right">
                                <div class="p_m_list_box">
                                    <div class="p_m_list_box_title">{{ $act["name"] }}
                                        @if ($act["isActive"] == 1) 
                                        <a href="javascript:joinActivity({{ $act["id"]}})" class="p_m_list_box_btn">立即申请</a>
                                        @endif
                                    </div>
                                    <div class="p_m_list_box_msg" onclick="showMessage({{ $act["id"] }})">
                                        <div class="p_m_list_box_resume">{{ $act["desc"] }}</div>
                                        <img class="p_m_list_box_img" src="{{ $act["picUrl1"] }}"/>
                                    </div>
                                </div>
                            <div class="p_m_list_row_right_timebox">
                                <div class="p_m_list_row_right_time">{!! $act["listTime"] !!}</div>
                                <img class="p_m_list_row_right_across" src="/static/img/promotions/line02_03.png" />
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                @endif
            </div>
            
        </div>
        
    </div>  
</div>