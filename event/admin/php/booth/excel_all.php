<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



if($excel_type!='view') {

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=".$code."_".$sid.".xls"); 
header( "Content-Description: PHP4 Generated Data" ); 

}


$query="SELECT * FROM booth_event_tbl a, booth_tbl b where a.booth_sid=b.sid and (b.event_YN='Y' or b.event2_YN='Y') and a.code='".$code."' order by booth_sid";
$result = mysqli_query($conn, $query);
?>


<table class="tblList">
	<tr>
		<td>Name</td>
		<td>Office</td>
	</tr>
	<?
	
		$hostName = "121.254.129.98";
		$userName = "koa2016";
		$userPassword = "koa2016!@#";
		$dbName = "koa2019";

		##### 데이터베이스에 연결한다.
		if(!class_exists("DB")) {
		   include "DB.php";
		}

		##### 데이터베이스에 연결한다.
		$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
		$local_conn = DB::connect($dsn);
		if(DB::isError($local_conn)) {
		   die ($local_conn->getMessage());
		}
		$local_conn->query("set names utf8");

		unset($dsn);




	?>
		<?while(is_array($d = mysqli_fetch_array($result))){

			$i++;
		
			$query = "SELECT * from prepare_tbl where sid='$d[user_sid]' ";
			$pre_result=$local_conn->query($query);
			if(DB::isError($pre_result)) die($pre_result->getMessage());
			$pre_result->fetchInto(&$pre, DB_FETCHMODE_ASSOC);
			$pre_result->free();
			
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$d['name']?></td>
				<td>
					<?=$pre['name']?>
				</td>
				<td>
					<?=$pre['hname']?>
				</td>
			</tr>
		<?}?>
	
</table>
   

<?include "./../footer.php";?>