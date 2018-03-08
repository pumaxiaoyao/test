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
    public partial class PayTest : System.Web.UI.Page
    { 
        private ClientResponseHandler resHandler = new ClientResponseHandler();
        private PayHttpClient pay = new PayHttpClient();
        private RequestHandler reqHandler = null;
        private Dictionary<string, string> cfg = new Dictionary<string, string>(1);
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                this.tborder_no.Text = Utils.Nmrandom();//商户订单号 
                //this.tbclient_ip.Text = Request.UserHostAddress;
                this.tbtrade_date.Text = "20180130";
                this.tbtrade_time.Text = "102000";
               
                string userHostAddress = HttpContext.Current.Request.UserHostAddress;
                
                if (string.IsNullOrEmpty(userHostAddress))
                {
                    userHostAddress = HttpContext.Current.Request.ServerVariables["REMOTE_ADDR"];
                }
               
                if (string.IsNullOrEmpty(userHostAddress))
                {
                    userHostAddress = HttpContext.Current.Request.UserHostAddress;
                }
                //最后判断获取是否成功，并检查IP地址的格式（检查其格式非常重要）
                if (!string.IsNullOrEmpty(userHostAddress) && IsIP(userHostAddress))
                {
                       this.tbclient_ip.Text = userHostAddress;
                }
                else{
                  this.tbclient_ip.Text =  "127.0.0.1";
                }
            }
        }
        /// <summary>
        /// 检查IP地址格式
        /// </summary>
        /// <param name="ip"></param>
        /// <returns></returns>  
        public static bool IsIP(string ip)
        {
            return System.Text.RegularExpressions.Regex.IsMatch(ip, @"^((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)$");
        }
        /// <summary>
        /// 订单提交
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        protected void btnok_Click(object sender, EventArgs e)
        {
            if (tbtotal_amount.Text == "0")
            {
                Response.Write("<script>alert('总金额不能为【0】！')</script>");
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
                this.reqHandler.setParameter("attach", tbattach.Text);//附加信息
                this.reqHandler.setParameter("amount", tbtotal_amount.Text);//总金额
                this.reqHandler.setParameter("clientIp", tbclient_ip.Text);//终端IP
                this.reqHandler.setParameter("tradeDate", tbtrade_date.Text); //订单日期
                this.reqHandler.setParameter("tradeTime", tbtrade_time.Text);//订单时间
                this.reqHandler.setParameter("service", "pay.weixin.qrcode");//接口类型
                this.reqHandler.setParameter("merchantId", this.cfg["merchant_id"].ToString());//必填项，商户号，由平台分配
                this.reqHandler.setParameter("version", "1.0");//接口版本号
                this.reqHandler.setParameter("notifyUrl", this.cfg["notify_url"].ToString());
                //通知地址，必填项，接收平台通知的URL，需给绝对路径，255字符内;此URL要保证外网能访问   
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
			            // 扫码使用此网址显示二维码
			            // 其他直接跳转至该网址
                        param["resultUrl"].ToString();
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