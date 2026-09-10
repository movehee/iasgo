<?
include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.function.php';
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

ob_start();
	
setcookie('name', $name, time() + 60*60*24, '/', $_cookie_domain);
setcookie('office', $office, time() + 60*60*24, '/', $_cookie_domain);
setcookie('email', $email, time() + 60*60*24, '/', $_cookie_domain);
setcookie('license', $license, time() + 60*60*24, '/', $_cookie_domain);
setcookie('mobile', $mobile, time() + 60*60*24, '/', $_cookie_domain);
setcookie('agree', $agree, time() + 60*60*24, '/', $_cookie_domain);


$query="SELECT * FROM event_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$event_col = mysqli_fetch_array($result);
//echo $query;
//echo $event_col['agendaYN'];

	RefreshURL("./../feedback/view.php?code=".$code);

?>