<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";




if(!empty($sid))
{
	$query = "update regist_tbl SET ";
}
else
{
	$query = "INSERT INTO regist_tbl SET ";
}
$query .= "code='".$_POST['code']."'";
for($i=1;$i<=40;$i++){

	if(${'type_'. $i}=="40"){
		${'val_'. $i} = ${'val_'. $i}[0]."@".${'val_'. $i}[1];
	}else if(${'type_'. $i}=="50"){
		${'val_'. $i} = ${'val_'. $i}[0]."-".${'val_'. $i}[1]."-".${'val_'. $i}[2];
	}else if(${'type_'. $i}=="60"){
		${'val_'. $i} = ${'val_'. $i}[0]."-".${'val_'. $i}[1]."-".${'val_'. $i}[2];
	}else if(${'type_'. $i}=="110"){
		${'val_'. $i} = ${'val_'. $i}[0]."&&".${'val_'. $i}[1]."&&".${'val_'. $i}[2];
	}else if(${'type_'. $i}=="120"){
		${'val_'. $i} = ucwords(${'val_'. $i}[0])."&&".ucwords(${'val_'. $i}[1]);
	}else if(${'type_'. $i}>"1000"){
		if(is_array(${'val_'. $i})){
			${'val2_'. $i} = "";
			for($k=0;$k<count(${'val_'. $i});$k++){
				if($k>0){
					${'val2_'. $i} .= ",";
				}
				${'val2_'. $i} .=  ${'val_'. $i}[$k];
			}

			${'val_'. $i} = ${'val2_'. $i};
		}
		else {
			if(${'val_etc_'. $i}) ${'val_'. $i} .= "&&".addslashes(${'val_etc_'. $i});
		}
	}

	$query .= ",info".$i."='".${'val_'. $i}."'";
	
}
$query .= " , memo = '".$memo."'";
$query .= " , pre_regist = ".$pre_regist_val;
if(empty($sid)) {
	$query .= " , signdate = ".time();
}
else {
	$query .= " where sid=".$sid;
}


//echo $query;exit;
mysqli_query($conn, $query);

?>
<script>
	opener.location.reload();
	window.close();
</script>