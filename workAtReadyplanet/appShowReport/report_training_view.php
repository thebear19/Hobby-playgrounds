<?php
include("../inc_dbconnect.php");
include ("report_training_controllerModel.php");
$objReport = new trainingReport($dbname);

if (isset($_POST['search'])) {
    
    $data = $objReport->getReport($_POST[proType], $_POST[dateFrom], $_POST[dateTo]);

    echo "<table id='reportTable' class='table table-hover'>
            <thead>
                <tr>
                    <td align='center'>Utm Source</td>
                    <td align='center'>Utm Medium</td>
                    <td class='finish' align='center'>Finish</td>
                    <td class='paying' align='center'>Paying</td>
                    <td class='prospect' align='center'>Prospect</td>
                    <td class='callBack' align='center'>Call Back</td>
                    <td class='followUp' align='center'>Follow Up</td>
                    <td class='drop' align='center'>Drop</td>
                    <td class='noOK' align='center'>No-OK</td>
                    <td align='center'>Total</td>
                </tr>
            </thead>";

    foreach ($data as $utmSource => $row) {
        foreach ($row as $utmMedium => $status) {
            echo "<tr>
                    <td>$status->utmSource</td>
                    <td>$status->utmMedium</td>
                    <td class='finish'>$status->finish</td>
                    <td class='paying'>$status->paying</td>
                    <td class='prospect'>$status->prospect</td>
                    <td class='callBack'>$status->callBack</td>
                    <td class='followUp'>$status->followUp</td>
                    <td class='drop'>$status->drop</td>
                    <td class='noOK'>$status->noOK</td>
                    <td>$status->total</td>
                </tr>";
            $sum = $sum + $status->total;
        }
    }
    echo "<tfoot><tr><td colspan='9'></td><td>$sum</td></tr></tfoot></table>";

    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Reprot Training</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
       
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
        
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
        <script type="text/javascript" charset="TIS-620" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script>
        
        <style type="text/css">
            .finish { background-color: #D3E3F2; }
            .paying { background-color: #DEBDDE; }
            .prospect { background-color: #CEE1BB; }
            .callBack { background-color: #FFFFD7; }
            .followUp { background-color: #9AC4AF; }
            .drop { background-color: #FFECC0; }
            .noOK { background-color: #FFB3B3; }
        </style>
        
        <script>
            $(document).ready(function() {
                $("button[name='search']").click(function() {
                    ajaxResult();
                }); 
            });
            
            function ajaxResult(){
                $("button[name='search']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='search']").attr("disabled", "disabled");
                
                //ajax call
                $.post("report_training_view.php",
                    {
                        search: "",
                        proType: $("select[name='proType']").val(),
                        dateFrom: $("input[name='dateFrom']").val(),
                        dateTo: $("input[name='dateTo']").val()
                    }
                )
                .done(function(data) {
                    $("button[name='search']").html("Search");
                    $("button[name='search']").removeAttr("disabled");
            
                    $("#result").html(data);
                    $('#reportTable').DataTable();
                });
            }
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Training Report</h2></div>
            
            <div class="form-group">
                <label class="control-label col-sm-4">Product Type:</label>
                <div class="col-sm-4">
                    <select name="proType" class="form-control">
                        <?php
                        echo "<option value=''>All</option>";
                        echo $objReport->getProductType();
                        ?>
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
                <div class="col-sm-offset-2 col-sm-8">
                    <button name="search" class="btn btn-default">Search</button>
                </div>
            </div>
        </div>
        
        <br/><br/>
        <div id="result"></div>
    </body>
</html>