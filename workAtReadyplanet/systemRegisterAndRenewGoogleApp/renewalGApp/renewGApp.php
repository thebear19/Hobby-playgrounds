<!DOCTYPE html>
<html>
    <title>Renewal Google App</title>
    <head>
        <meta charset="utf-8" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <style type="text/css">
            table { padding-top: 10px; }
            tr:hover { background-color: #FDFCDA; }
            td {padding-right: 10px; padding-right: 20px; padding-bottom: 10px; font-size: 20px;}
        </style>
        <?php
        include "../inc_dbconnect.php";
        
        $sql = "SELECT b.* 
                FROM ready_new_members a
                INNER JOIN ready_googleapp b 
                ON a.DomainName = b.domain
                WHERE a.ID = '$No'";
        
        $query = mysql_db_query ($dbname,$sql);
        $row = mysql_fetch_array($query);
        
        
        $sqlY = "SELECT b.pro_year FROM ready_new_members_detail a, ready_product b
                 WHERE a.ready_product_pid = b.pid AND a.ready_new_members_id = '$No'
                 AND ( b.pro_pcode = '57QA' || b.pro_pcode = 'QA' )";
        
        $queryY = mysql_db_query($dbname, $sqlY);
        $rowY = mysql_fetch_array($queryY);
        
        //check expired data - today > 3 month then exit
        if(strtotime($row[readyEndDate])- time() > 7889229){
            echo "<script>alert ('รายการนี้ไม่อยู่ในช่วงที่ดำเนินการได้');window.close();</script>";
        }
        
        $isflex = (strtotime($row[readyEndDate]) - time() <= 0) ? 1 : 0; //check flexible plan
        
        $exdate = new DateTime("$row[readyEndDate]");
        $exdate = $exdate->format("d/m/Y");
        ?>
        <script>
            $(document).ready(function() {
                var defaultSeats = $("input[name='seats']").val();
                
                $("input[name='seatsEdit']").click(function() {
                    if($("input[name='seatsEdit']").is(':checked')){
                        $("input[name='seats']").prop('disabled', false);
                    }else{
                        $("input[name='seats']").prop('disabled', true);
                    }
                });
                
                $("button[name='renew']").click(function() {
                    var domain = $("input[name='domain']").val();
                    var year = $("select[name='yearRenew']").val();
                    var seats = $("input[name='seats']").val();
                    var seatsEdit = $("input[name='seatsEdit']").is(':checked');
                    
                    var flex = $("input[name='flex']").val();
                    
                    if(flex == 1){
                        check = 1;
                    }else{
                        check = (seats >= defaultSeats) ? 1 : 0 ;
                    }
                    
                    if(check){
                        $("#result").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                        $.post("ResellerAPI.php",
                            {
                                renew: "",
                                domain: domain,
                                year: year,
                                seats: seats,
                                isEdit: seatsEdit
                            }
                        )
                        .done(function(data) {
                            var JSONArray = $.parseJSON(data);
                    
                            if(JSONArray.hasOwnProperty('error')){
                                $("#result").html(JSONArray.error.message);
                            }
                            else if(JSONArray.hasOwnProperty('results')){
                                $("#result").html(data);
                                alert ("ต่ออายุการใช้งานเรียบร้อย !!");
                                window.close();
                            }
                        })
                        .fail(function(xhr, textStatus, errorThrown) {
                            $("#result").html(errorThrown);
                        });
                    }else{
                        alert ("โดเมนนี้ไม่สามารถลดจำนวนผู้ใช้ได้ !!");
                    }
                });
            });
        </script>
    </head>
    <body>
    <fieldset><legend>Renewal Google App</legend><center><div id="result">
        <table cellspacing="0">
            <tr>
                <td align='left'><b>Domain Name</b></td>
                <td><?=$row[domain]?></td>
            </tr>
            
            <tr>
                <td align='left'><b>Expired data</b></td>
                <td><?=$exdate?></td>
            </tr>
            
            <tr>
                <td align='left'><b>Year</b></td>
                <td>
                    <select name="yearRenew">
                        <?php
                            for($i =1;$i<=3;$i++){
                                $isCheck = ($i == $rowY[pro_year]) ? "selected" : "";
                                echo "<option value='$i' $isCheck>$i</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td align='left'><b>User</b></td>
                <td>
                    <input type="number" name="seats" value="<?=$row[numSeats]?>" min="1" max="100" disabled="true" />
                    <input type="checkbox" name="seatsEdit" value="1" />Edit
                </td>
            </tr>
        </table><br />
        <button name="renew">Renewal</button>
        <input type="hidden" name="domain" value="<?=$row[domain]?>" />
        <input type="hidden" name="flex" value="<?=$isflex?>" />
    </div></center></fieldset>
    </body>
</html>