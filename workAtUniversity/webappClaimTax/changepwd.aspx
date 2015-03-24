<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true"
    CodeBehind="changepwd.aspx.cs" Inherits="claim_tax.changepwd" %>

<asp:Content ID="Content1" ContentPlaceHolderID="Content" runat="server">
    <div style="text-align: center">
        <table style="width: 100%;">
            <tr>
                <td style="width: 32px">
                    &nbsp;
                </td>
                <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                    background-color: #9933FF">
                    เปลี่ยนรหัสผ่าน
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>
        <br />
        <br />
        <div style="background: url(../images/border3.png); background-repeat: no-repeat;
            background-position: 50% 0%;">
            <br />
            <center>
                <table cellpadding="1" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td>
                            <table cellpadding="0">
                                <tr>
                                    <td align="center" colspan="2">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <asp:Label ID="LabelCurrent" runat="server" Text="Password:"></asp:Label>
                                    </td>
                                    <td style="color: Red;">
                                        <asp:TextBox ID="current" runat="server" TextMode="Password"></asp:TextBox>
                                        <asp:RequiredFieldValidator ID="CurrentPasswordRequired" runat="server" ControlToValidate="current"
                                            ErrorMessage="Password is required." ToolTip="Password is required.">*</asp:RequiredFieldValidator>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <asp:Label ID="LabelNewPwd" runat="server" Text="New Password:"></asp:Label>
                                    </td>
                                    <td style="color: Red;">
                                        <asp:TextBox ID="newpwd" runat="server" TextMode="Password"></asp:TextBox>
                                        <asp:RequiredFieldValidator ID="NewPasswordRequired" runat="server" ControlToValidate="newpwd"
                                            ErrorMessage="New Password is required." ToolTip="New Password is required.">*</asp:RequiredFieldValidator>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <asp:Label ID="LabelConfirm" runat="server" Text="Confirm New Password:"></asp:Label>
                                    </td>
                                    <td style="color: Red;">
                                        <asp:TextBox ID="confirm" runat="server" TextMode="Password"></asp:TextBox>
                                        <asp:RequiredFieldValidator ID="ConfirmNewPasswordRequired" runat="server" ControlToValidate="confirm"
                                            ErrorMessage="Confirm New Password is required." ToolTip="Confirm New Password is required.">*</asp:RequiredFieldValidator>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2" style="color: Red;">
                                        <asp:CompareValidator ID="NewPasswordCompare" runat="server" ControlToCompare="newpwd"
                                            ControlToValidate="confirm" Display="Dynamic" ErrorMessage="The Confirm New Password must match the New Password entry."></asp:CompareValidator>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2" style="color: Red;">
                                        <asp:Literal ID="FailureText" runat="server" EnableViewState="False"></asp:Literal>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <asp:Button ID="submit" runat="server" Text="submit" OnClick="submit_Click" />
                                    </td>
                                    <td>
                                        <asp:Button ID="cancel" runat="server" Text="cancel" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
    </div>
</asp:Content>
