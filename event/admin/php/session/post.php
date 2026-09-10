<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/session/";

if($_FILES['highlight_image']['name'])
{
	$needle = strrpos(basename($_FILES['highlight_image']['name']), ".") + 1;
	$slice = substr(basename($_FILES['highlight_image']['name']), $needle);
	$uploadfile = time().$_POST['code']."1.".$slice;
	move_uploaded_file($_FILES['highlight_image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",highlight_image = '".$uploadfile."'";
}


if($etc_info) {
	$etc_info_val = implode("|", $etc_info);
}

if(!empty($sid))
{
	$query = "update session_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",type='1'";
	$query .= ",category1='".$_POST['category1']."'";
	$query .= ",category2='".$_POST['category2']."'";
	$query .= ",theme='".$_POST['theme']."'";
	$query .= ",sub_theme='".$_POST['sub_theme']."'";
	$query .= ",room='".$_POST['room']."'";
	$query .= ",chair='".$_POST['chair']."'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",panel='".$_POST['panel']."'";
	$query .= ",highlight='".$_POST['highlight']."'";
	$query .= ",memo='".$_POST['memo']."'";
	
	
	$query .= ",discusser='".$_POST['discusser']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",viewYN2='".$_POST['viewYN2']."'";
	$query .= ",sc_viewYN='".$_POST['sc_viewYN']."'";
	$query .= ",qna_viewYN='".$_POST['qna_viewYN']."'";
	$query .= ",link_session='".$_POST['link_session']."'";
	$query .= ",etc_info='".$etc_info_val."'";
	$query .= ",liveYN='".$_POST['liveYN']."'";
	$query .= ",live_url_and='".$_POST['live_url_and']."'";
	$query .= ",live_url_ios='".$_POST['live_url_ios']."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from session_tbl where code='".$code."' and tab='".$_POST['tab']."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];

	$query = "INSERT INTO session_tbl SET ";

	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",type='1'";
	$query .= ",category1='".$_POST['category1']."'";
	$query .= ",category2='".$_POST['category2']."'";
	$query .= ",theme='".$_POST['theme']."'";
	$query .= ",sub_theme='".$_POST['sub_theme']."'";
	$query .= ",room='".$_POST['room']."'";
	$query .= ",chair='".$_POST['chair']."'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",panel='".$_POST['panel']."'";
	$query .= ",highlight='".$_POST['highlight']."'";
	$query .= ",memo='".$_POST['memo']."'";
	$query .= ",discusser='".$_POST['discusser']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",viewYN2='".$_POST['viewYN2']."'";
	$query .= ",sc_viewYN='".$_POST['sc_viewYN']."'";
	$query .= ",qna_viewYN='".$_POST['qna_viewYN']."'";
	$query .= ",etc_info='".$etc_info_val."'";
	$query .= ",liveYN='".$_POST['liveYN']."'";
	$query .= ",live_url_and='".$_POST['live_url_and']."'";
	$query .= ",live_url_ios='".$_POST['live_url_ios']."'";
	$query .= ",link_session='".$_POST['link_session']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= $file_query;
}

$conn->query($query);
//echo $query;
?>
<script>
	opener.location.reload();
	window.close();
</script>
