<?php
include 'config/config.php'; 

$recordset = new JSONRecordSet($ini['about']['database']['dbname']);

$page = new Router($recordset);
New View($page);
?>