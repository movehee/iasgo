<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/memo/";
$file_query ="";
if($_FILES['userfile1']['name'])
{
	$uploadfile = $code."_".time()."1".basename($_FILES['userfile1']['name']);
	move_uploaded_file($_FILES['userfile1']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",file1 = '".$uploadfile."'";
}else if(!$file1){
	$file_query .=",file1 = ''";
}
if($_FILES['userfile2']['name'])
{
	$uploadfile = $code."_".time()."2".basename($_FILES['userfile2']['name']);
	move_uploaded_file($_FILES['userfile2']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",file2 = '".$uploadfile."'";
}else if(!$file2){
	$file_query .=",file2 = ''";
}
if($_FILES['userfile3']['name'])
{
	$uploadfile = $code."_".time()."3".basename($_FILES['userfile3']['name']);
	move_uploaded_file($_FILES['userfile3']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",file3 = '".$uploadfile."'";
}else if(!$file3){
	$file_query .=",file3 = ''";
}

//echo $file_query;

$result = mysqli_query($conn, "select count(*) cnt from session_memo_tbl where deviceid='".$deviceid."' and session_sid='".$session_sid."'");
$row = mysqli_fetch_array($result);


if($row['cnt']>0)
{
	$query = "update session_memo_tbl SET ";
	$query .= "deviceid='".$deviceid."'";
	$query .= ",session_sid='".$session_sid."'";
	$query .= ",memo='".$memo_txt."'";
	$query .= $file_query;
	$query .= " where deviceid='".$deviceid."' and session_sid='".$session_sid."'";
}
else
{

	$query = "INSERT INTO session_memo_tbl SET ";
	$query .= "deviceid='".$deviceid."'";
	$query .= ",session_sid='".$session_sid."'";
	$query .= ",memo='".$memo_txt."'";
	$query .= $file_query;
}
mysqli_query($conn, $query);

echo $query;

echo "Y";




