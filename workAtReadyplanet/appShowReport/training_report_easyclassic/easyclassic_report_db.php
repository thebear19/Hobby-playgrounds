<?php

class easyClassicReport {

    private $db_a23;
    private $db_libra;

    public function __construct($db_a23, $db_libra) {
        $this->db_a23 = $db_a23;
        $this->db_libra = $db_libra;
    }

    //ส่งข้อมูลในตารางที่จะแสดงผลตาม input
    public function getReport($input) {
        if($input[course] != "0"){
            $couseSQL = "&& course = '$input[course]'";
        }
        
        $sql = "SELECT * FROM ready_customer_training
                WHERE regis_date BETWEEN '$input[dateFrom] 00:00:00' and '$input[dateTo] 23:59:59' $couseSQL;";

        $query = $this->db_a23->query($sql);

        while ($row = $query->fetch_array()) {
            $fullname = ucwords(strtolower("$row[fname] $row[lname]"));

            $row[regis_date] = new DateTime($row[regis_date]);
            $row[tel] = preg_replace("/[^0-9]/", "", $row[tel]);

            $isAttend = $this->checkAttend($row[newmemberid], $row[course], $row[duedate]);
            
            if ($input[attendStatus] == 1 && $isAttend == "no") {
                continue;
            } elseif ($input[attendStatus] == 2 && $isAttend == "yes") {
                continue;
            }

            $course = $this->getCourse($row[course]);
            $class = $this->getClass($row[course], $row[classno]);
            $urlAndServer = $this->getUrlAndServer($row[newmemberid]);
            $url = $urlAndServer[0];
            $typeServer = $urlAndServer[1];

            $dataRaw[] = array("url" => $url, "type" => $typeServer, "course" => $course,
                "classNo" => $class, "name" => $fullname, "email" => $row[email],
                "phone" => $row[tel], "registerDate" => $row[regis_date]->format("d/m/Y"),
                "attendClass" => $isAttend);
        }

        return $dataRaw;
    }

    private function checkAttend($id, $course, $duedate) {
        $sql = "SELECT no FROM ready_customer_training_attend WHERE newmemberid = '$id' && duedate = '$duedate' && course = '$course';";
        $query = $this->db_a23->query($sql);

        if ($query->num_rows > 0) {
            return "yes";
        } else {
            return "no";
        }
    }

    private function getCourse($course) {
        $sql = "SELECT course_name_eng FROM ready_customer_training_course WHERE course_code = '$course';";
        $query = $this->db_a23->query($sql);
        $row = $query->fetch_array();

        return $row[course_name_eng];
    }

    private function getUrlAndServer($id) {
        $sql = "SELECT b.databaseserver, a.DomainName FROM ready_new_members a
                INNER JOIN members_area b ON a.DomainNameNoDot = b.Domain_name
                WHERE a.ID = '$id';";
        $query = $this->db_a23->query($sql);
        $row = $query->fetch_array();

        //server a28 = Offical easy, a34 = Demo easy, a26 = Demo classic, other = Offical classic
        if ($query->num_rows > 0) {
            if ($row[databaseserver] == "a28") {
                $row[databaseserver] = "Easy";
            } elseif ($row[databaseserver] != "a26" && $row[databaseserver] != "a28" && $row[databaseserver] != "a34") {
                $row[databaseserver] = "Classic";
            } else {
                $row[databaseserver] = "-";
            }
        } else {
            $row[DomainName] = "-";
            $row[databaseserver] = "-";
        }

        return array($row[DomainName], $row[databaseserver]);
    }

    private function getClass($course, $class) {
        $sql = "SELECT t_date FROM ready_customer_training_date WHERE t_course = '$course' && t_classno = '$class';";
        $query = $this->db_a23->query($sql);
        $row = $query->fetch_array();

        $date = new DateTime($row[t_date]);

        return $date->format("d/m/Y");
    }

    public function getOptionCourse() {
        $sql = "SELECT course_code, course_name_eng FROM ready_customer_training_course WHERE course_status = '1' ORDER BY weight ASC";
        $query = $this->db_a23->query($sql);
        
        $option = "<option value='0'>All</option>";
        
        while ($row = $query->fetch_array()) {
            $option .= "<option value='$row[course_code]'>$row[course_name_eng]</option>";
        }
        
        return $option;
    }

}
?>

