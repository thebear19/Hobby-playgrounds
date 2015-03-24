using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class WebForm1 : System.Web.UI.Page
    {
        System.Globalization.CultureInfo cut = new System.Globalization.CultureInfo("en-US");
        protected void Page_Load(object sender, EventArgs e)
        {
            //----------ดักloginและเช็คสิทธิการเข้าถึง
            if (Session["Authen"] != null)
            {
                if (Session["Grant"].Equals('1'))
                {
                    Labelid.Enabled = true;
                    Button21.Visible = true;
                    Button20.Enabled = false;
                }
                else
                {
                    Labelid.Enabled = false;
                    Button21.Visible = false;
                    Retrieve_Tax(Session["Authen"].ToString());
                }
            }
            else
            {
                Response.Redirect("Login.aspx");
            }
        }

        //----------------- ฟังก์ชันปุ่ม คำอธิบาย ------------------
        protected void Popup_Click(object sender, EventArgs e)
        {
            Button Button = (Button)sender;//แปลงtype obj -> button
            int i = Convert.ToInt16(Button.ID.ToString().Substring(6));// เด็บ id ปุ่ม เป็น int
            using (DbDataContext ctx = new DbDataContext())
            {
                var q3 = (from a in ctx.TAX_Descs
                          where a.ID == i
                          select a);//ดึงข้อมูลตาม i
                var title = q3.FirstOrDefault().Name.ToString();//เก็บหัวข้อ
                var desc = q3.FirstOrDefault().Description.ToString();//เก็บรายละเอียด

                //--------เรียก jquery โดยที่ centerPopup() เกี่ยวกับเนื้อหาของpop up  loadPopup() หลักๆจะเกี่ยวกับ fade in ไฟล์อยู่ที่ js/popup.js
                Page.ClientScript.RegisterStartupScript(GetType(), "Script",
                    "<script type=\"text/javascript\">centerPopup(\"" + title + "\",\"" + desc + "\");loadPopup();</script>");
            }
        }

        //----------------- ฟังก์ชันปุ่ม ตรวจแล้ว ------------------
        protected void Submit_Click(object sender, EventArgs e)
        {
            if (Session["Authen"].Equals(Labelid.Text))
            {
                using (DbDataContext ctx = new DbDataContext())
                {
                    var q = (from a in ctx.PA0364s
                             orderby a.BEGDA descending
                             where a.PERNR == Session["Authen"].ToString()
                             select a);
                    q.First().CHECK_STATUS = '1';//สเตตัสสำหรับเช็ค 1 = ตรวจแล้ว
                    q.First().CHECK_DATE = DateTime.Now;//วันที่ตรวจ
                    ctx.SubmitChanges();
                    Button20.Enabled = false;//ทำให้ปุ่มไม่สามารถกดได้
                    Page.ClientScript.RegisterStartupScript(GetType(), "Script",
                        "<script>alert('ยืนยันการตรวจสอบเรียบร้อยแล้ว')</script>");//แสดงข้อความยืนยันการตรวจสอบ
                }
            }
        }

        //----------------- ฟังก์ชันปุ่ม ค้นหา ------------------
        protected void Search(object sender, EventArgs e)
        {
            if (Labelid.Text != "" && Labelid.Text != null)
            {
                using (DbDataContext ctx = new DbDataContext())
                {
                    //-------ดึงข้อมูลในDBมาเช็คกับที่กรอก
                    var q = (from a in ctx.EMPLOYEE_LOGINs
                             where a.E_USERNAME == Labelid.Text.ToString()
                             select a);
                    if (q.Count() == 1)
                    {
                        Retrieve_Tax(Labelid.Text);
                    }
                    else
                    {
                        Page.ClientScript.RegisterStartupScript(GetType(), "Script",
                            "<script>alert('ไม่พบรหัสพนักงานตามที่ระบุ')</script>");//แสดงข้อความ
                    }
                }
            }
        }

        protected void Retrieve_Tax(string s_name)
        {
            //----------ดึงข้อมูลใน DB แสดงออก label ต่างๆ
            using (DbDataContext ctx = new DbDataContext())
            {
                var q = (from a in ctx.EMPLOYEE_INFOs
                         where a.E_ID == s_name
                         select a);

                var q2 = (from a in ctx.PA0364s
                          orderby a.BEGDA descending
                          where a.PERNR == s_name
                          select a);
                if (q2.First().CHECK_STATUS == '1')
                {
                    Button20.Enabled = false;
                }
                else
                {
                    Button20.Enabled = true;
                }

                Labelid.Text = q2.FirstOrDefault().PERNR.ToString();//รหัสพนักงาน
                Labelname.Text = q.FirstOrDefault().E_TITLE_DESC.ToString() + q.FirstOrDefault().E_NAMEF.ToString() + " " + q.FirstOrDefault().E_NAMEL.ToString();//ชื่อ - สกุล
                Labelstatus.Text = q.FirstOrDefault().E_POS_ST_DESC.ToString();//กลุ่มพนักงาน
                LabelDeptarea.Text = q.FirstOrDefault().E_REG_NAME.ToString();//เขตบุคคล
                LabelBegdate.Text = q2.FirstOrDefault().BEGDA.ToString("dd/MM/yyyy", cut);//จาก
                LabelEnddate.Text = q2.FirstOrDefault().ENDDA.Value.ToLocalTime().ToString("dd/MM/yyyy", cut);//ถึง

                LabelTaxid.Text = q2.FirstOrDefault().TAXID.ToString();//เลขที่ผู้เสียภาษี

                //-----------Check Box---------------
                CheckBoxSpouse.Enabled = false;
                CheckBox1.Enabled = false;
                if (q2.FirstOrDefault().SPALL == '1')
                {
                    CheckBoxSpouse.Checked = true;
                }
                else
                {
                    CheckBoxSpouse.Checked = false;
                }
                if (q2.FirstOrDefault().SPALL == '4')
                {
                    CheckBox1.Checked = true;
                }
                else
                {
                    CheckBox1.Checked = false;
                }
                if (q2.FirstOrDefault().SPALL == '3')
                {
                    CheckBoxSpouse.Checked = true;
                    CheckBox1.Checked = true;
                }
                //------------------------------------------

                LabelChild.Text = q2.FirstOrDefault().CHNO1.ToString();//ลดหย่อนบุตร
                LabelChildStudy.Text = q2.FirstOrDefault().CHNO3.ToString();//ลดหย่อนบุตรศึกษา
                LabelDis.Text = q2.FirstOrDefault().DINO1.ToString();//อุปการะคนพิการทุพลภาพ

                LblTID.Text = q2.FirstOrDefault().ALLTY.ToString();//ประเภทค่าลดหย่อน
                LblTextType.Text = q.FirstOrDefault().E_ID.ToString();//ยังไม่แก้

                Label6.Text = q2.FirstOrDefault().CHAMT.Value.ToString("0,0.00");//เงินบริจาค
                Label7.Text = q2.FirstOrDefault().LPREM.Value.ToString("0,0.00");//เบี้ยประกันชีวิต
                Label8.Text = q2.FirstOrDefault().SPINS.Value.ToString("0,0.00");//เบี้ยประกันชีวิตคู่สมรส
                Label9.Text = q2.FirstOrDefault().FCNTR.Value.ToString("0,0.00");//อุปการะเลี้ยงดูบิดา
                Label10.Text = q2.FirstOrDefault().SFCTR.Value.ToString("0,0.00");//อุปการะเลี้ยงดูบิดาคู่สมรส
                Label11.Text = q2.FirstOrDefault().FPRINS.Value.ToString("0,0.00");//เบี้ยประกันสุขภาพบิดา
                Label12.Text = q2.FirstOrDefault().SFPINS.Value.ToString("0,0.00");//เบี้ยประกันสุขภาพบิดาคู่สมรส
                Label13.Text = q2.FirstOrDefault().PENSN.Value.ToString("0,0.00");//ซื้อหน่วยลงทุน RMF
                Label14.Text = q2.FirstOrDefault().LTEQF.Value.ToString("0,0.00");//ซื้อหน่วยลงทุน LTF
                Label15.Text = q2.FirstOrDefault().CHEDU.Value.ToString("0,0.00");//บริจาคเพื่อการศึกษา
                Label16.Text = q2.FirstOrDefault().MCNTR.Value.ToString("0,0.00");//อุปการะเลี้ยงดูมารดา
                Label17.Text = q2.FirstOrDefault().SMCTR.Value.ToString("0,0.00");//อุปการะเลี้ยงดูมารดาคู่สมรส
                Label18.Text = q2.FirstOrDefault().MPRINS.Value.ToString("0,0.00");//เบี้ยประกันสุขภาพมารดา
                Label19.Text = q2.FirstOrDefault().SMPINS.Value.ToString("0,0.00");//เบี้ยประกันสุขภาพมารดาคู่สมรส
            }
        }
    }
}