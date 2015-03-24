<?php
include ("../../inc_checkerror.php");
include("../../inc_dbconnectOOP.php");
include ("active_report_db.php");

header('Content-Type: text/html; charset=TIS-620');
$objReport = new activeReport($dbConnect_a23);

if (isset($_POST['search'])) {

    $data = $objReport->getReport($_POST[dateFrom], $_POST[dateTo], $_POST[dateType]);
    
    echo "<table id='pivot'>
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Sale</th>
                    <th>payDate</th>
                    <th>startDate</th>
                    <th>expDate</th>
                    <th>cusID</th>
                </tr>
            </thead><tbody>";
    
    
    foreach ($data as $value) {
        echo "<tr>
                <td>$value[Domain]</td>
                <td>$value[Sale]</td>
                <td>$value[payDate]</td>
                <td>$value[appDate]</td>
                <td>$value[expDate]</td>
                <td>$value[cusID]</td>
            </tr>";
    }
    echo "</tbody></table>";
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Active Website Report</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
       
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="../pivottable/pivot.css">
        <script type="text/javascript" src="../pivottable/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="../pivottable/pivot.js"></script>
        
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="../pivottable/gchart_renderers.js"></script>
        
        <script type="text/javascript" src="../excellentexport.min.js"></script>
        
        <script>
            google.load("visualization", "1", {packages:["corechart", "charteditor"]});
            
            $(document).ready(function() {
                $("button[name='search']").click(function() {
                    ajaxResult();
                });
                
                $("a[name='exportExcel']").click(function () {
                    var dateFrom = $("input[name='dateFrom']").val();
                    var dateTo = $("input[name='dateTo']").val();
                    
                    $("a[name='exportExcel']").prop("download", "websiteReport_"+ dateFrom +"to"+ dateTo +".xls");
                    return ExcellentExport.excel(this, 'resTable', 'Sheet1');
                });
            });
            
            function ajaxResult(){
                var renderers = $.extend($.pivotUtilities.renderers, 
                    $.pivotUtilities.gchart_renderers);
                
                $("button[name='search']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='search']").attr("disabled", "disabled");
                
                //ajax call
                $.post("active_report_view.php",
                    {
                        search: "",
                        dateFrom: $("input[name='dateFrom']").val(),
                        dateTo: $("input[name='dateTo']").val(),
                        dateType: $("select[name='typeDate']").val()
                    }
                )
                .done(function(data) {
                    $("button[name='search']").html("<i class='fa fa-search'></i>");
                    $("button[name='search']").removeAttr("disabled");
                    $("a[name='exportExcel']").removeClass("disabled");
                   
                    $("#result").html(data);
                    $("#result").pivotUI($("#pivot"),
                        {
                            renderers: renderers
                        }
                    );
                });
            }
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Website Report</h2></div>
            
            <div class="form-group">
                <label class="control-label col-sm-4">Date type:</label>
                <div class="col-sm-2">
                    <select name="typeDate" class="form-control">
                        <option value="0">Pay Date</option>
                        <option value="1">Expire Date</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-4">Date:</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="dateFrom" />
                </div>
                
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="dateTo" />
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-4">
                    <button name="search" style="margin-right: 5%;" class="btn btn-primary col-sm-2" title="Search">
                        <i class="fa fa-search"></i>
                    </button>

                    <a name="exportExcel" href="#" class="btn btn-default col-sm-2 disabled" title="Export">
                        <i class="fa fa-file-excel-o"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <br/><br/>
        <div class="col-md-12" id="result" align='center'></div>
    </body>
</html>