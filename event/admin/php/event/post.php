<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/logo/";


if($_FILES['logo']['name'])
{
	$uploadfile = time().basename($_FILES['logo']['name']);
	move_uploaded_file($_FILES['logo']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",logo = '".$uploadfile."'";
}

if($_FILES['login_img']['name'])
{
	$uploadfile = time().basename($_FILES['login_img']['name']);
	move_uploaded_file($_FILES['login_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",login_img = '".$uploadfile."'";
}



if($_POST['set_def']){



	
	mysqli_query($conn, "delete from session_set_tbl where code='".$_POST['code']."'");
	mysqli_query($conn, "delete from css_tbl where code='".$_POST['code']."'");

	$col_query = "SHOW COLUMNS FROM session_set_tbl";
	$col_result = mysqli_query($conn, $col_query);


	$before_query = "select * from session_set_tbl where code='".$_POST['set_def']."'";
	$before_result = mysqli_query($conn, $before_query);

	$before_col= mysqli_fetch_array($before_result);
	$query = "insert into session_set_tbl set ";
	$query .= " code='".$_POST['code']."' "; 
	while(is_array($col_d = mysqli_fetch_array($col_result))){
		if($col_d['Field']!="sid" && $col_d['Field']!="code"){
			$query .= ",".$col_d['Field'];
			$query .= "='".$before_col[$col_d['Field']]."'";
		}
	}
	mysqli_query($conn, $query);





	$col_query = "SHOW COLUMNS FROM css_tbl";
	$col_result = mysqli_query($conn, $col_query);


	$before_query = "select * from css_tbl where code='".$_POST['set_def']."'";
	echo $before_query;
	$before_result = mysqli_query($conn, $before_query);

	$before_col= mysqli_fetch_array($before_result);
	$query = "insert into css_tbl set ";
	$query .= " code='".$_POST['code']."' "; 
	while(is_array($col_d = mysqli_fetch_array($col_result))){
		if($col_d['Field']!="sid" && $col_d['Field']!="code"){
			$query .= ",".$col_d['Field'];
			$query .= "='".$before_col[$col_d['Field']]."'";
		}
	}
	mysqli_query($conn, $query);

	//echo $query;
	

}else{
	//$query = "insert into session_set_tbl set ";
	//$query .= " code='".$_POST['code']."' "; 
	
	//mysqli_query($conn, $query);
}

$eventdates = explode("-",$eventdate);

if(!$_POST['session_sync']) $_POST['session_sync'] = 'N';
if(!$_POST['agenda_session']) $_POST['agenda_session'] = 'N';

if(!empty($sid))
{
	$query = "update event_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",language='".$_POST['language']."'";
	$query .= ",gubun='".$_POST['gubun']."'";
	$query .= ",gubun_val='".$_POST['gubun_val']."'";
	$query .= ",password='".$_POST['password']."'";
	$query .= ",agendaYN='".$_POST['agendaYN']."'";
	$query .= ",votingYN='".$_POST['votingYN']."'";
	$query .= ",questionYN='".$_POST['questionYN']."'";
	$query .= ",feedbackYN='".$_POST['feedbackYN']."'";
	$query .= ",sessionYN='".$_POST['sessionYN']."'";
	$query .= ",registrationYN='".$_POST['registrationYN']."'";
	$query .= ",nameYN='".$_POST['nameYN']."'";
	$query .= ",officeYN='".$_POST['officeYN']."'";
	$query .= ",emailYN='".$_POST['emailYN']."'";
	$query .= ",licenseYN='".$_POST['licenseYN']."'";
	$query .= ",mobileYN='".$_POST['mobileYN']."'";
	$query .= ",admin='".$_COOKIE['admin']."'";
	$query .= ",manager='".$_POST['manager']."'";
	$query .= ",agreeYN='".$_POST['agreeYN']."'";
	$query .= ",agree_message='".$_POST['agree_message']."'";
	$query .= ",login_feedbackYN='".$_POST['login_feedbackYN']."'";
	$query .= ",session_sync='".$_POST['session_sync']."'";
	$query .= ",agenda_session='".$_POST['agenda_session']."'";
	$query .= ",sms_number='".$_POST['sms_number']."'";
	
	

	
	$query .= ",eventdate='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{
	$query = "INSERT INTO event_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",language='".$_POST['language']."'";
	$query .= ",gubun='".$_POST['gubun']."'";
	$query .= ",gubun_val='".$_POST['gubun_val']."'";
	$query .= ",password='".$_POST['password']."'";
	$query .= ",agendaYN='".$_POST['agendaYN']."'";
	$query .= ",votingYN='".$_POST['votingYN']."'";
	$query .= ",questionYN='".$_POST['questionYN']."'";
	$query .= ",feedbackYN='".$_POST['feedbackYN']."'";
	$query .= ",sessionYN='".$_POST['sessionYN']."'";
	$query .= ",registrationYN='".$_POST['registrationYN']."'";
	$query .= ",nameYN='".$_POST['nameYN']."'";
	$query .= ",officeYN='".$_POST['officeYN']."'";
	$query .= ",emailYN='".$_POST['emailYN']."'";
	$query .= ",licenseYN='".$_POST['licenseYN']."'";
	$query .= ",mobileYN='".$_POST['mobileYN']."'";
	$query .= ",admin='".$_COOKIE['admin']."'";
	$query .= ",manager='".$_POST['manager']."'";
	$query .= ",agreeYN='".$_POST['agreeYN']."'";
	$query .= ",agree_message='".$_POST['agree_message']."'";
	$query .= ",login_feedbackYN='".$_POST['login_feedbackYN']."'";
	$query .= ",session_sync='".$_POST['session_sync']."'";
	$query .= ",agenda_session='".$_POST['agenda_session']."'";
	$query .= ",sms_number='".$_POST['sms_number']."'";
	$query .= ",eventdate='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";
	$query .= $file_query;
}

mysqli_query($conn, $query);

?>

<script>
	opener.location.reload();
	window.close();
</script>