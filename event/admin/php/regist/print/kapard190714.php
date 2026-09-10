<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/admin/php/regist/print/print_header.php";


function makeBarcode($text,$abyear,$group = false){
	
	//바코드에 접두어를 붙여서 구분 해준다.
	if($group){
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/group/";		
		$filename = $save_dir.$text.".png";
		$text = $text;
	}else{
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/";	
		$filename = $save_dir.$text.".png";
		$text = $text;
	}
	
	// Loading Font
	$font = new BCGFontFile($_SERVER['DOCUMENT_ROOT'].'barcode/font/Arial.ttf', 10);
		
	// The arguments are R, G, B for color.
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);
	
	$drawException = null;
	try {
	    $code = new BCGcode39();
	    $code->setScale(2); // Resolution
	    $code->setThickness(30); // Thickness
	    $code->setForegroundColor($color_black); // Color of bars
	    $code->setBackgroundColor($color_white); // Color of spaces
	    $code->setFont($font); // Font (or 0)
	    $code->parse($text); // Text
	} catch(Exception $exception) {
	    $drawException = $exception;
	}
	
	if(!is_dir($save_dir)){ @mkdir($save_dir, 0777); }
	
	
	$drawing = new BCGDrawing($filename, $color_white);
	if($drawException) {
	    $drawing->drawException($drawException);
	} else {
	    $drawing->setBarcode($code);
	    $drawing->draw();
	}
	// Draw (or save) the image into PNG format.
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="/include/style.css" type="text/css">
    <meta http-equiv="content-type" content="text/html;charset=euc-kr">

<link type="text/css" rel="stylesheet" href="/registration_site/script/print_style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="/admin/app/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>
<script type="text/javascript">

/*$(window).load(function(){
	printWindow();
});*/

function printWindow() {
    if (factory.printing == undefined) {
        alert("웹 브라우저 상단의 컨트롤 설치창을 확인하여 주시기 바랍니다.");
        return;
    }
    
    factory.printing.header       = "";
    factory.printing.footer       = "";
    factory.printing.portrait     = true; // true 세로출력 , false 가로출력
    factory.printing.leftMargin   = 0;
    factory.printing.topMargin    = 0;
    factory.printing.rightMargin  = 0;
    factory.printing.bottomMargin = 0;
    
    
    // 대화상자 표시여부 / 출력될 프레임명
     if (factory.printing.Print(true, window ) ){
		self.close();
	}
    //factory.printing.Preview(); // 미리보기 화면 띄우기    
}

function printit() {

	//putSettings();

	var NS = (navigator.appName == "Netscape");
	var VERSION = parseInt(navigator.appVersion);
	if (NS) {
		window.print();
	} else {
		var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
		document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
		WebBrowser1.ExecWB(6, 2); //Use a 1 vs. a 2 for a prompting dialog box WebBrowser1.outerHTML = "";
	}
	alert("인쇄되었습니다.");        
	self.close();
}
</script>
</head>
<object id=factory  classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="/registration_site/script/smsx.cab#Version=6,5,439,50"></object>
<body topmargin="0" leftmargin="0" onload="print();"  style="background-repeat:no-repeat;">

