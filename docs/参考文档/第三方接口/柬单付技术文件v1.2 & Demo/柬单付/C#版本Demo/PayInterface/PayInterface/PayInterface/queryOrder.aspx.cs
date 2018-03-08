using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using utils;
using System.Collections;
using System.Collections.Specialized;
using System.IO;
using System.Xml;
using System.Web.Script.Serialization;
using System.Text;

namespace PayInterface
{
    public partial class queryOrder : System.Web.UI.Page
    {
        private ClientResponseHandler resHandler = new ClientResponseHandler();
        private PayHttpClient pay = new PayHttpClient();
        private RequestHandler reqHandler = null;
        private Dictionary<string, string> cfg = new Dictionary<string, string>(1);
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {

            }
        }

        protected void btnok_Click(object sender, EventArgs e)
        {
            if (tborder_no.Text=="")
            {
                Response.Write("<script>alert('请输入商户订单号或者平台订单号！')</script>");
            }
            else
            {
                this.reqHandler = new RequestHandler(null);
                //加载配置数据
                this.cfg = Utils.loadCfg(); ;
                //初始化数据 
                this.reqHandler.setGateUrl(this.cfg["req_url"].ToString());
                this.reqHandler.setKey(this.cfg["key"].ToString());
                this.reqHandler.setParameter("orderNo", tborder_no.Text);//商户订单号
                this.reqHandler.setParameter("tradeDate", "20180130"); //订单日期
                this.reqHandler.setParameter("tradeTime", "123015");//订单时间
                this.reqHandler.setParameter("service", "trade.query");//接口类型
                this.reqHandler.setParameter("merchantId", this.cfg["merchant_id"].ToString());//必填项，商户号，由平台分配
                this.reqHandler.setParameter("version", "1.0");//接口版本号
                this.reqHandler.createSign();//创建签名
                //以上参数进行签名
                Dictionary<string, string> reqContent = new Dictionary<string, string>();
                reqContent.Add("url", this.reqHandler.getGateUrl());
                reqContent.Add("data", this.reqHandler.getRequestURL());
                this.pay.setReqContent(reqContent);

                if (this.pay.call())
                {
                    this.resHandler.setContent(this.pay.getResContent());
                    this.resHandler.setKey(this.cfg["key"].ToString());
                    Hashtable param = this.resHandler.getAllParameters();
                    if (this.resHandler.verifySign())
                    {
                    	if (param["repCode"].ToString() == "0001")
                    	{
	                        // 回传支付交易结果，详情请查看文档中的返回结果
	                        param["resultCode"].ToString();
                    	}
                    }
                    else
                    {
                        Response.Write("<script>alert('错误代码：" + param["repCode"] + ",错误信息：" + param["repMsg"] + "')</script>");
                    }
                }
                else
                {
                    Response.Write("<script>alert('错误代码：" + this.pay.getResponseCode() + ",错误信息：" + this.pay.getErrInfo() + "')</script>");
                }
            }
        }
    }
}