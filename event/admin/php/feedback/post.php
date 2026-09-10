<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/feedback/";

$file_query = "";
if($_FILES['image']['name'])
{
	$uploadfile = time().basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image = '".$uploadfile."'";
}


if($_POST['type']=="32"){
	ob_start();
	setcookie('sub1', $_POST['sub1'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('sub2', $_POST['sub2'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('sub3', $_POST['sub3'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('sub4', $_POST['sub4'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('sub5', $_POST['sub5'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('sub6', $_POST['sub6'], time() + 60*60*24, '/', $_cookie_domain);
	setcookie('necessary_txt', $_POST['necessary_txt'], time() + 60*60*24, '/', $_cookie_domain);
}

if(!empty($_COOKIE['code']))
{
	$query="SELECT * FROM event_tbl where code='".$_COOKIE['code']."'";
	$result = mysqli_query($conn, $query);
	$event_db= mysqli_fetch_array($result);
}else if ($_COOKIE['admin']!="M"){
	RefreshURL("/admin/php/login.php");
}




$cnt = 0;
if($_POST['sub1'])
	$cnt++;
if($_POST['sub2'])
	$cnt++;
if($_POST['sub3'])
	$cnt++;
if($_POST['sub4'])
	$cnt++;
if($_POST['sub5'])
	$cnt++;
if($_POST['sub6'])
	$cnt++;
if($_POST['sub7'])
	$cnt++;
if($_POST['sub8'])
	$cnt++;
if($_POST['sub9'])
	$cnt++;
if($_POST['sub10'])
	$cnt++;
if($_POST['sub11'])
	$cnt++;
if($_POST['sub12'])
	$cnt++;
if($_POST['sub13'])
	$cnt++;
if($_POST['sub14'])
	$cnt++;
if($_POST['sub15'])
	$cnt++;
if($_POST['sub16'])
	$cnt++;
if($_POST['sub17'])
	$cnt++;
if($_POST['sub18'])
	$cnt++;
if($_POST['sub19'])
	$cnt++;
if($_POST['sub20'])
	$cnt++;


if($sid)
{
	$query = "update feedback_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ",type='".$_POST['type']."'";
	$query .= ",val1='".$_POST['val1']."'";
	$query .= ",val2='".$_POST['val2']."'";
	$query .= ",cnt='".$cnt."'";
	$query .= ",max='".$_POST['max']."'";
	$query .= ",necessary='".$_POST['necessary']."'";
	$query .= ",necessary_txt='".$_POST['necessary_txt']."'";
	$query .= ",parent_val='".$_POST['parent_val']."'";
	$query .= ",answer_field='".$_POST['answer_field']."'";
	$query .= ",parent='".$_POST['parent']."'";

	
	$query .= ",sub1='".$_POST['sub1']."'";
	$query .= ",sub2='".$_POST['sub2']."'";
	$query .= ",sub3='".$_POST['sub3']."'";
	$query .= ",sub4='".$_POST['sub4']."'";
	$query .= ",sub5='".$_POST['sub5']."'";
	$query .= ",sub6='".$_POST['sub6']."'";
	$query .= ",sub7='".$_POST['sub7']."'";
	$query .= ",sub8='".$_POST['sub8']."'";
	$query .= ",sub9='".$_POST['sub9']."'";
	$query .= ",sub10='".$_POST['sub10']."'";
	$query .= ",sub11='".$_POST['sub11']."'";
	$query .= ",sub12='".$_POST['sub12']."'";
	$query .= ",sub13='".$_POST['sub13']."'";
	$query .= ",sub14='".$_POST['sub14']."'";
	$query .= ",sub15='".$_POST['sub15']."'";
	$query .= ",sub16='".$_POST['sub16']."'";
	$query .= ",sub17='".$_POST['sub17']."'";
	$query .= ",sub18='".$_POST['sub18']."'";
	$query .= ",sub19='".$_POST['sub19']."'";
	$query .= ",sub20='".$_POST['sub20']."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{
	$result = mysqli_query($conn, "select max(orderby) max from feedback_tbl where code='".$_COOKIE['code']."' and del='N'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];
	$query = "INSERT INTO feedback_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ",type='".$_POST['type']."'";
	$query .= ",val1='".$_POST['val1']."'";
	$query .= ",val2='".$_POST['val2']."'";
	$query .= ",cnt='".$cnt."'";
	$query .= ",max='".$_POST['max']."'";
	$query .= ",necessary='".$_POST['necessary']."'";
	$query .= ",necessary_txt='".$_POST['necessary_txt']."'";
	$query .= ",parent_val='".$_POST['parent_val']."'";
	$query .= ",answer_field='".$_POST['answer_field']."'";
	$query .= ",parent='".$_POST['parent']."'";
	$query .= ",sub1='".$_POST['sub1']."'";
	$query .= ",sub2='".$_POST['sub2']."'";
	$query .= ",sub3='".$_POST['sub3']."'";
	$query .= ",sub4='".$_POST['sub4']."'";
	$query .= ",sub5='".$_POST['sub5']."'";
	$query .= ",sub6='".$_POST['sub6']."'";
	$query .= ",sub7='".$_POST['sub7']."'";
	$query .= ",sub8='".$_POST['sub8']."'";
	$query .= ",sub9='".$_POST['sub9']."'";
	$query .= ",sub10='".$_POST['sub10']."'";
	$query .= ",sub11='".$_POST['sub11']."'";
	$query .= ",sub12='".$_POST['sub12']."'";
	$query .= ",sub13='".$_POST['sub13']."'";
	$query .= ",sub14='".$_POST['sub14']."'";
	$query .= ",sub15='".$_POST['sub15']."'";
	$query .= ",sub16='".$_POST['sub16']."'";
	$query .= ",sub17='".$_POST['sub17']."'";
	$query .= ",sub18='".$_POST['sub18']."'";
	$query .= ",sub19='".$_POST['sub19']."'";
	$query .= ",sub20='".$_POST['sub20']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= $file_query;

	//echo $query;
}

mysqli_query($conn, $query);
?>

<script>
	opener.location.reload();
	window.close();
</script>