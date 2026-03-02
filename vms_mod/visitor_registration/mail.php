<?php
$to      = "hasibulhamim2020@gmail.com";
$subject = "Test Mail from VMS Server";
$message = "<h3>It works!</h3><p>Server can send email.</p>";
$headers  = "From:info@erp.com.bd\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$result = mail($to, $subject, $message, $headers);

echo $result ? "? mail() returned TRUE — check your inbox" 
             : "? mail() returned FALSE — server cannot send";
?>