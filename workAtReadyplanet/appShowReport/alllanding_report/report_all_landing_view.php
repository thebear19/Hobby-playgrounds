<?php
include ("../inc_checkerror.php");
include("../inc_dbconnectOOP_a23.php");
include ("report_all_landing_controllerModel.php");
header('Content-Type: text/html; charset=TIS-620');
$objReport = new landingReport($dbConnect_a23);

if (isset($_POST['search'])) {

    $data = $objReport->getReport($_POST[dateFrom], $_POST[dateTo], $_POST[product]);
    
    echo "<table id='pivot'>
            <thead>
                <tr>
                    <th>product</th>
                    <th>source</th>
                    <th>medium</th>
                    <th>campaign</th>
                    <th>status</th>
                    <th>country</th>
                    <th>sale</th>
                    <th>sale status</th>
                    <th>sale team</th>
                    
                    <th>Landing_url</th>
                    <th>id</th>
                    <th>C_id</th>
                    <th>C_status</th>
                </tr>
            </thead><tbody>";
    foreach ($data as $value) {
        echo "<tr>
                <td>$value[product]</td>
                <td>$value[source]</td>
                <td>$value[medium]</td>
                <td>$value[campaign]</td>
                <td>$value[status]</td>
                <td>$value[country]</td>
                <td>$value[sale]</td>
                <td>$value[saleStatus]</td>
                <td>$value[saleTeam]</td>
                    
                <td>$value[Landing_url]</td>
                <td>$value[id]</td>
                <td>$value[Cid]</td>
                <td>$value[statusCustomer]</td>
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
        <title>Report Landing</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
       
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
        
        <link rel="stylesheet" type="text/css" href="pivottable/pivot.css">
        <script type="text/javascript" src="pivottable/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="pivottable/pivot.js"></script>
        
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="pivottable/gchart_renderers.js"></script>
        
        <style type="text/css">
            .finish { background-color: #D3E3F2; }
            .paying { background-color: #DEBDDE; }
            .prospect { background-color: #CEE1BB; }
            .callBack { background-color: #9AC4AF; }
            .followUp { background-color: #FFFFD7; }
            .drop { background-color: #FFECC0; }
            .noOK { background-color: #FFB3B3; }
            .reused { background-color: #DEBDDE; }
            .other { background-color: #D3E3F2; }
        </style>
        
        <script>
            google.load("visualization", "1", {packages:["corechart", "charteditor"]});
            
            $(document).ready(function() {
                $("button[name='search']").click(function() {
                    ajaxResult();
                }); 
            });
            
            function ajaxResult(){
                var renderers = $.extend($.pivotUtilities.renderers, 
                    $.pivotUtilities.gchart_renderers);
                
                $("button[name='search']").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                $("button[name='search']").attr("disabled", "disabled");
                
                //ajax call
                $.post("report_all_landing_view.php",
                    {
                        search: "",
                        dateFrom: $("input[name='dateFrom']").val(),
                        dateTo: $("input[name='dateTo']").val(),
                        product: $("select[name='product']").val()
                    }
                )
                .done(function(data) {
                    $("button[name='search']").html("Search");
                    $("button[name='search']").removeAttr("disabled");
                   
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
            <div class="form-group"><h2>Landing Report</h2></div>
            
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
                <label class="control-label col-sm-4">Product:</label>
                <div class="col-sm-4">
                    <select name="product" class="form-control">
                        <?=$objReport->getProduct()?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <button name="search" class="btn btn-default">Search</button>
                </div>
            </div>
        </div>
        
        <br/><br/>
        <div class="col-md-12" id="result" align='center'></div>
    </body>
</html>