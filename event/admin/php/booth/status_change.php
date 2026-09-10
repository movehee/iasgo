<?php
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$query = "update booth_tbl set `$f_name` = '$val' where sid='$sid'";
mysqli_query($conn, $query);
