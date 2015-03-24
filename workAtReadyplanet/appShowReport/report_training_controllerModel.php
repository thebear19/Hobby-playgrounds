<?php

class trainingReport {

    private $dbname;
    private $mainData;
    private $other;

    public function __construct($dbname) {
        $this->dbname = $dbname;
        $this->mainData['other']['other'] = new statusObj("null","null");
    }
    
    //�觢�����㹵��ҧ�����ʴ��ŵ�� input
    public function getReport($type,$dateF,$dateT) {
        
        //type = ��ҧ -> all
        if(!empty($type)){
            $type = explode('-', $type, 2); //ź�ù���
            $type = str_replace(' ', '-', strtolower(trim($type[1]))); //�ŧ������ + ᷹space����-
            $type = explode('-', $type, 3); //�Ѵ����� 2 ���á
            $type = "$type[0]-$type[1]%"; //����繻���¤���ǡѹ
         }
         
         //�� input date 
         if(!empty($dateF) && !empty($dateT)){
             $date = "AND a.AppliedDate >= '$dateF' AND a.AppliedDate <= '$dateT' ";
         }
         elseif(!empty($dateF) && empty($dateT)){
             $date = "AND a.AppliedDate >= '$dateF' AND a.AppliedDate <= NOW() ";
         }
         elseif(empty($dateF) && !empty($dateT)){
             $date = "AND a.AppliedDate > '0000-00-00' AND a.AppliedDate <= '$dateT' ";
         }
         else{
             $date = "AND a.AppliedDate > '0000-00-00' ";
         }
         
         $sql = "SELECT a.landing_url, a.referid, c.call_status
                FROM ready_new_members a
                INNER JOIN ready_customer_id b
                ON a.CustomerID = b.CustomerID
                INNER JOIN ready_new_members_call c
                ON a.id = c.newmemberid
                WHERE a.status > 0 AND c.show_status = '1' AND
                      (a.landing_url LIKE '%training%.readyplanet.com%$type' OR
                      a.referid LIKE '%training%.readyplanet.com%$type')
                      $date;";
        
        $query = mysql_db_query($this->dbname, $sql);
        
        while ($row = mysql_fetch_array($query)) {
            
            //�� url �������� ������� refer ᷹
            $textSearch = (strpos($row[landing_url], "training") > 0) ? $row[landing_url] : $row[referid];
            
            //�� url ����� utm ��������¡���Դ�ҡʵ�ԧ �������չѺ���㹡���� other
            if(strpos($textSearch, "utm_source") > 0){
                
                //�¡ utm source �Ѻ medium �͡�ҡ url
                $utm = explode('?', $textSearch, 2);
                $utm = explode('&', $utm[1], 3);
                
                $utmSource = explode('=', $utm[0]);
                $utmSource = $utmSource[1];
                
                $utmMedium = explode('=', $utm[1]);
                $utmMedium = $utmMedium[1];
                
                //��� ����� medium ������� null ᷹ ��һ������ҧ���������������������¡ key index �ͧ array �����
                $utmMedium = (empty($utmMedium)) ? "null" : $utmMedium;
                
                //�� key � array ������������ ��������ҧ����-> �Ѻ �൵�� +1
                if (array_key_exists($utmSource, $this->mainData) && array_key_exists($utmMedium, $this->mainData[$utmSource])) {
                    $this->countType($row[call_status],  $this->mainData[$utmSource][$utmMedium]);
                }else{
                    $this->mainData[$utmSource][$utmMedium] = new statusObj($utmSource, $utmMedium);
                    $this->countType($row[call_status],  $this->mainData[$utmSource][$utmMedium]);
                }
            }else{
                $this->countType($row[call_status],  $this->mainData['other']['other']);
            }
        }
        
        return $this->mainData;
    }

    //����¡�ê�Դ�ͧ�ù��觷����ҹ���� � �͹���
    public function getProductType() {
        $sql = "SELECT * FROM ready_product WHERE product_type_id = 3 AND pstatus = 1 AND pro_pcode LIKE '57%'";
        
        $query = mysql_db_query($this->dbname, $sql);
        
        while ($row = mysql_fetch_array($query)) {
            $product .= "<option value='$row[pname]'>$row[pname]</option>";
        }
        
        return $product;
    }
    
    //�Ѻʶҹе�ҧ
    private function countType($case,$obj){
        switch ($case) {
            case 1:
                $obj->callBack = $obj->callBack + 1;
                break;
            
            case 2:
                $obj->finish = $obj->finish + 1;
                break;
            
            case 3:
                $obj->noOK = $obj->noOK + 1;
                break;
            
            case 4:
                $obj->followUp = $obj->followUp + 1;
                break;
            
            case 5:
                $obj->drop = $obj->drop + 1;
                break;
            
            case 6:
                $obj->paying = $obj->paying + 1;
                break;
            
            case 7:
                $obj->prospect = $obj->prospect + 1;
                break;
            
            case 11:
                $obj->reused = $obj->reused + 1;
                break;
            default:
                $obj->other = $obj->other + 1;
                break;
        }
        $obj->total = $obj->total + 1;
    }
}



//obj �� utm ��Шӹǹ�ͧʶҹе�ҧ�
class statusObj {
    private $data;
    
    public function __construct($utmSource, $utmMedium) {
        $this->data['utmSource'] = $utmSource;
        $this->data['utmMedium'] = $utmMedium;
        $this->data['callBack'] = 0;
        $this->data['finish'] = 0;
        $this->data['noOK'] = 0;
        $this->data['followUp'] = 0;
        $this->data['drop'] = 0;
        $this->data['paying'] = 0;
        $this->data['prospect'] = 0;
        $this->data['reused'] = 0;
        $this->data['other'] = 0;
        $this->data['total'] = 0;
    }
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}
?>

