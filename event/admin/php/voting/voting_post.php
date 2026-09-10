<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/";

$file_query = "";
if($_FILES['image']['name'])
{
	$uploadfile = time().basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image = '".$uploadfile."'";
}

if($_FILES['answer1_img']['name'])
{
	$uploadfile = "1".time().basename($_FILES['answer1_img']['name']);
	move_uploaded_file($_FILES['answer1_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer1_img = '".$uploadfile."'";
}

if($_FILES['answer2_img']['name'])
{
	$uploadfile = "2".time().basename($_FILES['answer2_img']['name']);
	move_uploaded_file($_FILES['answer2_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer2_img = '".$uploadfile."'";
}

if($_FILES['answer3_img']['name'])
{
	$uploadfile = "3".time().basename($_FILES['answer3_img']['name']);
	move_uploaded_file($_FILES['answer3_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer3_img = '".$uploadfile."'";
}

if($_FILES['answer4_img']['name'])
{
	$uploadfile = "4".time().basename($_FILES['answer4_img']['name']);
	move_uploaded_file($_FILES['answer4_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer4_img = '".$uploadfile."'";
}

if($_FILES['answer5_img']['name'])
{
	$uploadfile = "5".time().basename($_FILES['answer5_img']['name']);
	move_uploaded_file($_FILES['answer5_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer5_img = '".$uploadfile."'";
}

if($_FILES['answer6_img']['name'])
{
	$uploadfile = "6".time().basename($_FILES['answer6_img']['name']);
	move_uploaded_file($_FILES['answer6_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer6_img = '".$uploadfile."'";
}

if($_FILES['answer7_img']['name'])
{
	$uploadfile = "7".time().basename($_FILES['answer7_img']['name']);
	move_uploaded_file($_FILES['answer7_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer7_img = '".$uploadfile."'";
}

if($_FILES['answer8_img']['name'])
{
	$uploadfile = "8".time().basename($_FILES['answer8_img']['name']);
	move_uploaded_file($_FILES['answer8_img']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",answer8_img = '".$uploadfile."'";
}





if(!empty($sid))
{
	$query = "update voting_tbl SET ";
	$query .= "lecture='".$_POST['lecture']."'";
	$query .= ",code='".$_COOKIE['code']."'";
	$query .= ",question='".$_POST['question']."'";
	$query .= ",answer1='".$_POST['answer1']."'";
	$query .= ",answer2='".$_POST['answer2']."'";
	$query .= ",answer3='".$_POST['answer3']."'";
	$query .= ",answer4='".$_POST['answer4']."'";
	$query .= ",answer5='".$_POST['answer5']."'";
	$query .= ",answer6='".$_POST['answer6']."'";
	$query .= ",answer7='".$_POST['answer7']."'";
	$query .= ",answer8='".$_POST['answer8']."'";
	$query .= ",correct='".$_POST['correct']."'";
	$query .= ",delay='".$_POST['delay']."'";
	$query .= ",start_type='".$_POST['start_type']."'";
	$query .= ",start_txt='".$_POST['start_txt']."'";
	$query .= ",type='".$_POST['type']."'";
	$query .= ",ui='".$_POST['ui']."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where lecture='".$_POST['lecture']."' and del='N'");
	$row = mysqli_fetch_array($result);


	$max = $row['maxs'];

	$query = "INSERT INTO voting_tbl SET ";
	$query .= "lecture='".$_POST['lecture']."'";
	$query .= ",code='".$_COOKIE['code']."'";
	$query .= ",question='".$_POST['question']."'";
	$query .= ",answer1='".$_POST['answer1']."'";
	$query .= ",answer2='".$_POST['answer2']."'";
	$query .= ",answer3='".$_POST['answer3']."'";
	$query .= ",answer4='".$_POST['answer4']."'";
	$query .= ",answer5='".$_POST['answer5']."'";
	$query .= ",answer6='".$_POST['answer6']."'";
	$query .= ",answer7='".$_POST['answer7']."'";
	$query .= ",answer8='".$_POST['answer8']."'";
	$query .= ",correct='".$_POST['correct']."'";
	$query .= ",delay='".$_POST['delay']."'";
	$query .= ",start_type='".$_POST['start_type']."'";
	$query .= ",start_txt='".$_POST['start_txt']."'";
	$query .= ",orderby='".($max+1)."'";
	$query .= ",type='".$_POST['type']."'";
	$query .= ",signdate='".time()."'";
	$query .= ",ui='".$_POST['ui']."'";
	$query .= $file_query;
}
mysqli_query($conn, $query);
?>

<script>
	opener.location.reload();
	window.close();
</script>