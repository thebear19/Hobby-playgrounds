<?php
include "resellerFunction.php";
include "../inc_checkerror.php";

if (!empty($_POST[domain])) {
    try {
        $service = new Google_Service_Reseller($client);

        $response = $service->subscriptions->listSubscriptions(array("customerId" => $_POST[domain]));
        $service->subscriptions->suspend($_POST[domain], $response[0]->subscriptionId);

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
        <title>Delete GoogleApp</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

        <script>
            $(document).ready(function () {
                $("button[name='delete']").click(function () {
                    deleteDomain();
                });
            });

            function deleteDomain() {
                //ajax call
                $.ajax({
                    url: "deleteGApp.php",
                    data: {"domain": $('input[name="domain"]').val()},
                    type: "POST",
                    beforeSend: function () {
                        $('button[name="delete"]').html("<i class='fa fa-spinner fa-spin'></i>");
                        $("button[name='delete']").attr("disabled", "disabled");
                        $("#log").html("");
                    },
                    success: function(data) {
                        var JSONArray = $.parseJSON(data);

                        if (JSONArray.hasOwnProperty('error')) {
                            $("#log").html(JSONArray.error.message);
                        }
                        else if (JSONArray.hasOwnProperty('results')) {
                            $("#log").html(JSONArray.results);
                        }
                    },
                    error: function(jqXHR, textStatus, ex) {
                        $("#log").html(textStatus + "," + ex + "," + jqXHR.responseText);
                    },
                    complete: function () {
                        $('button[name="delete"]').html("Delete");
                        $("button[name='delete']").removeAttr("disabled");
                    }
                });
            }
        </script>
    </head>
    <body style="background-color: #F5F5F5;">
        <div class="form-horizontal" align='center'>
            <div class="form-group"><h2>Delete GoogleApp</h2></div>

            <div class="form-group">
                <label class="control-label col-md-5">Domain:</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="domain" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button name="delete" class="btn btn-default">Delete</button>
                </div>
            </div>
        </div>

        <div class="panel panel-warning col-md-offset-3 col-md-6">
            <div class="panel-heading">Log</div>
            <div class="panel-body" id="log"></div>
        </div>
    </body>
</html>