<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true"
    CodeBehind="EditTax.aspx.cs" Inherits="claim_tax.EditTax" %>

<asp:Content ID="Content1" ContentPlaceHolderID="Content" runat="server">
    <div class="first">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 32px">
                        &nbsp;
                    </td>
                    <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                        background-color: #9933FF">
                        หน้าจอตรวจสอบข้อมูลสิทธิลดหย่อน
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <br />
            <table style="width: 100%;">
                <tr>
                    <td style="height: 14px; width: 150px; font-size: large; font-family: Tahoma; text-align: right;">
                        <span style="font-family: Tahoma"><span style="font-size: large">รหัสพนักงาน&nbsp; :
                        </span></span>
                    </td>
                    <td style="height: 14px; width: 171px">
                        <asp:Label ID="Labelid" runat="server" Style="font-family: Tahoma; font-size: medium"
                            MaxLength="8" Width="80"></asp:Label>
                    </td>
                    <td style="height: 14px; width: 89px; font-family: Tahoma; font-size: large; text-align: right;">
                        ชื่อ - สกุล :
                    </td>
                    <td style="height: 14px">
                        <asp:Label ID="Labelname" runat="server" Style="font-family: Tahoma; font-size: medium"
                            Text=""></asp:Label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px; font-size: large; text-align: right;">
                        &nbsp;กลุ่มพนักงาน&nbsp; :
                    </td>
                    <td style="width: 171px">
                        <asp:Label ID="Labelstatus" runat="server" Style="font-size: medium" Text=""></asp:Label>
                    </td>
                    <td style="width: 89px; font-size: large; text-align: right;">
                        เขตบุคคล :
                    </td>
                    <td>
                        <asp:Label ID="LabelDeptarea" runat="server" Style="font-size: medium" Text=""></asp:Label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px; font-size: large; text-align: right;">
                        จาก :
                    </td>
                    <td style="width: 171px">
                        <asp:Label ID="LabelBegdate" runat="server" Style="font-size: medium" Text=""></asp:Label>
                    </td>
                    <td style="width: 89px; text-align: right; font-size: large;">
                        ถึง :
                    </td>
                    <td>
                        <asp:Label ID="LabelEnddate" runat="server" Style="font-size: medium" Text=""></asp:Label>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 151px">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; font-size: large; width: 151px">
                        เลขที่ผู้เสียภาษี :
                    </td>
                    <td>
                        <asp:Label ID="LabelTaxid" runat="server" Text="0000000"></asp:Label>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 32px">
                    </td>
                    <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                        background-color: #9933FF">
                        ข้อมูลครอบครัว
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center; height: 7px; width: 330px">
                    </td>
                    <td style="height: 14px; width: 67px;">
                    </td>
                    <td style="height: 7px; width: 201px">
                    </td>
                    <td style="height: 7px">
                    </td>
                    <td style="height: 14px">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 330px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <asp:CheckBox ID="CheckBoxSpouse" runat="server" Enabled="False" />
                        <strong>คู่สมรสไม่มีเงินได้</strong>
                    </td>
                    <td style="height: 14px; width: 67px;">
                        <asp:Button ID="Button1" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="font-size: medium; text-align: right; width: 201px">
                        <strong>ลดหย่อนบุตร</strong> :
                    </td>
                    <td style="text-align: center">
                        <asp:TextBox ID="LabelChild" runat="server" Style="text-align: center" Text="0" MaxLength="2" Width="40"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button3" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 330px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <asp:CheckBox ID="CheckBox1" runat="server" Enabled="False" />
                        <span style="font-size: medium"><strong>อุปการะคนพิการทุพลภาพหารคู่สมรส</strong></span>
                    </td>
                    <td style="height: 14px; width: 67px;">
                        <asp:Button ID="Button2" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: right; font-size: medium; width: 201px">
                        <strong>ลดหย่อนบุตรศึกษา</strong> :
                    </td>
                    <td style="text-align: center">
                        <asp:TextBox ID="LabelChildStudy" runat="server" Style="text-align: center" Text="0" MaxLength="2" Width="40"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button4" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 330px">
                    </td>
                    <td style="height: 14px; width: 67px;">
                    </td>
                    <td style="width: 201px; text-align: right">
                        <strong>อุปการะคนพิการทุพลภาพ</strong> :
                    </td>
                    <td style="text-align: center">
                        <asp:TextBox ID="LabelDis" runat="server" Style="text-align: center" Text="0" MaxLength="2" Width="40"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button5" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 32px">
                    </td>
                    <td style="width: 528px; font-size: x-large; color: #FFFFFF; text-decoration: underline;
                        background-color: #9933FF">
                        ข้อมูลค่าลดหย่อน
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
            <br />
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left; height: 7px; width: 240px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>ประเภทค่าลดหย่อน&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td colspan="5">
                        <asp:Label ID="LblTID" runat="server" Text="0001"></asp:Label>
                        &nbsp;&nbsp;&nbsp;<asp:TextBox ID="LblTextType" runat="server"></asp:TextBox>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; height: 14px;" colspan="6">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px; height: 13px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>เงินบริจาค</span>&nbsp;
                        </strong>
                    </td>
                    <td style="text-align: right; width: 63px; height: 13px;">
                        <asp:TextBox ID="Label6" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px; width: 63px;">
                        <asp:Button ID="Button6" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; height: 20px; font-size: medium;">
                        <strong>ซื้อหน่วยลงทุน RMF </strong>
                    </td>
                    <td style="text-align: right; width: 80px; height: 20px;">
                        <asp:TextBox ID="Label13" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button13" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px; height: 20px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>เบี้ยประกันชีวิต</span></strong>
                    </td>
                    <td style="text-align: right; width: 63px; height: 20px;">
                        <asp:TextBox ID="Label7" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 20px; width: 63px;">
                        <asp:Button ID="Button7" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; height: 20px;">
                        <strong>ซื้อหน่วยลงทุน LTF</strong>
                    </td>
                    <td style="text-align: right; width: 80px; height: 20px;">
                        <asp:TextBox ID="Label14" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 20px">
                        <asp:Button ID="Button14" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px; height: 14px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>เบี้ยประกันชีวิตคู่สมรส</span>
                        </strong>
                    </td>
                    <td style="text-align: right; width: 63px; height: 14px;">
                        <asp:TextBox ID="Label8" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px; width: 63px;">
                        <asp:Button ID="Button8" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; height: 13px; font-size: medium;">
                        <strong>บริจาคเพื่อการศึกษา </strong>
                    </td>
                    <td style="text-align: right; width: 80px; height: 13px;">
                        <asp:TextBox ID="Label15" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button15" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>อุปการะเลี้ยงดูบิดา</span>
                        </strong>
                    </td>
                    <td style="text-align: right; width: 63px">
                        <asp:TextBox ID="Label9" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px; width: 63px;">
                        <asp:Button ID="Button9" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; font-size: medium;">
                        <strong>อุปการะเลี้ยงดูมารดา </strong>
                    </td>
                    <td style="text-align: right; width: 80px;">
                        <asp:TextBox ID="Label16" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button16" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px; height: 18px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>อุปการะเลี้ยงดูบิดาคู่สมรส</span>
                        </strong>
                    </td>
                    <td style="text-align: right; width: 63px; height: 18px;">
                        <asp:TextBox ID="Label10" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px; width: 63px;">
                        <asp:Button ID="Button10" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; height: 18px; font-size: medium;">
                        <strong>อุปการะเลี้ยงดูมารดาคู่สมรส </strong>
                    </td>
                    <td style="text-align: right; width: 80px; height: 18px;">
                        <asp:TextBox ID="Label17" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button17" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>เบี้ยประกันสุขภาพบิดา</span>
                        </strong>
                    </td>
                    <td style="text-align: right; width: 63px">
                        <asp:TextBox ID="Label11" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px; width: 63px;">
                        <asp:Button ID="Button11" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; font-size: medium;">
                        <strong>เบี้ยประกันสุขภาพมารดา </strong>
                    </td>
                    <td style="text-align: right; width: 80px;">
                        <asp:TextBox ID="Label18" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="height: 14px">
                        <asp:Button ID="Button18" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 240px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><span>เบี้ยประกันสุขภาพบิดาคู่สมรส</span></strong>
                    </td>
                    <td style="text-align: right; width: 63px">
                        <asp:TextBox ID="Label12" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td style="text-align: left; width: 63px;">
                        <asp:Button ID="Button12" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                    <td style="text-align: left; width: 193px; font-size: medium;">
                        <strong>เบี้ยประกันสุขภาพมารดาคู่สมรส </strong>
                    </td>
                    <td style="text-align: right; width: 80px;">
                        <asp:TextBox ID="Label19" runat="server" Text="0.00" MaxLength="11" Width="100"></asp:TextBox>
                    </td>
                    <td>
                        <asp:Button ID="Button19" runat="server" Text="คำอธิบาย" OnClick="Popup_Click" />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <br />
                        <center>
                            <asp:Button ID="Button20" runat="server" Text="ยืนยันข้อมูล" OnClick="Submit_Click" />
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br />
</asp:Content>
