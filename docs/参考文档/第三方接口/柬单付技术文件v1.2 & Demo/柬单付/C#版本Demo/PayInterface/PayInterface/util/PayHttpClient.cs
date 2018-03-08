using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace utils
{
    public class PayHttpClient
    {
        /// <summary>
        /// 请求内容
        /// </summary>
        private Dictionary<String,String> reqContent;

        /// <summary>
        /// 应答内容
        /// </summary>
        private string resContent;

        /// <summary>
        /// 请求方法
        /// </summary>
        private string method;

        /// <summary>
        /// 错误信息
        /// </summary>
        private string errInfo;

        /// <summary>
        /// 超时时间,以秒为单位 
        /// </summary>
        private int timeOut;
        
        /// <summary>
        /// 网关url地址
        /// </summary>
        private string gateUrl;

        /// <summary>
        /// http应答编码 
        /// </summary>
        private int responseCode;

        public PayHttpClient() {
            this.reqContent = new Dictionary<String, String>();
            this.reqContent["url"] = "";
            this.reqContent["data"] = "";

            this.resContent = "";
            this.method = "POST";
            this.errInfo = "";
            this.timeOut = 1 * 60;//5分钟

            this.responseCode = 0;
        }

        /// <summary>
        /// 设置请求内容
        /// </summary>
        /// <param name="reqContent">内容</param>
        public void setReqContent(Dictionary<String, String> reqContent)
        {
            this.reqContent = reqContent;
        }

        /// <summary>
        /// 获取结果内容
        /// </summary>
        /// <returns></returns>
        public string getResContent()
        {
            return this.resContent;
        }

        /// <summary>
        /// 设置请求方法
        /// </summary>
        /// <param name="method">请求方法，可选:POST或GET</param>
        public void setMethod(string method)
        {
            this.method = method;
        }

        /// <summary>
        /// 获取错误信息
        /// </summary>
        /// <returns></returns>
        public string getErrInfo()
        {
            return this.errInfo;
        }

        /// <summary>
        /// 设置超时时间
        /// </summary>
        /// <param name="timeOut">超时时间，单位：秒</param>
        public void setTimeOut(int timeOut)
        {
            this.timeOut = timeOut;
        }
        
        /// <summary>
        /// 设置入口地址,不包含参数值
        /// </summary>
        /// <param name="gateUrl">入口地址</param>
        public void setGateUrl(String gateUrl)
        {
            this.gateUrl = gateUrl;
        }

        /// <summary>
        /// 获取http状态码
        /// </summary>
        /// <returns></returns>
        public int getResponseCode()
        {
            return this.responseCode;
        }

        //执行http调用
        public bool call()
        {
            StreamReader sr = null;
            HttpWebResponse wr = null;

            HttpWebRequest hp = null;
            try
            {
                hp = (HttpWebRequest)WebRequest.Create(this.reqContent["url"]);
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Ssl3 | SecurityProtocolType.Tls12 | SecurityProtocolType.Tls11 | SecurityProtocolType.Tls;
                string postData = this.reqContent["data"];

                hp.Timeout = this.timeOut * 1000;
                //hp.Timeout = 10 * 1000;
                if (postData != null)
                {
                    byte[] data = Encoding.UTF8.GetBytes(postData);
                    hp.Method = "POST";
                    hp.ContentType = "application/x-www-form-urlencoded;charset=UTF-8";  

                    hp.ContentLength = data.Length;

                    Stream ws = hp.GetRequestStream();

                    // 发送数据
                    ws.Write(data, 0, data.Length);
                    ws.Close();


                }


                wr = (HttpWebResponse)hp.GetResponse();
                sr = new StreamReader(wr.GetResponseStream(), Encoding.UTF8);

                this.resContent = sr.ReadToEnd();
                sr.Close();
                wr.Close();
            }
            catch (Exception exp)
            {
                this.errInfo += exp.Message;
                if (wr != null)
                {
                    this.responseCode = Convert.ToInt32(wr.StatusCode);
                }

                return false;
            }

            this.responseCode = Convert.ToInt32(wr.StatusCode);

            return true;
        }
    }
}
