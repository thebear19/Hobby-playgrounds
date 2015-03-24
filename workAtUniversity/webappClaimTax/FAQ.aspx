<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true"
    CodeBehind="FAQ.aspx.cs" Inherits="claim_tax.FAQ" %>

<asp:Content ID="Content1" ContentPlaceHolderID="Content" runat="server">
    <asp:Panel ID="Panel1" runat="server">
        <table style="width: 100%;">
            <tr>
                <td style="width: 32px">
                    &nbsp;
                </td>
                <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                    background-color: #9933FF">
                    คำถามที่พบบ่อย
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>
        <br />
        <br />
        <asp:Table ID="Table1" runat="server">
        </asp:Table>
    </asp:Panel>
</asp:Content>
