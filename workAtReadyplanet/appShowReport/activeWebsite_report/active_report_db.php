<?php

class activeReport {

    private $db_a23;

    public function __construct($db_a23) {
        $this->db_a23 = $db_a23;
    }

    //ส่งข้อมูลในตารางที่จะแสดงผลตาม input
    public function getReport($dateF, $dateT, $dateType) {
        //เช็ค input date 
        $dateType = ($dateType == 0) ? "e.pay_on_date" : "a.expired_date";
        
        $date = new DateTime($dateF);
        $dateF = $date->format("Y-m-d");
        $date = new DateTime($dateT);
        $dateT = $date->format("Y-m-d");
        
        $date = "AND $dateType >= '$dateF' AND $dateType <= '$dateT' ";

        $sql = "SELECT a.Web_name, a.CustomerID, a.applied_date, a.expired_date, c.admin_name, d.ID, e.pay_on_date
                FROM members_area a
                INNER JOIN ready_customer_id b ON a.CustomerID = b.CustomerID
                INNER JOIN ready_office_admin c ON b.Sale = c.SaleID
                INNER JOIN ready_new_members d ON a.Domain_name = d.DomainNameNoDot
                LEFT JOIN ready_office_clearing e ON d.ID = e.newmemberid
                WHERE a.Domain_name NOT 
                LIKE '%readyplanetorg' AND a.Domain_name NOT 
                LIKE '%velaeasycom' AND a.Domain_name NOT 
                LIKE '%velaeasynet' AND a.Domain_name NOT 
                LIKE '%velademocom' AND a.Domain_name NOT 
                LIKE '%velademonet' AND a.Domain_name NOT 
                LIKE '%readyhomepagecom' AND a.Domain_name NOT 
                LIKE '%readyplanetcom' AND a.Domain_name NOT 
                LIKE '%readymyanmarcom' AND a.Domain_name NOT
                LIKE '%readymyanmarcom' AND a.CustomerID != '0' AND a.CustomerID != '9' AND a.CustomerID != '8888'
                AND d.product_type = '1'
                $date
                GROUP BY a.Domain_name";

        //return $sql;

        $query = $this->db_a23->query($sql);

        while ($row = $query->fetch_array()) {
            if (!empty($row[pay_on_date])) {
                $row[pay_on_date] = new DateTime($row[pay_on_date]);
                $row[pay_on_date] = $row[pay_on_date]->format("Y-m-d");
            }


            $dataRaw[] = array("Domain" => $row[Web_name], "Sale" => $row[admin_name], "appDate" => $row[applied_date],
                "expDate" => $row[expired_date], "payDate" => $row[pay_on_date], "cusID" => $row[CustomerID]);
        }

        return $dataRaw;
    }

}
?>

