using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class Site : System.Web.UI.MasterPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            using (DbDataContext ctx = new DbDataContext())
            {
                //-------------แสดงจำนวนผู้เข้าชมทั้งหมด----------
                var q = (from a in ctx.EMPLOYEE_LOGINs
                         where a.E_NUM != 0
                        select a);
                Labelcount.Text = "จำนวนผู้เข้าชม : "+q.Count().ToString("0,0")+" คน";
                //-------------------------------------------
            }
        }
    }
}