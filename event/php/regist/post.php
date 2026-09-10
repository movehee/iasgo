<?
@error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	//echo "<pre>";
	//print_r($_POST);
}

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

		//echo ${'val_etc_'. $i};
		

	} 
	
	$query .= ",info".$i."='".${'val_'. $i}."'";
	/*
	echo ${'type_'. $i};
	echo "<br>";
	echo ${'val_'. $i};
	echo "<br>";
	*/
	
}
$query .= " , pre_regist = ".$pre_regist_val;

if(empty($sid)) {
	$query .= " , signdate = ".time();
}
else {
	$query .= " where sid=".$sid;
}
//echo "사용자등록"."<br>";

mysqli_query($conn, $query);

?>
<script>
	var temp = "<? echo $setting_col['regist_alert_message']?> ";
	alert(temp);
	location.href="./index.php?code=<?=$code?>";
</script>