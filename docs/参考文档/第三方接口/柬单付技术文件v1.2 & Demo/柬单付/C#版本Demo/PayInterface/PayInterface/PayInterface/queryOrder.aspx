<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="queryOrder.aspx.cs" Inherits="PayInterface.queryOrder" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>订单查询</title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
     
        <div id="content">
            <div id="auto_center">
                <div class="nrtitle">
                    订单查询测试 
                </div>
                <div class="nrmain">
                    <div class="filedkd">商户订单号&nbsp; &nbsp; ：<asp:TextBox ID="tborder_no" runat="server" Width="267px" Height="26px" MaxLength="32" ToolTip="长度32"></asp:TextBox>
                        <asp:Label ID="Label1" runat="server" Text="*长度32"></asp:Label>
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
