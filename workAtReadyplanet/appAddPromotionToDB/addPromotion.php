<?php
include("inc_dbconnect.php");
header('Content-Type: text/html; charset=UTF-8');

if(isset($_POST[add])){
    $tableName = ($_POST[type] == "promotion") ? "ready_mkt_promotion" : "ready_mkt_premium";
    $orgStruct = ($_POST[country] == "TH") ? "0" : "1";
    $pro_name = iconv("utf-8", "tis-620", $_POST[name]);
    
    $date = new DateTime('NOW');
    $pro_month = $date->format("n");
    $pro_year = $date->format("Y");
    
    if($_POST[type] == "promotion"){
        $sql = "SELECT priority FROM ready_mkt_promotion
                WHERE pro_month = '$pro_month' AND pro_year = '$pro_year' AND OrgStruct = '$orgStruct'
                ORDER BY priority DESC LIMIT 0,1;";
        $query = mysql_db_query($dbname, $sql);
        $row = mysql_fetch_array($query);
        $nextPriority = ++$row[priority];
    }
    
    $addRow = ($_POST[type] == "promotion") ? "(pro_name, pro_month, pro_year, OrgStruct, priority, pro_type)"
            : "(description, month, year, OrgStruct)";
    
    $addValue = ($_POST[type] == "promotion") ? "('$pro_name', '$pro_month', '$pro_year', '$orgStruct', '$nextPriority', 'Website')" 
            : "('$pro_name', '$pro_month', '$pro_year', '$orgStruct')";
    
    $sql = "INSERT INTO $tableName $addRow VALUES $addValue;";
    
    
    if(mysql_db_query($dbname, $sql)){
        echo "PROCESS COMPLETED  <i class='fa fa-smile-o fa-lg' style='color: #119200;'></i>";
    }
    else{
        echo "PROCESS FAILED  <i class='fa fa-frown-o fa-lg' style='color: #D70202;'></i>";
    }
    
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Add Promotion/Reward</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

        <script>
            $(document).ready(function() {
                $("button[name='add']").click(function() {
                    if(checkData()){
                        ajaxResult("addPromotion.php");
                    }
                });
            });

            function ajaxResult(url) {
                $("button[name='add']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='add']").attr("disabled", "disabled");
                
                //ajax call
                $.post(url, {
                        add: "",
                        country: $("select[name='country']").val(),
                        type: $("select[name='type']").val(),
                        name: $("input[name='name']").val()
                    }
                )
                .done(function(data) {
                    $("button[name='add']").html("Add");
                    $("button[name='add']").removeAttr("disabled");
                    
                    $('.response').modal('show');
                    $("#result").html(data);
                });
            }
            
            function checkData(){
                var i = 0;
                
                if($("input[name='name']").val() == ''){
                    $("input[name='name']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("input[name='name']").css({'border':''});
                    i++;
                }
                
                if($("select[name='type']").val() == ''){
                    $("select[name='type']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='type']").css({'border':''});
                    i++;
                }
                
                if($("select[name='country']").val() == ''){
                    $("select[name='country']").css({'border':'2px solid #E05353'});
                }
                else{
                    $("select[name='country']").css({'border':''});
                    i++;
                }
                
                if(i == 3){return true;}else{return false;}
            }
            
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="row" align="center">
            <div class="col-xs-1 col-md-4"></div>
            
            <div class="col-xs-10 col-md-4">
                <h3>Add Promotion & Reward</h3>
                
                <br/>
                
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-xs-4 col-md-4" for="country">Country :</label>
                        
                        <div class="col-xs-6 col-md-6">
                            <select name="country" class="form-control">
                                <option value="">Please select</option>
                                <option value="TH">Thailand</option>
                                <option value="MM">Myanmar</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-xs-4 col-md-4">Type :</label>
                        
                        <div class="col-xs-6 col-md-6">
                            <select name="type" class="form-control">
                                <option value="">Please select</option>
                                <option value="promotion">Promotion</option>
                                <option value="reward">Reward</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-xs-4 col-md-4">Name :</label>
                        
                        <div class="col-xs-6 col-md-6">
                            <input type="text" name="name" placeholder="Enter description" class="form-control" />
                        </div>
                    </div>
                    
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                </div>
            </div>
            
            <div class="col-md-4"></div>
        </div>

        <div class="modal fade response" tabindex="-1" role="dialog" aria-labelledby="responseDialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content col-md-12">
                    <br />
                    <center><p id="result"></p></center>
                    <br />
                </div>
            </div>
        </div>
        
    </body>
</html>