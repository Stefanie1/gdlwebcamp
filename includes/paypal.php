<?php
require 'paypal/autoload.php';

define('URL_SITIO','http://localhost/gdlwebcamp');

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AXDADY81hKTYaWVDcObERBz1ri8WYZOXIFiIRmneWKwDQcLbK2hzSKm6ZFzlS04dr66vp2NkjRKwT4Id',    //CLIENTE ID
        'EKWZmq9XZfPQmejJDvI0o30I9xhIEvzqX5H2hI2LxVnuYsR2Ci2LoLF7LV7E-HJ8favyswBOn8aXMPRw'      //SECRET
    )
);
//var_dump($apiContext);