<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/booth/";

if($_FILES['image']['name'])
{
	/*
	$arr = explode(".", $_FILES['image']['name']);
	$ext = array_pop($arr);
	$origin_name = join(".", $arr);
	$_FILES['image']['name'] = iconv("UTF-8", "euc-kr", $origin_name.".".$ext);
	if(empty($_FILES['image']['name']))
	{
	$_FILES['image']['name'] = mb_convert_encoding($origin_name.".".$ext, "EUC-KR");
	}
*/

	$uploadfile = time().$_FILES['image']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image = '".$uploadfile."'";
}

if($_FILES['image2']['name'])
{

	$uploadfile = time().$_FILES['image2']['name'];
	move_uploaded_file($_FILES['image2']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image2 = '".$uploadfile."'";
}

if($_FILES['info_image']['name'])
{
	$uploadfile = time().$_FILES['info_image']['name'];
	move_uploaded_file($_FILES['info_image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",info_image = '".$uploadfile."'";
}

if($_FILES['info_pdf']['name'])
{

	$uploadfile = time().$_FILES['info_pdf']['name'];
	move_uploaded_file($_FILES['info_pdf']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",info_pdf = '".$uploadfile."'";
}



if(!empty($sid))
{
	$query = "update booth_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",name_en='".$_POST['name_en']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",vip='".$_POST['vip']."'";
	$query .= ",linkurl='".$_POST['linkurl']."'";
	$query .= ",add_booth_chk='".$_POST['add_booth_chk']."'";
	$query .= ",id='".$_POST['idea']."'";
	$query .= ",password='".$_POST['password']."'";
	$query .= ",event_YN='".$_POST['event_YN']."'";
	$query .= ",event2_YN='".$_POST['event2_YN']."'";
	$query .= ",booth_num='".$_POST['booth_num']."'";
	$query .= ",booth_type='".$_POST['booth_type']."'";
	$query .= ",content='".$_POST['content']."'";
	$query .= ",email='".$_POST['email']."'";
	$query .= ",manager='".$_POST['manager']."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from booth_tbl where code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];

	$query = "INSERT INTO booth_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",name_en='".$_POST['name_en']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",vip='".$_POST['vip']."'";
	$query .= ",linkurl='".$_POST['linkurl']."'";
	$query .= ",add_booth_chk='".$_POST['add_booth_chk']."'";
	$query .= ",id='".$_POST['idea']."'";
	$query .= ",password='".$_POST['password']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= ",event_YN='".$_POST['event_YN']."'";
	$query .= ",event2_YN='".$_POST['event2_YN']."'";
	$query .= ",booth_num='".$_POST['booth_num']."'";
	$query .= ",booth_type='".$_POST['booth_type']."'";
	$query .= ",content='".$_POST['content']."'";
	$query .= ",email='".$_POST['email']."'";
	$query .= ",manager='".$_POST['manager']."'";
	$query .= $file_query;
}

$conn->query($query);
//echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>