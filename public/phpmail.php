<?php
// the message
$msg = "TESTMAIL";
$headers = "From: ofis@oryx.kz" . "\r\n";
$rr = mail("ofis@oryx.kz","My subject",$msg, $headers);
print_r(error_get_last());
print_r($rr);
var_dump($rr);
?>