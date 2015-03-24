using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class News : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            using (DbDataContext ctx = new DbDataContext())
            {
                var q = (from a in ctx.DB_News
                         orderby a.New_ID descending
                         select a);
                title.Text = q.First().New_Title;//หัวข้อประกาศ
                detail.Text = q.First().New_Detail;//รายละเอียดประกาศ
                date.Text = q.First().New_Date.ToString();//วันที่ประกาศ
            }
        }
    }
}