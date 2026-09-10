<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$query = "SELECT * FROM bbs_tbl where code='".$code."' and del ='N' and showYN='Y' ";	
$query .= " order by signdate desc limit 1";
$result = mysqli_query($conn, $query);
$_new_day=1; # 새 게시물 아이콘 표시 기간
$_new_day_time=time()-(60*60*24*$_new_day);
$col = mysqli_fetch_array($result);

if($_new_day_time < $col['signdate']){
	echo "Y";
}else{
	echo "N";
}