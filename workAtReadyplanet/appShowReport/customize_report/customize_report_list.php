<?php
session_start();
include ("inc_checkerror.php");
include ("inc_head.php");
header('Content-Type: text/html; charset=TIS-620');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>All report list</title>
        <link rel="import" href="report/customize_report/customize_report_lib.html">
        
        <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.css">
        <script type="text/javascript" charset="UTF-8" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="UTF-8" src="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        
        <style type="text/css">
            #reportTable tr:hover td { background: #9DA0FF !important; }
            
            .addButtonReport {
                z-index: 1000;
                position: fixed;
                bottom: 5%;
                right: 5%;
                
                -moz-box-shadow: 0 0 10px #888; //ความกว้างแนวตั้ง, ความกว้างแนวนอน, blur, color
                -webkit-box-shadow: 0 0 10px #888;
                box-shadow: 0 0 10px #888;
                
                transition: all 0.1s ease;
            }
            .addButtonReport:hover {
                -moz-box-shadow: 0 0 10px 3px #888; //ความกว้างแนวตั้ง, ความกว้างแนวนอน, blur, spread, color
                -webkit-box-shadow: 0 0 10px 3px #888;
                box-shadow: 0 0 10px 3px #888;
            }
        </style>
    </head>
    <body style="background-color: #F5F5F5;">
        <a href="report/customize_report/customize_report_view.php" target="_blank" style='color: #ffffff;' class="btn btn-warning addButtonReport">
            <i class="fa fa-plus fa-2x"></i>
        </a>
        
        <div id="listReport"></div>
    </body>
    
    
    <script type="text/javascript" src="report/customize_report/customize_report_controller.js"></script>
    <script>
        $(function() {
            prepareData("listAllReport");
                
            $('#listReport').on('click', "a[name='deleteReport']", function(e){
                e.preventDefault();
                    
                var row = $(e.currentTarget).attr("value");
                    
                if(confirm("Do you want to continue this process?")){
                    prepareData("deleteReport", row);
                        
                    $('#reportTable').DataTable()
                        .row($(e.currentTarget).parents('tr'))
                        .remove()
                        .draw();
                }
            });
        });
    </script>
</html>