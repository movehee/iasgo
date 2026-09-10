<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	
	foreach($code as $tkey=>$tval){
		$query = "update country_tbl set name_1='".$name_1[$tkey]."'";
		$query .= ", name_2='".$name_2[$tkey]."'";
		$query .= " where code='".$tval."'";	
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}

	$file = fopen($_SERVER['DOCUMENT_ROOT']."../webinar/func/config/flag.php","w");
	$file2 = fopen($_SERVER['DOCUMENT_ROOT']."../mobile/func/config/flag.php","w");
	$file3 = fopen($_SERVER['DOCUMENT_ROOT']."/func/config/flag.php","w");
	
	$create_arr = "<?\n";

	$query = "select * from country_tbl where name_1!='' or name_2!=''";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$create_arr .= "\$_Flag['country'] = array(\n";

	while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$create_arr .= "'".$d['name_1']."'=>'".$d['code']."',\n";
		if($d['name_2']){
			$create_arr .= "'".$d['name_2']."'=>'".$d['code']."',\n";
		}
	}

	$create_arr .= ");\n\n";
	$create_arr .= "?>";

	fwrite($file,$create_arr);
	fclose($file);

	fwrite($file2,$create_arr);
	fclose($file2);

	fwrite($file3,$create_arr);
	fclose($file3);
?>
<script>
	alert("저장되었습니다.");
	location.href="/?kind=country";
</script>