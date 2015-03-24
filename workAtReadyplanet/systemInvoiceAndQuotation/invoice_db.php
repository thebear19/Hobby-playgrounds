<?php

class invoiceDB {

    private $dbname;

    function __construct($dbname) {
        $this->dbname = $dbname;
    }

    function invoiceQuery($sql) {
        $query = mysql_db_query($this->dbname, $sql);
        return $query;
    }

    function paymentMethods($org) {
        $methods[] = array("", "Please select");

        $query = $this->invoiceQuery("SELECT * FROM ready_invoice_paymentMethods WHERE orgStruct = '$org';");

        while ($row = mysql_fetch_array($query)) {
            $methods[] = array($row[no], $row[method]);
        }

        return $methods;
    }

    function getDomain($id, $sp) {
        if(!empty($sp)){
            $query = $this->invoiceQuery("SELECT DomainName FROM tracking_webpro_new_members WHERE tracking_webpro_address_id = '$id';");
            if(mysql_num_rows($query) == 0){
                $query = $this->invoiceQuery("select DomainName from ready_new_members where ID ='$id';");
            }
        }else{
            $query = $this->invoiceQuery("select DomainName from ready_new_members where ID ='$id';");
            
        }
        $row = mysql_fetch_array($query);
        
        return $row[DomainName];
    }
    
    function getTaxID($id) {
        $query = $this->invoiceQuery("select taxID_corporation from ready_new_members where ID ='$id';");
        $row = mysql_fetch_array($query);
        
        return $this->formatTaxID($row[taxID_corporation]);
    }
    
    function formatTaxID($taxID) {
        //check pattern number
        if (preg_match("/(\d{1}-?\d{4}-?\d{5}-?\d{2}-?\d{1})/", $taxID)) {
            
            //if pure number change to formatted number
            if(preg_match("/(\d+)/", $taxID)){
                $formattedTaxID[] = substr($taxID, 0, 1);
                $formattedTaxID[] = substr($taxID, 1, 4);
                $formattedTaxID[] = substr($taxID, 5, 5);
                $formattedTaxID[] = substr($taxID, 10, 2);
                $formattedTaxID[] = substr($taxID, 12);
                
                $taxID = implode("-", $formattedTaxID);
            }
        }else{
            $taxID = "";
        }
        
        return $taxID;
    }
    
    function unformatTaxID($taxID) {
        //check pattern number
        if (preg_match("/(\d{1}-?\d{4}-?\d{5}-?\d{2}-?\d{1})/", $taxID)) {
            
            //if formatted number change to pure number
            if(preg_match("/(\d+)/", $taxID)){
                $taxID = str_replace("-", "", $taxID);
            }
        }else{
            $taxID = "";
        }
        
        return $taxID;
    }
            
    function getBusinessType() {
        $query = $this->invoiceQuery("SELECT * FROM ready_customer_business_type WHERE status = '1';");
        
        while ($row = mysql_fetch_array($query)) {
            $business[] = array($row[business_type_eng], $row[business_type_thai]);
        }
        return $business;
    }
    
    function getCustomerType() {
        $query = $this->invoiceQuery("SELECT * FROM ready_customer_customer_type WHERE status = '1';");
        
        while ($row = mysql_fetch_array($query)) {
            $customer[] = array($row[customerTypeEN], $row[customerTypeTH]);
        }
        return $customer;
    }
    
    function getProduct($pid) {
        $query = $this->invoiceQuery("SELECT * FROM ready_product WHERE pid = '$pid';");
        return mysql_fetch_array($query);
    }

    function getClearing($qid) {
        $query = $this->invoiceQuery("SELECT * FROM ready_office_clearing_info WHERE qid = '$qid';");
        return mysql_fetch_array($query);
    }

    function getSale($sid) {
        $query = $this->invoiceQuery("SELECT * FROM ready_office_admin WHERE admin_id = '$sid';");
        return mysql_fetch_array($query);
    }

    function getCompany($cid) {
        $query = $this->invoiceQuery("SELECT * FROM ready_invoice_company WHERE no = '$cid';");
        return mysql_fetch_array($query);
    }
    
    function getCustomer($cusNo) {
        $query = $this->invoiceQuery("SELECT * FROM ready_invoice_customers WHERE no = '$cusNo';");
        return mysql_fetch_array($query);
    }
    
    function getInvoiceDetails($invNo) {
        $query = $this->invoiceQuery("SELECT * FROM ready_invoice_details WHERE invNo = '$invNo' ORDER BY no ASC;");
        while ($row = mysql_fetch_array($query)) {
            $item[] = array("productID" => $row[productID], 
                "itemName" => $row[itemName], 
                "price" => $row[price], 
                "unit" => $row[unit], 
                "amount" => $row[amount], 
                "boi" => $row[boi], 
                "note" => $row[note]);
        }
        return $item;
    }

    function nextQA($param) {
        $query = $this->invoiceQuery("SELECT MAX( qid ) AS max FROM ready_office_quotation;");
        $row = mysql_fetch_array($query);
        
        return $row[max] + 1;
    }
    
    function getCustomerQA($cusID,$newid) {
        if(!empty($newid)){
            $query = $this->invoiceQuery("SELECT * FROM tracking_webpro_new_members_address WHERE ID = '$newid';");
            if(mysql_num_rows($query) == 0){
                $query = $this->invoiceQuery("SELECT * FROM tracking_webpro_new_members WHERE CustomerID = '$cusID' ORDER BY ID DESC LIMIT 0 , 1;");
            }
        }else{
            $query = $this->invoiceQuery("SELECT * FROM ready_new_members WHERE CustomerID = '$cusID' ORDER BY ID DESC LIMIT 0 , 1;");
        }
        return mysql_fetch_array($query);
    }
    
    function convertDate($date) {
        if (empty($date)) {
            return NULL;
        }

        $date = new DateTime($date);
        return $date->format("d/m/Y");
    }

    function convertToTis($values) {
        foreach ($values as &$value) {
            if (is_array($value)) {
                foreach ($value as &$subValue) {
                    $subValue = iconv("utf-8", "tis-620", $subValue);
                }
            } else {
                $value = iconv("utf-8", "tis-620", $value);
            }
        }
        return $values;
    }
    
    //เนื่องจาก mb_convert_encoding() ใช้ไม่ได้เลย ทำการแตก string แล้วแปลทีละส่วน
    function convertBigText($string) {
        $string = str_replace("ย", "", $string);
        $string = explode("\r\n", $string);
        foreach ($string as $subString) {
            $fullString[] = $this->utf8_to_tis620($subString);
        }
        return implode("<br />", $fullString);
    }

    //ใช้แทน iconv
    function utf8_to_tis620($string) {
        $str = $string;
        $res = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str[$i]) == 224) {
                $unicode = ord($str[$i + 2]) & 0x3F;
                $unicode |= (ord($str[$i + 1]) & 0x3F) << 6;
                $unicode |= (ord($str[$i]) & 0x0F) << 12;
                $res .= chr($unicode - 0x0E00 + 0xA0);
                $i += 2;
            } else {
                $res .= $str[$i];
            }
        }
        return $res;
    }
}

?>