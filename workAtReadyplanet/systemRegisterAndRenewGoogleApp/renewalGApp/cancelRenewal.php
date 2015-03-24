<!DOCTYPE html>
<html>
    <title>Cancel Renewal Google App</title>
    <head>
        <meta charset="utf-8" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <style type="text/css">
            table { padding-top: 10px; }
            tr:hover { background-color: #FDFCDA; }
            td {padding-right: 10px; padding-right: 20px; padding-bottom: 10px; font-size: 20px;}
        </style>
        <script>
            $(document).ready(function() {
                
                $("button[name='cancelRenew']").click(function() {
                    var domain = $("input[name='domain']").val();
                    
                    if(domain != ''){
                        $("#result").html("<i class='fa fa-spinner fa-spin'></i>");//Loading...
                        $.post("ResellerAPI.php",
                            {
                                cancelRenew: "",
                                domain: domain
                            }
                        )
                        .done(function(data) {
                            var JSONArray = $.parseJSON(data);
                    
                            if(JSONArray.hasOwnProperty('error')){
                                $("#result").html(JSONArray.error.message);
                            }
                            else if(JSONArray.hasOwnProperty('results')){
                                $("#result").html(data);
                                alert ("Complete !!");
                                window.close();
                            }
                        })
                        .fail(function(xhr, textStatus, errorThrown) {
                            $("#result").html(errorThrown);
                        });
                    }else{
                        alert ("Please specify domain name. !!");
                    }
                });
            });
        </script>
    </head>
    <body>
        <fieldset style="width:450px;"><legend>Cancel Renewal Google App</legend>
            <center>
                <div id="result">
                    <table cellspacing="0">
                        <tr>
                            <td>
                                <input type="text" name="domain" value="" placeholder="Domain Name" />
                            </td>
                        </tr>
                    </table>
                    <br />
                    <button name="cancelRenew">Submit</button>
                </div>
            </center>
        </fieldset>
    </body>
</html>