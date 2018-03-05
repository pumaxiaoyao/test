﻿using System;
using System.Web;
using System.Text;
using System.Xml;
using DinpayRSAAPI.COM.Dinpay.RsaUtils;


namespace CSharp
{
    public partial class DinpayToMer_notify : System.Web.UI.Page
    {
        protected void Back_Load(object sender, EventArgs e)
        {
            //To receive the parameter form Dinpay
            string merchant_code = Request.Form["merchant_code"].ToString().Trim();

            string notify_id = Request.Form["notify_id"].ToString().Trim();

            string notify_type = Request.Form["notify_type"].ToString().Trim();

            string interface_version = Request.Form["interface_version"].ToString().Trim();

            string sign_type = Request.Form["sign_type"].ToString().Trim();

            string dinpaysign = Request.Form["sign"].ToString().Trim();

            string order_no = Request.Form["order_no"].ToString().Trim();

            string order_time = Request.Form["order_time"].ToString().Trim();

            string order_amount = Request.Form["order_amount"].ToString().Trim();

            string extra_return_param = Request.Form["extra_return_param"].ToString().Trim();

            string trade_no = Request.Form["trade_no"].ToString().Trim();

            string trade_time = Request.Form["trade_time"].ToString().Trim();

            string bank_seq_no = Request.Form["bank_seq_no"].ToString().Trim();

            string trade_status = Request.Form["trade_status"].ToString().Trim();

            //Array data
            string signStr = "";

            if (bank_seq_no != "")
                {
                    signStr = signStr + "bank_seq_no=" + bank_seq_no + "&";
                }
            if (extra_return_param != "")
                {
                    signStr = signStr + "extra_return_param=" + extra_return_param + "&";
                }
            if (interface_version != "")
                {
                    signStr = signStr + "interface_version=" + interface_version + "&";
                }
            if (merchant_code != "")
                {
                    signStr = signStr + "merchant_code=" + merchant_code + "&";
                }
            if (notify_id != "")
                {
                    signStr = signStr + "notify_id=" + notify_id + "&";
                }
            if (notify_type != "")
                {
                    signStr = signStr + "notify_type=" + notify_type + "&";
                }
            if (order_amount != "")
                {
                    signStr = signStr + "order_amount=" + order_amount + "&";
                }
            if (order_no != "")
                {
                    signStr = signStr + "order_no=" + order_no + "&";
                }
            if (order_time != "")
                {
                    signStr = signStr + "order_time=" + order_time + "&";
                }
            if (trade_no != "")
                {
                    signStr = signStr + "trade_no=" + trade_no + "&";
                }
                if (trade_status != "")
                {
                    signStr = signStr + "trade_status=" + trade_status + "&";
                }
                if (trade_time != "")
                {
                    signStr = signStr + "trade_time=" + trade_time;
                }
                if (sign_type == "RSA-S") //RSA-S check sign
                {
                    //Dinpay public key
                    string dinpayPubKey = @"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCWOq5aHSTvdxGPDKZWSl6wrPpn
                        MHW+8lOgVU71jB2vFGuA6dwa/RpJKnz9zmoGryZlgUmfHANnN0uztkgwb+5mpgme
                        gBbNLuGqqHBpQHo2EsiAhgvgO3VRmWC8DARpzNxknsJTBhkUvZdy4GyrjnUrvsAR
                        g4VrFzKDWL0Yu3gunQIDAQAB";
                    
                    dinpayPubKey = testOrder.HttpHelp.RSAPublicKeyJava2DotNet(dinpayPubKey);
                    //check sign
                    bool result = testOrder.HttpHelp.ValidateRsaSign(signStr, dinpayPubKey, dinpaysign);
                    if (result == true)
                    {
                        Response.Write("SUCCESS");
                    }
                    else
                    {
                        Response.Write("fail");
                    }

                }
                else //RSA check sign
                {
                    string merPubKeyDir = "D:/1111110166.pfx";
                    string password = "87654321";
                    RSAWithHardware rsaWithH = new RSAWithHardware();
                    rsaWithH.Init(merPubKeyDir, password, "D:/dinpayRSAKeyVersion");
                    bool result = rsaWithH.VerifySign("1111110166", signStr, dinpaysign);
                    if (result == true)
                    {
                         Response.Write("SUCCESS");
                    }
                    else
                    {
                        Response.Write("fail");
                    }
                }

        }
    }
}