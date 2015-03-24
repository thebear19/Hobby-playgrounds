using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class EditTax : System.Web.UI.Page
    {
        System.Globalization.CultureInfo cut = new System.Globalization.CultureInfo("en-US");
        protected void Page_Load(object sender, EventArgs e)
        {
            //----------ดักlogin
            if (Session["Authen"] != null)
            {
                if (!IsPostBack)
                {
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

        //----------------- ฟังก์ชันปุ่ม ยืนยัน ------------------
        protected void Submit_Click(object sender, EventArgs e)
        {
            if (Session["Authen"].Equals(Labelid.Text))
            {
                Check_Data();//ตรวจสอบข้อมูล
                Page.ClientScript.RegisterStartupScript(GetType(), "Script",
                        "<script>alert('ยืนยันการตรวจสอบเรียบร้อยแล้ว')</script>");//แสดงข้อความยืนยันการตรวจสอบ
            }
        }

        protected void Check_Data()
        {
            char spall;
            bool[] Check = new bool[20];
            string[] Check_Type = new string[20];
            string[] Check_OV = new string[20];
            string[] Check_NV = new string[20];

            using (DbDataContext ctx = new DbDataContext())
            {
                var q = (from a in ctx.PA0364s
                         orderby a.BEGDA descending
                         where a.PERNR == Session["Authen"].ToString()
                         select a);
                if (CheckBoxSpouse.Checked && CheckBox1.Checked)
                {
                    spall = '3';
                }
                else if (CheckBoxSpouse.Checked)
                {
                    spall = '1';
                }
                else if (CheckBox1.Checked)
                {
                    spall = '4';
                }
                else
                {
                    spall = '2';
                }

                try
                {
                    //--------------------------
                    Check[0] = q.FirstOrDefault().SPALL.Equals(spall);
                    Check_Type[0] = "SPALL";
                    Check_OV[0] = q.FirstOrDefault().SPALL.ToString();
                    Check_NV[0] = spall.ToString();
                    //---------------------------
                    Check[1] = q.FirstOrDefault().CHNO1.Equals(LabelChild.Text);
                    Check_Type[1] = "CHNO1";
                    Check_OV[1] = q.FirstOrDefault().CHNO1.ToString();
                    Check_NV[1] = LabelChild.Text.ToString();

                    Check[2] = q.FirstOrDefault().CHNO3.Equals(LabelChildStudy.Text);
                    Check_Type[2] = "CHNO3";
                    Check_OV[2] = q.FirstOrDefault().CHNO3.ToString();
                    Check_NV[2] = LabelChildStudy.Text.ToString();

                    Check[3] = q.FirstOrDefault().DINO1.Equals(Convert.ToChar(LabelDis.Text));
                    Check_Type[3] = "DINO1";
                    Check_OV[3] = q.FirstOrDefault().DINO1.ToString();
                    Check_NV[3] = Convert.ToChar(LabelDis.Text).ToString();
                    //---------------------------
                    Check[4] = q.FirstOrDefault().CHAMT.Equals(Convert.ToDecimal(Label6.Text));
                    Check_Type[4] = "CHAMT";
                    Check_OV[4] = q.FirstOrDefault().CHAMT.ToString();
                    Check_NV[4] = Convert.ToDecimal(Label6.Text).ToString();

                    Check[5] = q.FirstOrDefault().LPREM.Equals(Convert.ToDecimal(Label7.Text));
                    Check_Type[5] = "LPREM";
                    Check_OV[5] = q.FirstOrDefault().LPREM.ToString();
                    Check_NV[5] = Convert.ToDecimal(Label7.Text).ToString();

                    Check[6] = q.FirstOrDefault().SPINS.Equals(Convert.ToDecimal(Label8.Text));
                    Check_Type[6] = "SPINS";
                    Check_OV[6] = q.FirstOrDefault().SPINS.ToString();
                    Check_NV[6] = Convert.ToDecimal(Label8.Text).ToString();

                    Check[7] = q.FirstOrDefault().FCNTR.Equals(Convert.ToDecimal(Label9.Text));
                    Check_Type[7] = "FCNTR";
                    Check_OV[7] = q.FirstOrDefault().FCNTR.ToString();
                    Check_NV[7] = Convert.ToDecimal(Label9.Text).ToString();

                    Check[8] = q.FirstOrDefault().SFCTR.Equals(Convert.ToDecimal(Label10.Text));
                    Check_Type[8] = "SFCTR";
                    Check_OV[8] = q.FirstOrDefault().SFCTR.ToString();
                    Check_NV[8] = Convert.ToDecimal(Label10.Text).ToString();

                    Check[9] = q.FirstOrDefault().FPRINS.Equals(Convert.ToDecimal(Label11.Text));
                    Check_Type[9] = "FPRINS";
                    Check_OV[9] = q.FirstOrDefault().FPRINS.ToString();
                    Check_NV[9] = Convert.ToDecimal(Label11.Text).ToString();

                    Check[10] = q.FirstOrDefault().SFPINS.Equals(Convert.ToDecimal(Label12.Text));
                    Check_Type[10] = "SFPINS";
                    Check_OV[10] = q.FirstOrDefault().SFPINS.ToString();
                    Check_NV[10] = Convert.ToDecimal(Label12.Text).ToString();

                    Check[11] = q.FirstOrDefault().PENSN.Equals(Convert.ToDecimal(Label13.Text));
                    Check_Type[11] = "PENSN";
                    Check_OV[11] = q.FirstOrDefault().PENSN.ToString();
                    Check_NV[11] = Convert.ToDecimal(Label13.Text).ToString();

                    Check[12] = q.FirstOrDefault().LTEQF.Equals(Convert.ToDecimal(Label14.Text));
                    Check_Type[12] = "LTEQF";
                    Check_OV[12] = q.FirstOrDefault().LTEQF.ToString();
                    Check_NV[12] = Convert.ToDecimal(Label14.Text).ToString();

                    Check[13] = q.FirstOrDefault().CHEDU.Equals(Convert.ToDecimal(Label15.Text));
                    Check_Type[13] = "CHEDU";
                    Check_OV[13] = q.FirstOrDefault().CHEDU.ToString();
                    Check_NV[13] = Convert.ToDecimal(Label15.Text).ToString();

                    Check[14] = q.FirstOrDefault().MCNTR.Equals(Convert.ToDecimal(Label16.Text));
                    Check_Type[14] = "MCNTR";
                    Check_OV[14] = q.FirstOrDefault().MCNTR.ToString();
                    Check_NV[14] = Convert.ToDecimal(Label16.Text).ToString();

                    Check[15] = q.FirstOrDefault().SMCTR.Equals(Convert.ToDecimal(Label17.Text));
                    Check_Type[15] = "SMCTR";
                    Check_OV[15] = q.FirstOrDefault().SMCTR.ToString();
                    Check_NV[15] = Convert.ToDecimal(Label17.Text).ToString();

                    Check[16] = q.FirstOrDefault().MPRINS.Equals(Convert.ToDecimal(Label18.Text));
                    Check_Type[16] = "MPRINS";
                    Check_OV[16] = q.FirstOrDefault().MPRINS.ToString();
                    Check_NV[16] = Convert.ToDecimal(Label18.Text).ToString();

                    Check[17] = q.FirstOrDefault().SMPINS.Equals(Convert.ToDecimal(Label19.Text));
                    Check_Type[17] = "SMPINS";
                    Check_OV[17] = q.FirstOrDefault().SMPINS.ToString();
                    Check_NV[17] = Convert.ToDecimal(Label19.Text).ToString();

                    //Check[18] = q.FirstOrDefault().ALLTY.Equals(LblTextType.Text);

                    var z = (from a in ctx.TaxEdit_Lists
                             select a);

                    for (int i = 0; i < 18; i++)
                    {
                        if (!Check[i])
                        {
                            TaxEdit_List tax = new TaxEdit_List()
                                {
                                    No = z.Count() + 1,
                                    ID = Session["Authen"].ToString(),
                                    Data_Type = Check_Type[i],
                                    Old_Value = Check_OV[i],
                                    New_Value = Check_NV[i],
                                    Date = DateTime.Now
                                };
                            ctx.TaxEdit_Lists.InsertOnSubmit(tax);
                            ctx.SubmitChanges();
                        }
                    }
                }
                catch
                {
                    Page.ClientScript.RegisterStartupScript(GetType(), "Script",
                        "<script>alert('ข้อมูลที่กรอกผิดพลาดกรุณาตรวจทาน')</script>");//แสดงข้อความerror
                }

                /*PA0364 edit = new PA0364()
                {
                    SPALL = spall,
                    CHNO1 = LabelChild.Text,
                    CHNO3 = LabelChildStudy.Text,
                    DINO1 = Convert.ToChar(LabelDis.Text),
                    CHAMT = Convert.ToDecimal(Label6.Text),
                    LPREM = Convert.ToDecimal(Label7.Text),
                    SPINS = Convert.ToDecimal(Label8.Text),
                    FCNTR = Convert.ToDecimal(Label9.Text),
                    SFCTR = Convert.ToDecimal(Label10.Text),
                    FPRINS = Convert.ToDecimal(Label11.Text),
                    SFPINS = Convert.ToDecimal(Label12.Text),
                    PENSN = Convert.ToDecimal(Label13.Text),
                    LTEQF = Convert.ToDecimal(Label14.Text),
                    CHEDU = Convert.ToDecimal(Label15.Text),
                    MCNTR = Convert.ToDecimal(Label16.Text),
                    SMCTR = Convert.ToDecimal(Label17.Text),
                    MPRINS = Convert.ToDecimal(Label18.Text),
                    SMPINS = Convert.ToDecimal(Label19.Text),
                    CHECK_STATUS = '2',//สเตตัสสำหรับเช็ค 2 = แก้ไขแล้วรอตรวจสอบ
                    CHECK_DATE = DateTime.Now//วันที่ตรวจ
                };
                ctx.PA0364s.InsertOnSubmit(edit);
                ctx.SubmitChanges();*/
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

                Labelid.Text = q2.FirstOrDefault().PERNR.ToString();//รหัสพนักงาน
                Labelname.Text = q.FirstOrDefault().E_TITLE_DESC.ToString() + q.FirstOrDefault().E_NAMEF.ToString() + " " + q.FirstOrDefault().E_NAMEL.ToString();//ชื่อ - สกุล
                Labelstatus.Text = q.FirstOrDefault().E_POS_ST_DESC.ToString();//กลุ่มพนักงาน
                LabelDeptarea.Text = q.FirstOrDefault().E_REG_NAME.ToString();//เขตบุคคล
                LabelBegdate.Text = q2.FirstOrDefault().BEGDA.ToString("dd/MM/yyyy", cut);//จาก
                LabelEnddate.Text = q2.FirstOrDefault().ENDDA.Value.ToLocalTime().ToString("dd/MM/yyyy", cut);//ถึง

                LabelTaxid.Text = q2.FirstOrDefault().TAXID.ToString();//เลขที่ผู้เสียภาษี

                //-----------Check Box---------------
                CheckBoxSpouse.Enabled = true;
                CheckBox1.Enabled = true;
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