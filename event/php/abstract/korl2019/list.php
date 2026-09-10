<?php
include_once "config.php";

$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and a.category1='$category1' ";
$result = mysqli_query($conn, $query);
?>

<?
include_once $_SERVER['DOCUMENT_ROOT']."/php/session/info.php";
?>

