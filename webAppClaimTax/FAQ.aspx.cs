using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace claim_tax
{
    public partial class FAQ : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            //------------------------สร้าง table
            TableRow r;
            TableCell c;
            using (DbDataContext ctx = new DbDataContext())
            {
                var q = (from a in ctx.DB_FAQs
                         select a);
                foreach (var x in q)
                {
                    for (int j = 0; j < 2; j++)
                    {
                        r = new TableRow();
                        for (int i = 0; i < 3; i++)
                        {
                            c = new TableCell();
                            if (j % 2 == 0)
                            {
                                switch (i % 3)
                                {
                                    case 1:
                                        c.Controls.Add(new LiteralControl("Q" + x.Q_ID + ":"));//เลขข้อ
                                        c.BackColor = System.Drawing.Color.MediumOrchid;
                                        c.ForeColor = System.Drawing.Color.White;
                                        break;
                                    case 2:
                                        c.Controls.Add(new LiteralControl(x.Question));//ตัวคำถาม
                                        c.BackColor = System.Drawing.Color.Purple;
                                        c.ForeColor = System.Drawing.Color.White;
                                        break;
                                    default:
                                        c.Controls.Add(new LiteralControl("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"));//สร้างช่องเปล่าๆ
                                        break;
                                }
                            }
                            else
                            {
                                switch (i % 3)
                                {
                                    case 2:
                                        c.Controls.Add(new LiteralControl(x.Answer+"<br />"));//คำตอบ
                                        break;
                                    default:
                                        c.Controls.Add(new LiteralControl());//สร้างช่องเปล่าๆ
                                        break;
                                }
                            }
                            c.Font.Bold = true;//ตัวพิมพ์หนา
                            r.Cells.Add(c);
                        }
                        Table1.Rows.Add(r);
                        r.Height = 50;//ความสูงของ row
                    }
                }
            }
        }
    }
}