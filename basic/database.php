<?php

$serverName = "LAPTOP-EB30BL56\SQLEXPRESS";
$connectionInfo = [
    "Database" => "phpcrud"
];

$conn = sqlsrv_connect($serverName, $connectionInfo) or die(print_r(sqlsrv_errors(), true));