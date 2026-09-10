<?
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

	if(!$tab){
		$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N' and glanceYN='Y'");
		$row = mysqli_fetch_array($result);
		$tab = $row['sid'];

		if(!$tab){

			if($code == "icorl2020") {
			$tab = '211';
			} else {

			$result = mysqli_query($conn, "SELECT sid from agenda_tbl where code='".$code."' and del='N' and glanceYN='Y' order by sid asc limit 1");
			$row = mysqli_fetch_array($result);
			$tab = $row['sid'];
			}
		}
	}

	$css_query="SELECT * FROM css_tbl where code='".$code."'";
	$result = mysqli_query($conn, $css_query);
	$css_col = mysqli_fetch_array($result);

	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);
	
	if(!$css_col['session_topmenu_bg']) {
		$css_col['session_topmenu_bg']="323c57";
	}

	if(!$css_col['session_topmenu_font']) {
		$css_col['session_topmenu_font']="ffffff";
	}

	if(!$css_col['menu_bg']) {
		$css_col['menu_bg']="249f9b";
	}
	if(!$css_col['menu_bg_on']) {
		$css_col['menu_bg_on']="ffffff";
	}
	if(!$css_col['menu_font']) {
		$css_col['menu_font']="ffffff";
	}
	if(!$css_col['menu_font_on']) {
		$css_col['menu_font_on']="000000";
	}
	if(!$css_col['session_day_bg']) {
		$css_col['session_day_bg']="2d63bb";
	}


	$day_query="SELECT * FROM agenda_tbl where code='".$code."' and glanceYN='Y' and del='N' order by eventdate asc";
	$day_result = mysqli_query($conn, $day_query);
	if($setting_col['day_type']=="1"){
		while(is_array($day_col = mysqli_fetch_array($day_result))){
				$json2 [] = array(
					'tab'=>$day_col['sid'],
					'name'=>str_replace("<br>", "\n", $day_col['name'])
				);
		}
	} else if($setting_col['day_type']=="2") {

		$cnt = mysqli_num_rows($day_result);

		
		
		$day_col = mysqli_fetch_array($day_result);
		$mon = date("M.",$day_col['eventdate']);
		mysqli_data_seek($day_result,0); 

		if($cnt<4){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>date("D",$day_col['eventdate']-2*24*60*60),
				'day'=>date("d",$day_col['eventdate']-2*24*60*60)
			);
		}
		if($cnt<6){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>date("D",$day_col['eventdate']-1*24*60*60),
				'day'=>date("d",$day_col['eventdate']-1*24*60*60)
			);
			
		}
		while(is_array($day_col = mysqli_fetch_array($day_result))){
			$last_day = $day_col['eventdate'];
	
			$json2 [] = array(
				'tab'=>$day_col['sid'],
				'week'=>date("D",$day_col['eventdate']),
				'day'=>date("d",$day_col['eventdate'])
			);
		}
		

		if($cnt<6){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>date("D",$last_day+1*24*60*60),
				'day'=>date("d",$last_day+1*24*60*60)
			);
			
		}
		if($cnt<4){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>date("D",$last_day+2*24*60*60),
				'day'=>date("d",$last_day+2*24*60*60)
			);
		
		}
	} else if($setting_col['day_type']=="3") {
		$yoil = array("일","월","화","수","목","금","토");

		$cnt = mysqli_num_rows($day_result);

		
		
		$day_col = mysqli_fetch_array($day_result);
		$mon = date("n 월",$day_col['eventdate']);
		mysqli_data_seek($day_result,0); 

		if($cnt<4){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>$yoil[date("w",$day_col['eventdate']-2*24*60*60)],
				'day'=>date("d",$day_col['eventdate']-2*24*60*60)
			);
		}
		if($cnt<6){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>$yoil[date("w",$day_col['eventdate']-1*24*60*60)],
				'day'=>date("d",$day_col['eventdate']-1*24*60*60)
			);
			
		}
		while(is_array($day_col = mysqli_fetch_array($day_result))){
			$last_day = $day_col['eventdate'];
	
			$json2 [] = array(
				'tab'=>$day_col['sid'],
				'week'=>$yoil[date("w",$day_col['eventdate'])],
				'day'=>date("d",$day_col['eventdate'])
			);
		}
		

		if($cnt<6){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>$yoil[date("w",$last_day+1*24*60*60)],
				'day'=>date("d",$last_day+1*24*60*60)
			);
			
		}
		if($cnt<4){
			$json2 [] = array(
				'tab'=>-1,
				'week'=>$yoil[date("w",$last_day+2*24*60*60)],
				'day'=>date("d",$last_day+2*24*60*60)
			);
		
		}
	}


	$json =  array(
		'day_type'=>$setting_col['day_type'],
		'bottom_menu'=>$setting_col['bottom_menu'],

		'bottom_menu_now'=>$setting_col['bottom_menu_now'],
		'bottom_menu_program'=>$setting_col['bottom_menu_program'],
		'bottom_menu_glance'=>$setting_col['bottom_menu_glance'],
		'bottom_menu_myfav'=>$setting_col['bottom_menu_myfav'],
		'bottom_menu_category'=>$setting_col['bottom_menu_category'],
		'session_topmenu_bg'=>str_replace("#","",$css_col['session_topmenu_bg']),
		'session_topmenu_font'=>str_replace("#","",$css_col['session_topmenu_font']),
		'menu_bg'=>str_replace("#","",$css_col['menu_bg']),
		'menu_bg_on'=>str_replace("#","",$css_col['menu_bg_on']),
		'menu_font'=>str_replace("#","",$css_col['menu_font']),
		'menu_font_on'=>str_replace("#","",$css_col['menu_font_on']),
		'session_day_bg'=>str_replace("#","",$css_col['session_day_bg']),
		'tab'=>$tab,
		'mon'=>$mon,
		'day'=> $json2
	);

	echo json_encode($json);
?>