<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/include/include.header.php";

$query = "select * from regist_tbl where ".$name_col."='".$name."' and ".$license_col."='".$license."' and code='".$code."' and del='N'";
$result = $conn->query($query);
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();
?>
<script type="text/javascript" src="/php/mobile/script/jquery.qrcode.js"></script>
<script type="text/javascript" src="/php/mobile/script/qrcode.js"></script>

<script>
$(document).ready(function(){
	
	jQuery(".gcDiv").qrcode({   //qrcode 시작
        render : "canvas",      //table, canvas 형식 두 종류가 있다. 
        width : 90,            //넓이 조절
        height : 90,           //높이 조절
        text   : "<?=$d['sid']."A"?>"     //QR코드에 실릴 문자열
    });
    
	setInterval(function(){
		
		var timer = new Date();
		
		var dd = timer.getDate();
		var mm = timer.getMonth()+1; //January is 0!
		var yyyy = timer.getFullYear();
        var h = timer.getHours();
        var m = timer.getMinutes();
        var s = timer.getSeconds();
        var day_text = timer.getDay();
        
        var week = new Array('일', '월', '화', '수', '목', '금', '토');
        
        if( day_text == "0" ){
        	day_text = "<span style='color:red'>"+week[day_text]+"</span>";
        }else if( day_text == "6" ){
        	day_text = "<span style='color:blue'>"+week[day_text]+"</span>";
        }else{
        	day_text = "<span>"+week[day_text]+"</span>";
        }
        
        
        if(String(mm).length == 1){
			mm = "0" + mm; 
		} 
		if(String(dd).length == 1){ 
			dd = "0" + dd; 
		}
		if(String(m).length == 1){
			m = "0" + m; 
		} 
		if(String(s).length == 1){ 
			s = "0" + s; 
		} 
        
		$(".time_text").html("");
		$(".time_text").html(yyyy+"년 "+mm+"월 "+dd+"일 ( "+day_text+" ) <div>현재시간 : "+h+"시 "+m+"분 "+s+"초</div>");
	}, 1000);
	
});
</script>		
		<div class="contents">
			
			<div class="barcodeZone">
				<div>
					<!-- <div class="barcode" onclick="$('div.layerPopup').show();$('body').addClass('overHidden');"></div> -->
					<div class="gcDiv ac lm5" onclick="$('div.layerPopup').show();$('body').addClass('overHidden');"></div>
					<div>
						<div id="time_text" class="time_text"><?=date("Y년 m월 d일")?><br><?=date("H시 i분 s초")?></div>
						<? if( $d['check_in1'] ){ ?>
						<div class="ac fwBold fcRed" style="font-size:17px">입장시간 : <?=date("H시 i분 s초",$d['check_in1'])?> </div>
						<? } ?>
					</div>
					<div class="ac tm10 fwBold"><?=$d['info1']?> / <?=$d['info4']?></div>
				</div>
				
				<div class="note">
					강의장 입구에 있는 바코드 스캐너에 해당 바코드를 찍어 주시면 출결이 확인됩니다.
					<span class="fcRed">입-퇴 실 모두 찍어 주셔야 평점이 인정됩니다.</span>
					<span class="fcPoint">* 캡처 화면은 사용할 수 없습니다.</span>
				</div>
			</div>

			<div class="layerPopup" id="popupBarcode">
				<div>
					<!-- <div class="barcode"></div> -->
					<div class="gcDiv ac lm5"></div>
					<div>
						<div id="time_text" class="time_text">2019년 06월 27일<br /> 16시 17분 09초</div>
						<? if( $d['check_in1'] ){ ?>
						<div class="ac fwBold fcRed" style="font-size:17px">입장시간 : <?=date("H시 i분 s초",$d['check_in1'])?> </div>
						<? } ?>
					</div>
					<div class="ac tm10 fwBold"><?=$d['info1']?> / <?=$d['info4']?></div>
				</div>
				<p class="close"><a href="#">팝업닫기</a></p>
			</div>
			

<!-- 
	
			
			<div class="ac" style="width:88%; margin:0 auto; margin-top:100px;">
				<div class="barcode"></div>
				<div class="tm30 fcBlue fwBold">
					<span id="time_text"><?=date("Y년 m월 d일 H시 i분 s초")?></span>
				</div>	
			</div>	
 -->

    	</div>
    </div> <!-- //container -->

<? include $_SERVER['DOCUMENT_ROOT']."/php/mobile/include/include.footer.php"; ?>