<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true"
    CodeBehind="login.aspx.cs" Inherits="claim_tax.login" %>

<asp:Content ID="Content1" ContentPlaceHolderID="Content" runat="server">
    <div>
        <!--แถบ header-->
        <table style="width: 100%;">
            <tr>
                <td style="width: 32px">
                    &nbsp;
                </td>
                <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                    background-color: #9933FF">
                    ลงชื่อเข้าใช้งาน
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>

        <br />
        <br />
        <!--ฟอร์ม login-->
        <div style="background: url(../images/border3.png); background-repeat: no-repeat;
            background-position: 50% 0%;">
            <center>
                <br />
                <asp:Login ID="Login" runat="server" OnAuthenticate="Login_Authenticate">
                </asp:Login>
            </center>
        </div>
    </div>
</asp:Content>
