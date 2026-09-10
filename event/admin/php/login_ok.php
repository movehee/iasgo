<?
include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.function.php';
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
ob_start();

if($code=="admin" && $password=="m2comm"){
	
	setcookie('admin', 'admin', time() + 60*60*24, '/', $_cookie_domain);
	setcookie('code', '', time() + 60*60*24, '/', $_cookie_domain);
	RefreshURL("./event/list.php");

}else if($code=="kaim" && $password=="kaim02018"){
	setcookie('admin', 'kaim', time() + 60*60*24, '/', $_cookie_domain);
	setcookie('code', '', time() + 60*60*24, '/', $_cookie_domain);
	RefreshURL("./event/list.php");
}else if($code=="ksc" && $password=="admin"){
	setcookie('admin', 'ksc', time() + 60*60*24, '/', $_cookie_domain);
	setcookie('code', '', time() + 60*60*24, '/', $_cookie_domain);
	RefreshURL("./event/list.php");
}else{
	
	$sql = "select * from event_tbl where code='".$code."' and password='".$password."'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	if(!$row){
		RefreshURL("./login.php");
	} else {
		setcookie('code', $code, time() + 60*60*24, '/', $_cookie_domain);
		setcookie('password', $password, time() + 60*60*24, '/', $_cookie_domain);
		setcookie('admin', 'N', time() + 60*60*24, '/', $_cookie_domain);

		if($row['registrationYN']=="Y") {
			RefreshURL("./regist/list.php");
		}
		else {
			RefreshURL("./agenda/agenda.php");
		}
	}

}

?>