<?
	//VIP Type
	$temp_vip_query = "select * from regist_set_tbl where sid='148'";
	$temp_vip_result = mysqli_query($conn, $temp_vip_query);
	$temp_vip_d = mysqli_fetch_array($temp_vip_result);
	$reg_vip_gubun_type = $temp_vip_d['type'];
	$reg_vip_gubun_orderby = $temp_vip_d['info_orderby'];



	$reg_type_set_query = "SELECT * FROM regist_type_sub_tbl where type_sid = '1048'";
	//echo $reg_type_set_query;
	$reg_type_set_result = mysqli_query($conn, $reg_type_set_query);
	while(is_array($reg_type_set_d = mysqli_fetch_array($reg_type_set_result))){
		$type['annual_year'][$reg_type_set_d['sid']] = $reg_type_set_d['info'];
	}

	$ppp=0;
	$query="SELECT * FROM regist_tbl where del='N'";

	if($code){
		$query .= " and code='".$code."'";
	}
	if($sid){
		$query .= " and sid in (".substr($sid , 0, -1).")";
	}


	if($reg_vip_gubun){

		if($reg_vip_gubun == '-1') {
			$query .= " and ifnull(info".$reg_vip_gubun_orderby.",'')!=''";
		}
		else if($reg_vip_gubun == '-2') {
			$query .= " and ifnull(info".$reg_vip_gubun_orderby.",'')=''";
		}
		else {
			$query .= " and info".$reg_vip_gubun_orderby." = '".$reg_vip_gubun."'";
		}
	}

	$query .= " order by info1 asc";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.225'){
		//echo $query;exit;
	}
	$result = mysqli_query($conn, $query);

	$update_query = "update regist_tbl set print_date='".time()."'";
	$update_query .= "where del='N'";
	if($code){
		$update_query .= " and code='".$code."'";
	}
	if($sid){
		$update_query .= " and sid in (".substr($sid , 0, -1).")";
	}
	mysqli_query($conn, $update_query);

	
	while(is_array($d = mysqli_fetch_array($result))){
	/*
	$barcode = $d['sid']."A";
	$barcode_p_dir = "/barcode/image/";
	
	
	$abyear = "image";
	makeBarcode($barcode,$abyear,false);
	$img = $barcode_p_dir.$barcode.".png";
	*/

	
	
	$office = iconv("UTF-8", "EUC-KR", $d['info3']);
	
	//$office = mb_strimwidth($arr_sosok[$d['office']],0,20,"","euc-kr");
	
	$office_size = "55";
	$office_size2 = "font-size:13px";
	//echo strlen($office)."<br>";
	//echo mb_strlen($office, 'UTF-8')."<br>";
	
	if(strlen($office)>=30){
		$office_size = "22";
	}else if(strlen($office)>=28){
		$office_size = "24";
	}else if(strlen($office)>=26){
		$office_size = "26";
	}else if(strlen($office)>=24){
		$office_size = "28";
	}else if(strlen($office)>=22){
		$office_size = "30";
	}else if(strlen($office)>=20){
		$office_size = "32";
	}else if(strlen($office)>=18){
		$office_size = "34";
	}else if(strlen($office)>=16){
		$office_size = "36";
	}else if(strlen($office)>=14){
		$office_size = "38";
	}
	//$office = htmlspecialchars2($office);

	$name = iconv("UTF-8", "EUC-KR", $d['info1']);

	$name_size = "30";

	if($name){
		if(is_hangul_char($d['info1'])){
			$name_size = 110 / sqrt(mb_strlen($name,"euc-kr"));
			if($name_size<27){
				$name_size = 150 / sqrt(mb_strlen($name,"euc-kr"));
			}
		}else{
			$name_size = 150 / sqrt(mb_strlen($name,"utf-8"));
			if($name_size<25){
				$name_size = 200 / sqrt(mb_strlen($name,"utf-8"));
			}
		}
	}
	/*
	$office_size = "30";
	if($office){
		if(is_hangul_char($office)){
			exit;
			$office_size = 120 / sqrt(mb_strlen($office,"utf-8"));
			if($office_size<27){
				exit;
				$office_size = 140 / sqrt(mb_strlen($office,"utf-8"));
			}
		}else{
			$office_size = 160 / sqrt(mb_strlen($office,"utf-8"));
			if($office_size<25){
				$office_size = 200 / sqrt(mb_strlen($office,"utf-8"));
			}
		}
		
	}*/

?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code128",{barWidth:2, barHeight:50});
});
//]]>
</script>


<div style="position:absolute;top:<?=$ppp?>00%" width="100%" height="100%">
	<div style="position:absolute;left:48px;top:370px;width:400px">
		<div style="font-size:<?=$name_size?>px;font-weight:bold;color:#000000;text-align:center;letter-spacing:15px; margin-left:15px;"><?=$name?>
		</div> 
		<div style="font-size:<?=$office_size?>px;font-weight:bold;position:relative;top:15px;color:#000000;text-align:center;"><?=$office?>
		</div> 
		<div style="position:absolute;font-weight:bold;top:150px;left:100px;">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div> 
	</div>
	
	<div style="position:absolute;left:573px;top:370px;font-size=17px;width:400px">
		<div style="font-size:<?=$name_size?>px;font-weight:bold;color:#000000;text-align:center;letter-spacing:15px; margin-left:15px;"><?=$name?>
		</div>
		<div style="font-size:<?=$office_size?>px;font-weight:bold;position:relative;top:15px;color:#000000;text-align:center;"><?=$office?>
		</div> 
		<div style="position:absolute;font-weight:bold;top:150px;left:100px;">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div> 
	</div>
	
	<?if($d['info6']){
	$temp = split(",",$d['info6']);
	if(count($temp)>1) {
		$annual_p = 37;
	} 
	else {
		$annual_p = 81;
	}

	?>
	<div style="position:absolute;left:0px;top:800px;font-weight:bold;width:400">
		<div style="position:relative;color:#000000;left:105px;font-size=15px;"><?=$name?>&nbsp;</div>
		<div style="position:relative;color:#000000;left:105px;top:13px;font-size=15px;"><?=$office?>&nbsp;</div>
		<div style="position:relative;color:#000000;left:105px;top:26px;font-size=15px;"><?=number_format(50000*count($temp))?><?=iconv("UTF-8", "EUC-KR", '원')?>&nbsp;</div>
		<div style="position:relative;color:#000000;left:<?=$annual_p?>px;top:45px;font-size=15px;">
		<?
			
			for($kk=0;$kk<count($temp);$kk++){
				if($kk>0){
					echo ", ";
				}
				echo substr($type['annual_year'][$temp[$kk]],0,4);
			}
		?>
		</div>
	</div>
	<?}?>

	<div style="position:absolute;left:630px;top:800px;font-weight:bold;width:400">
		<div style="position:relative;color:#000000;font-size=15px;"><?=$name?>&nbsp;</div>
		<div style="position:relative;color:#000000;top:13px;font-size=15px;"><?=$office?>&nbsp;</div>
		<div style="position:relative;color:#000000;top:26px;font-size=15px;"><?=number_format($d['info5'])?><?=iconv("UTF-8", "EUC-KR", '원')?>&nbsp;</div>
	</div>
</div>
	
<?$ppp++;}?>
</body>