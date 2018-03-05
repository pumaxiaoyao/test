<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<%@ page import="java.io.*" %>
<%@ page import="com.itrus.util.sign.*" %>

<%
////////////////////////////////////  Get return paramenter  ////////////////////////////////////////////////

		// Get return parameter of QuickPay
		request.setCharacterEncoding("UTF-8");
		String interface_version = (String) request.getParameter("interface_version");
		String merchant_code = (String) request.getParameter("merchant_code");
		String notify_type = (String) request.getParameter("notify_type");
		String notify_id = (String) request.getParameter("notify_id");
		String sign_type = (String) request.getParameter("sign_type");
		String dinpaySign= (String) request.getParameter("sign");
		String order_no = (String) request.getParameter("order_no");
		String order_time = (String) request.getParameter("order_time");
		String order_amount = (String) request.getParameter("order_amount");
		String extra_return_param = (String) request.getParameter("extra_return_param");
		String trade_no = (String) request.getParameter("trade_no");
		String trade_time= (String) request.getParameter("trade_time");
		String trade_status = (String) request.getParameter("trade_status");
		String bank_seq_no= (String) request.getParameter("bank_seq_no");
		
		System.out.println(	"interface_version = " + interface_version + "\n" + 
							"merchant_code = " + merchant_code + "\n" +
							"notify_type = " + notify_type + "\n" +
							"notify_id = " + notify_id + "\n" +
							"sign_type = " + sign_type + "\n" +
							"dinpaySign = " + dinpaySign + "\n" +
							"order_no = " + order_no + "\n" +
							"order_time = " + order_time + "\n" +
							"order_amount = " + order_amount + "\n" +
							"extra_return_param = " + extra_return_param + "\n" +
							"trade_no = " + trade_no + "\n" +
							"trade_time = " + trade_time + "\n" +
							"trade_status = " + trade_status + "\n" +
							"bank_seq_no = " + bank_seq_no + "\n" 	); 		

		/** Data signature
		The definition of signature rule is as follows : 
		（1） In the list of parameters, except the two parameters of sign_type and sign, all the other parameters that are not in blank shall be signed, the parameter with value as blank doesn’t need to be signed; 
		（2） The sequence of signature shall be in the sequence of parameter name from a to z, in case of same first letter, then in accordance with the second letter, so on so forth, the composition rule is as follows : 
		Parameter name 1 = parameter value 1& parameter name 2 = parameter value 2& ......& parameter name N = parameter value N		*/	
	 
	 	StringBuilder signStr = new StringBuilder();
	 	if(null != bank_seq_no && !bank_seq_no.equals("")) {
	 		signStr.append("bank_seq_no=").append(bank_seq_no).append("&");
	 	}
	 	if(null != extra_return_param && !extra_return_param.equals("")) {
	 		signStr.append("extra_return_param=").append(extra_return_param).append("&");
	 	}
	 	signStr.append("interface_version=").append(interface_version).append("&");
	 	signStr.append("merchant_code=").append(merchant_code).append("&"); 	
	 	signStr.append("notify_id=").append(notify_id).append("&");	 	
	 	signStr.append("notify_type=").append(notify_type).append("&"); 	
	 	signStr.append("order_amount=").append(order_amount).append("&");
	 	signStr.append("order_no=").append(order_no).append("&");
	 	signStr.append("order_time=").append(order_time).append("&");
	 	signStr.append("trade_no=").append(trade_no).append("&");	
	 	signStr.append("trade_status=").append(trade_status).append("&");
		signStr.append("trade_time=").append(trade_time);

	 		
		String signInfo =signStr.toString();
		System.out.println("signInfo value：" + signInfo.length() + " -->" + signInfo);		
		System.out.println("dinpaysign：" + dinpaySign.length() + " -->" + dinpaySign);								
		boolean result = false;
		
		if("RSA-S".equals(sign_type)){ // sign_type = "RSA-S"			
			
			/**
			1)dinpay_public_key,copy it form QuickPay merchant system,find it on "Payment Management"->"Public Key Management"->"QuickPay Public Key"		
			2)this dinpay_public_key value is for merchant ID 1111110166,please get yours		*/			
			String dinpay_public_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCWOq5aHSTvdxGPDKZWSl6wrPpnMHW+8lOgVU71jB2vFGuA6dwa/RpJKnz9zmoGryZlgUmfHANnN0uztkgwb+5mpgmegBbNLuGqqHBpQHo2EsiAhgvgO3VRmWC8DARpzNxknsJTBhkUvZdy4GyrjnUrvsARg4VrFzKDWL0Yu3gunQIDAQAB";
			result = RSAWithSoftware.validateSignByPublicKey(signInfo, dinpay_public_key, dinpaySign);	// Validation	signInfo:Signature parameters sorting
		}
				
		if("RSA".equals(sign_type)){ // sign_type = "RSA"
			
			//Get the pfx cetification on QuickPay mechant system,"Payment Management"->"Download Cetification",1111110166.pfx is for merchant ID 1111110166			
			String webRootPath = request.getSession().getServletContext().getRealPath("/");
			String merPfxPath = webRootPath + "pfx/1111110166.pfx"; 									// The certificate path
			String merPfxPass = "87654321";			  													// The certificate password, value is your merchant ID
			RSAWithHardware mh = new RSAWithHardware();						
			mh.initSigner(merPfxPath, merPfxPass);		  							
			result = mh.validateSignByPubKey(merchant_code, signInfo, dinpaySign);						// Validation	merchant_code:merchant ID， signInfo:Signature parameters sorting， dinpaySign:the signature of QuickPay returned
		}
	
		PrintWriter pw = response.getWriter();
		if(result){
			pw.print("SUCCESS");      																	// Respond SUCCESS 
			System.out.println("result value：" + result + " -->SUCCESS");
		}else{
			pw.print("Signature Error");    															// Respond Signature Error
			System.out.println("result value：" + result + " -->Signature Error");
		}
        System.out.println("---------------------------------------------------------------------------------------------------------------------------------------------"); 		

%>
