<?php

session_start();
require_once dirname(__FILE__) . '/google-api-php-client-master/src/Google/Client.php';
require_once dirname(__FILE__) . '/google-api-php-client-master/src/Google/Service/Reseller.php';
require_once dirname(__FILE__) . '/google-api-php-client-master/src/Google/Service/SiteVerification.php';
require_once dirname(__FILE__) . '/google-api-php-client-master/src/Google/Service/Directory.php';

$KEY_FILE = dirname(__FILE__) . '/google-api-php-client-master/src/Google/e837f614eda10f1b80551d8405e1b15c83a484b5-privatekey.p12';
$auth = new Google_Auth_AssertionCredentials(
        '928575669326-itvroftivdd0pt8dku0oe2r6rqgrnfor@developer.gserviceaccount.com', 
        array('https://www.googleapis.com/auth/apps.order', 
            'https://www.googleapis.com/auth/apps.order.readonly', 
            'https://www.googleapis.com/auth/siteverification', 
            'https://www.googleapis.com/auth/siteverification.verify_only',
            'https://www.googleapis.com/auth/admin.directory.user',
            'https://www.googleapis.com/auth/admin.directory.user.readonly'), 
        file_get_contents($KEY_FILE));
$auth->sub = 'googleapp.api@reseller.readyplanet.net';

$client = new Google_Client();
$client->setAssertionCredentials($auth);
?>