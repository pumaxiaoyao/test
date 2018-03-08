<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="PayTest.aspx.cs" Inherits="PayInterface.PayTest" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>支付测试页面</title>
</head>
<body>
    <form id="form1" runat="server">
    <div> 
        

        <div id="content">
            <div id="auto_center">
                <div class="nrtitle">
                    支付测试（微信扫码支付）
                </div>
                <div class="nrmain">
                    <div class="filedkd">商户订单号&nbsp;&nbsp; ：<asp:TextBox ID="tborder_no" runat="server" Width="267px" Height="26px" MaxLength="32" ToolTip="长度32"></asp:TextBox>
                        <asp:Label ID="Label1" runat="server" ForeColor="Red" Text="*长度32"></asp:Label>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="tborder_no" ErrorMessage="*商户订单号不能为空！"></asp:RequiredFieldValidator>
                    </div>
                    <div class="filedkd">附加信息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ：<asp:TextBox ID="tbattach" runat="server" Width="267px" Height="26px" ToolTip="长度128" TextMode="MultiLine">附加信息</asp:TextBox>
                        <asp:Label ID="Label3" runat="server" ForeColor="Black" Text="长度128"></asp:Label>
                    </div>
                    <div class="filedkd">总金额&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ：<asp:TextBox ID="tbtotal_amount" Width="267px" Height="26px" runat="server" TextMode="Number" ToolTip="单位：分 整型">1</asp:TextBox>
                        <asp:Label ID="Label4" runat="server" ForeColor="Red" Text="*单位：分 整型"></asp:Label>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" ControlToValidate="tbtotal_amount" ErrorMessage="*总金额不能为空"></asp:RequiredFieldValidator>
                    </div>
                    <div class="filedkd">终端IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ：<asp:TextBox ID="tbclient_ip" Height="26px" runat="server" ToolTip="长度16" >127.0.0.1</asp:TextBox>
                        <asp:Label ID="Label5" runat="server" ForeColor="Red" Text="*长度16"></asp:Label>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator4" runat="server" ControlToValidate="tbclient_ip" ErrorMessage="*终端IP不能为空！"></asp:RequiredFieldValidator>
                    </div>
                    <div class="filedkd">订单日期：<asp:TextBox ID="tbtrade_date" runat="server" Height="26px" ToolTip="长度8;yyyyMMdd" TextMode="Number"></asp:TextBox>
                        <asp:Label ID="Label6" runat="server" ForeColor="Black" Text="长度8;yyyyMMdd"></asp:Label>
                    </div>
                    <div class="filedkd">订单时间：<asp:TextBox ID="tbtrade_time" runat="server" Height="26px" ToolTip="长度6;HHmmss" TextMode="Number"></asp:TextBox>
                        <asp:Label ID="Label7" runat="server" ForeColor="Black" Text="长度6;HHmmss"></asp:Label>
                    </div>
                    <div class="filedkd">
                        <asp:Button ID="btnok" runat="server" Font-Bold="True" Font-Names="Arial" Font-Size="14pt" ForeColor="Blue" Height="34px" Text="确定" Width="124px" OnClick="btnok_Click" />
                    </div>

                </div>

            </div>
            </div>
       
        
    </div>
    </form>
</body>
</html>
