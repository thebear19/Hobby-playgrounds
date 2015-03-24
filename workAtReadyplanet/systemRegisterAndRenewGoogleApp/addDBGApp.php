<?php
include "resellerFunction.php";

if (!empty($_POST[id])) {
    try {
        $service = new Google_Service_Reseller($client);

        $response = $service->subscriptions->listSubscriptions(array("customerId" => $_POST[id]));
        
        insertDB($response[0]->creationTime, $response[0]->plan->commitmentInterval->startTime, $response[0]->plan->commitmentInterval->endTime);

        echo json_encode(array('results' => "success"));
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => array(
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            )
        ));
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="TIS-620">
        <title>Add GoogleApp to Database</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

        <script>
            $(document).ready(function () {
                $("button[name='add']").click(function () {
                    addDomain();
                });
            });

            function addDomain() {
                //ajax call
                $.ajax({
                    url: "addDBGApp.php",
                    data: {
                        "id": $('input[name="domain"]').val(),
                        "year": $('input[name="year"]').val(),
                        "maxSeat": $('input[name="maxSeat"]').val()
                    },
                    type: "POST",
                    beforeSend: function () {
                        $('button[name="add"]').html("<i class='fa fa-spinner fa-spin'></i>");
                        $("button[name='add']").attr("disabled", "disabled");
                        $("#log").html("");
                    },
                    success: function(data) {
                        var JSONArray = $.parseJSON(data);

                        if (JSONArray.hasOwnProperty('error')) {
                            $("#log").html(JSONArray.error.message);
                        }
                        else if (JSONArray.hasOwnProperty('results')) {
                            $("#log").html(JSONArray.results);
                            
                            $('input[name="domain"]').val("");
                            $('input[name="year"]').val("");
                            $('input[name="maxSeat"]').val("");
                        }
                    },
                    error: function(jqXHR, textStatus, ex) {
                        $("#log").html(textStatus + "," + ex + "," + jqXHR.responseText);
                    },
                    complete: function () {
                        $('button[name="add"]').html("Add");
                        $("button[name='add']").removeAttr("disabled");
                    }
                });
            }
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Add GoogleApp to Database</h2></div>

            <div class="form-group">
                <label class="control-label col-md-5">Domain:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="domain" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-5">Year:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="year" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-5">Seat:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="maxSeat" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button name="add" class="btn btn-default">Add</button>
                </div>
            </div>
        </div>

        <div class="panel panel-warning col-md-offset-4 col-md-4">
            <div class="panel-heading">Log</div>
            <div class="panel-body" id="log"></div>
        </div>
    </body>
</html>