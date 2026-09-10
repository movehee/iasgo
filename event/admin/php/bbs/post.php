<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$pushdates = explode("-",$pushdate);
$pushdate2s = explode(":",$pushdate2);



if(!empty($sid))
{
	$query = "update bbs_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",subject='".$_POST['subject']."'";
	$query .= ",content='".$_POST['content']."'";
	$query .= ",showYN='".$_POST['showYN']."'";
	$query .= ",notiYN='".$_POST['notiYN']."'";
	if($pushdate && $pushdate2){
		if ( $old_date != mktime($pushdate2s[0], $pushdate2s[1], 0, $pushdates[1], $pushdates[2], $pushdates[0])) {
			$query .= ",push_date='".mktime($pushdate2s[0], $pushdate2s[1], 0, $pushdates[1], $pushdates[2], $pushdates[0])."', pushYN='N'";	
		}
	}
	$query .= " where sid=".$sid;
}
else
{

	if($_POST['notiYN']=="Y"){

		$query = "update bbs_tbl SET ";
		$query .= "orderby=orderby+1";
		$query .= " where code='".$_POST['code']."'";
		$conn->query($query);

		$query = "INSERT INTO bbs_tbl SET ";
		$query .= "code='".$_POST['code']."'";
		$query .= ",subject='".$_POST['subject']."'";
		$query .= ",content='".$_POST['content']."'";
		$query .= ",showYN='".$_POST['showYN']."'";
		$query .= ",notiYN='".$_POST['notiYN']."'";
		$query .= ",orderby='1'";
		$query .= ",signdate='".time()."'";
	}else{
		$result = mysqli_query($conn, "select max(orderby) max from bbs_tbl where code='".$code."' and notiYN = 'Y' and del='N'");
		$row = mysqli_fetch_array($result);
		if($row['max']){
			$maxs = $row['max'];
		}else{
			$maxs = 0;
		}
		
		
		$query = "update bbs_tbl SET ";
		$query .= "orderby=orderby+1";
		$query .= " where code='".$_POST['code']."'";
		$query .= " and orderby > ".$maxs;
		$conn->query($query);
		
		$query = "INSERT INTO bbs_tbl SET ";
		$query .= "code='".$_POST['code']."'";
		$query .= ",subject='".$_POST['subject']."'";
		$query .= ",content='".$_POST['content']."'";
		$query .= ",showYN='".$_POST['showYN']."'";
		$query .= ",notiYN='".$_POST['notiYN']."'";
		$query .= ",orderby=".($maxs+1);
		$query .= ",signdate='".time()."'";
		
	}
	if($pushdate && $pushdate2){
		$query .= ",push_date='".mktime($pushdate2s[0], $pushdate2s[1], 0, $pushdates[1], $pushdates[2], $pushdates[0])."', pushYN='N'";
	}
		




	
}
$conn->query($query);
?>
<script>
	opener.location.reload();
	window.close();
</script>