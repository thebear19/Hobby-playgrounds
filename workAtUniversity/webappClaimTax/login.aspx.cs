using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class login : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
        }

        protected void Login_Authenticate(object sender, AuthenticateEventArgs e)
        {
            MD5_Encrypt en = new MD5_Encrypt();
            string username = Login.UserName;//รับค่า username
            string pwd = Login.Password;//รับค่า password
            pwd = en.Md5AddSecret(pwd);//เอา password เข้ารหัสด้วย MD5

            using (DbDataContext ctx = new DbDataContext())
            {
                //-------ดึงข้อมูลในDBมาเช็คกับที่กรอก
                var q = (from a in ctx.EMPLOYEE_LOGINs
                        where a.E_USERNAME == username && a.E_PASSWORD == pwd
                        select a);
                if (q.Count() == 1)
                {
                    q.First().E_NUM++;//จำนวนครั้งที่user login
                    ctx.SubmitChanges();
                    Session["Authen"] = username;
                    Session["Grant"] = q.First().E_GRANT;
                    Session.Timeout = 300;//เวลาที่คงอยู่ในระบบ 5นาที
                    Response.Redirect("News.aspx");

                }
                else
                {
                    Session["Authen"] = null;
                }
            }
        }
    }
}