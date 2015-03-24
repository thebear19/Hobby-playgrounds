<?php
class landingReport {

    private $db_a23;

    public function __construct($db_a23) {
        $this->db_a23 = $db_a23;
    }

    //ส่งข้อมูลในตารางที่จะแสดงผลตาม input
    public function getReport($dateF, $dateT, $product) {
        //เช็ค input date 
        if (!empty($dateF) && !empty($dateT)) {
            $date = "AND a.AppliedDate >= '$dateF' AND a.AppliedDate <= '$dateT' ";
        } elseif (!empty($dateF) && empty($dateT)) {
            $date = "AND a.AppliedDate >= '$dateF' AND a.AppliedDate <= NOW() ";
        } elseif (empty($dateF) && !empty($dateT)) {
            $date = "AND a.AppliedDate > '0000-00-00' AND a.AppliedDate <= '$dateT' ";
        } else {
            $date = "AND a.AppliedDate > '0000-00-00' ";
        }

        $sql = "SELECT a.*, c.call_status, b.Sale AS saleID, c.show_status
                FROM ready_new_members a
                LEFT JOIN ready_customer_id b
                ON a.CustomerID = b.CustomerID
                LEFT JOIN ready_new_members_call c
                ON a.ID = c.newmemberid
                WHERE a.status > 0 AND (
                a.product_type = '4' OR 
                (a.Product_Description LIKE 'XA' AND a.Remark LIKE '%คำค้น%')
                ) $date;";

        //return $sql;

        $sales = $this->getSale();
        $country = array("Thailand", "Myanmar");
        $matching = $this->getProductMatching($product);

        $query = $this->db_a23->query($sql);

        while ($row = $query->fetch_array()) {
            if ($row[contact_status] != 0 && $row[show_status] == 0) {
                continue;
            }

            $row[call_status] = ($row[contact_status] == 0) ? 0 : $row[call_status];
            
            if(empty($row[Sale])){
                $row[saleID] = (empty($row[saleID]) || $row[saleID] == 99) ? 0 : $row[saleID];
            }else{
                $row[saleID] = ($row[Sale] == 99) ? 0 : $row[Sale];
            }

            $row[landing_url] = iconv("UTF-8", "TIS-620", urldecode($row[landing_url]));
            $fullURL = explode("?", $row[landing_url]);
            $utms = explode("&", $fullURL[1]);

            foreach ($matching as $detail) {
                if (strpos($fullURL[0], $detail[0]) !== FALSE) {
                    $productName = $detail[1];
                    $org = $detail[2];
                    $isSaleP = $detail[3]; //เช็ค sale ว่าใช้ primary (=1) หรือ secondary (=2) ในการแสดงผล
                    break;
                } else {
                    $productName = NULL;
                    $org = 0;
                    $isSaleP = 1;
                }
            }
            
            $typeCustomer = ($row[typedomain] == "oldid") ? "Old" : "New";

            foreach ($utms as $utm) {
                if (strpos($utm, "utm_source") !== FALSE) {
                    $source = explode("=", $utm);
                    $source = (empty($source[1])) ? "" : $source[1];
                } elseif (strpos($utm, "utm_medium") !== FALSE) {
                    $medium = explode("=", $utm);
                    $medium = (empty($medium[1])) ? "" : $medium[1];
                } elseif (strpos($utm, "utm_campaign") !== FALSE) {
                    $campaign = explode("=", $utm);
                    $campaign = (empty($campaign[1])) ? "" : $campaign[1];
                } elseif (strpos($utm, "gclid") !== FALSE) {
                    $isGoogle = true;
                }
            }

            if ($isGoogle && (empty($source) || empty($medium))) {
                $source = "google";
                $medium = "cpc";
            }

            if (!empty($isSaleP)) {
                if (!empty($row[secondarySaleName])) {
                    $seconDetail = $this->getSecondarySale($row[secondarySaleName]);
                } else {
                    $isSaleP = 1;
                }

                $saleName = ($isSaleP == 1) ? $sales[$row[saleID]][0] : $row[secondarySaleName];
                $saleStatus = ($isSaleP == 1) ? $sales[$row[saleID]][1] : $seconDetail[0];
                $saleTeam = ($isSaleP == 1) ? $sales[$row[saleID]][2] : $seconDetail[1];
            } else {
                $saleName = $sales[$row[saleID]][0];
                $saleStatus = $sales[$row[saleID]][1];
                $saleTeam = $sales[$row[saleID]][2];
            }

            $dataRaw[] = array("product" => $productName, "source" => $source, "medium" => $medium,
                "campaign" => $campaign, "status" => $this->getType($row[call_status]),
                "country" => $country[$org], "sale" => $saleName,
                "saleStatus" => $saleStatus, "saleTeam" => $saleTeam, "statusCustomer" => $typeCustomer,
                "Landing_url" => $row[landing_url], "id" => $row[ID], "Cid" => $row[CustomerID]); //"id"=>$row[ID]

            $source = NULL;
            $medium = NULL;
            $campaign = NULL;
            $isGoogle = FALSE;
        }

        return $dataRaw;
    }

