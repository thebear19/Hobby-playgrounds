using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class changepwd : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["Authen"] == null)
            { 
                Response.Redirect("login.aspx"); 
            }
        }

        protected void submit_Click(object sender, EventArgs e)
        {
            MD5_Encrypt en = new MD5_Encrypt();
            using (DbDataContext ctx = new DbDataContext())
            {
                var q = (from a in ctx.EMPLOYEE_LOGINs
                         where a.E_USERNAME == Session["Authen"].ToString()
                         select a);
                if (en.Md5AddSecret(current.Text) == q.First().E_PASSWORD && newpwd.Text.Length >=7)//เช็ครหัสผ่านปัจจุบันที่กรอกตรงกับใน DB และเช็คความยาวรหัสผ่านใหม่
                {
                    q.First().E_PASSWORD = en.Md5AddSecret(newpwd.Text);//เก็บรหัสผ่านใหม่
                    ctx.SubmitChanges();
                    Response.Write("<script>alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว')</script>");
                }
                else
                {
                    FailureText.Text = "รหัสผ่านเก่าไม่ถูกต้องหรือรหัสผ่านใหม่กรอกน้อยกว่า7ตัวอักษร";
                }
            }
        }
    }
}