    public function getProduct() {
        $sql = "SELECT DISTINCT Product FROM ready_landing_match ORDER BY Product ASC";
        $query = $this->db_a23->query($sql);

        $i = 1;
        $allProduct = "<option value='0'>All</option>";

        while ($row = $query->fetch_array()) {
            $allProduct .= "<option value='$row[Product]'>$row[Product]</option>";
            $i++;
        }

        return $allProduct;
    }

    private function getProductMatching($type) {
        $where = ($type == '0') ? "" : "WHERE Product = '$type'";

        $sql = "SELECT * FROM ready_landing_match $where ORDER BY Product ASC";
        $query = $this->db_a23->query($sql);
        while ($row = $query->fetch_array()) {
            $product[] = array($row[url], $row[Product], $row[orgStuct], $row[sale]);
        }

        return $product;
    }

    private function getSale() {
        $sql = "SELECT SaleID, admin_name, admin_password, sale_team
                FROM ready_office_admin
                ORDER BY sale_team ASC , admin_name ASC";

        $query = $this->db_a23->query($sql);

        while ($resale = $query->fetch_array()) {
            $saleStatus = (strpos($resale[admin_password], "ลาออก") !== FALSE) ? "Inactive" : "Active";

            if ($resale[sale_team] == 1) {
                $team = "1_Sale1";
            } elseif ($resale[sale_team] == 3) {
                $team = "2_Sale2";
            } elseif ($resale[sale_team] == 4) {
                $team = "3_Sale3";
            } elseif ($resale[sale_team] == 7) {
                $team = "4_All";
            } elseif ($resale[sale_team] == 5) {
                $team = "5_E";
            } elseif ($resale[sale_team] == 6) {
                $team = "6_M";
            } else {
                $team = "7_NoTeam";
            }

            $allSale[$resale[SaleID]] = array($resale[admin_name], $saleStatus, $team);
        }
        $allSale[0] = array("~Blank", "Active", "7_NoTeam");

        return $allSale;
    }

    private function getSecondarySale($name) {
        $sql = "SELECT admin_password, sale_team
                FROM ready_office_admin
                WHERE admin_name = '$name'";

        $query = $this->db_a23->query($sql);
        $row = $query->fetch_array();

        $saleStatus = (strpos($row[admin_password], "ลาออก") !== FALSE) ? "Inactive" : "Active";

        if ($row[sale_team] == 1) {
            $team = "1_Sale1";
        } elseif ($row[sale_team] == 3) {
            $team = "2_Sale2";
        } elseif ($row[sale_team] == 4) {
            $team = "3_Sale3";
        } elseif ($row[sale_team] == 7) {
            $team = "4_All";
        } elseif ($row[sale_team] == 5) {
            $team = "5_E";
        } elseif ($row[sale_team] == 6) {
            $team = "6_M";
        } else {
            $team = "7_NoTeam";
        }
        
        return array($saleStatus, $team);
    }

    private function getType($case) {
        switch ($case) {
            case 1:
                return "5_Call Back";

            case 2:
                return "1_Finish";

            case 3:
                return "8_No OK";

            case 4:
                return "4_Follow Up";

            case 5:
                return "7_Drop";

            case 6:
                return "2_Paying";

            case 7:
                return "3_Prospect";

            case 0:
                return "9_No Contact";

            case 11:
                return "6_Reused";

            default:
                return "10_Other";
        }
    }

}
?>

