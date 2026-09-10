<?
include "./../../header2.php";

if(!$pre_regist){
	$pre_regist = "1";
}

$event_result = mysqli_query($conn, "SELECT * FROM event_tbl where code='".$code."' ");
$event = mysqli_fetch_array($event_result);

$query="SELECT * FROM regist_tbl where code='".$code."' and pre_regist='".$pre_regist."' and del='N'";
$result = mysqli_query($conn, $query);

$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");

$reg_set_query="SELECT * FROM regist_set_tbl where code='".$code."' and listchk='Y' and del='N' order by orderby asc";
$reg_set_result = mysqli_query($conn, $reg_set_query);

$query="SELECT * FROM session_set_tbl where code='".$code."' ";
$setting_result = mysqli_query($conn, $query);
$setting_d = mysqli_fetch_array($setting_result);

if($event['sms_content']) {
	$sms_content = $event['sms_content'];
} else {
	$sms_content = $event['name']." 강의 안내
-교육일시 : ".date("Y-m-d",$event['eventdate'])."

-강의출결 확인을 위해 발송된[입출결 바코드]를 준비하여 주시기 바랍니다.

[입출결바코드]
http://ezv.kr/php/mobile/index.php?code=".$code;
}

?>

<script>
$(document).ready(function(){
	
	$("#all_chk").click(function(){
		
		var index = $(this).is(":checked");
		
		if( index ){
			$("input:checkbox[name='chk_sid[]']").prop("checked",true);
		}else{
			$("input:checkbox[name='chk_sid[]']").prop("checked",false);
		}
		
	});

	$("select.txt_style_set").on("change", function() {
		var pre_val = $("#"+$(this).attr("s-target")).val();
		$("#"+$(this).attr("s-target")).val(pre_val + $(this).val())
	});
	
	
});

function sms_send(){
	if( $("input:checkbox[name='chk_sid[]']").is(":checked") == false ){
		alert("전송 대상이 선택 되어 있지 않습니다.");
		return false;
	}else{
		$("#sms_form").attr("target", "");
		$("#sms_form").attr("action", "send.php");
		$("#sms_form").submit();
	}
}

function sms_preview() {
	if( $("input:checkbox[name='chk_sid[]']").is(":checked") == false ){
		alert("전송 대상이 선택 되어 있지 않습니다.");
		return false;
	}else{
		
		window.open("", "popup_window", "width=1200, height=600, scrollbars=no");
		
		$("#sms_form").attr("target", "popup_window");
		$("#sms_form").attr("action", "view.php");
		$("#sms_form").submit();
	}
}

function reg_content() {
	$("#reg_type").val("content");
	$("#sms_form").attr("target", "");
	$("#sms_form").attr("action", "send.php");
	$("#sms_form").submit();
}
</script>

<div id="container" style="width:1000px;">
	<h2 class="tooltipPoint">SMS 관리</h2>
	
	<div class="btnArea" style="width:100%;">
		<span class="btn" style="float:right; margin-right:10px;">
			<a onclick="sms_preview();"class="btnOrg tooltipPoint"><i class="fas fa-eye"></i>미리보기</a>
			<a onclick="sms_send();"class="btnOrg tooltipPoint"><i class="fas fa-cog"></i>선택전송</a>
			

			<a href="/admin/php/regist/sms/index.php?code=<?=$code?>&pre_regist=1" class="<? if( $pre_regist == "1" ){ ?>btnDef<? }else{ ?>btnPoint<? } ?> tooltipPoint"><i class="fas fa-cog"></i>사전등록</a>
			<a href="/admin/php/regist/sms/index.php?code=<?=$code?>&pre_regist=2" class="<? if( $pre_regist == "2" ){ ?>btnDef<? }else{ ?>btnPoint<? } ?> tooltipPoint"><i class="fas fa-cog"></i>현장등록</a>
		</span>
	</div>
	
	<div class="contents">
		
		<div>
		<select class="txt_style_set" s-target="msg" style=" font-size:13px; width: 140px;  height: 40px; ">
			<option value="">치환문자</option>

			<option value="{reg_sid}">sid</option>

			<?if($setting_d['reg_name_en']){?>
			<option value="{reg_name_en}">이름(영문)</option>
			<?}?>

			<?if($setting_d['reg_office']){?>
			<option value="{reg_office}">소속(국문)</option>
			<?}?>

			<?if($setting_d['reg_license']){?>
			<option value="{reg_license}">면허번호</option>
			<?}?>

		</select>

		<span class="btn">
		<a onclick="reg_content()" class="btnOrg">내용저장</a>
		</span>
		</div>

		<form method="post" action="./send.php" id="sms_form">
		<input type="hidden" name="reg_type" id="reg_type" />
		<input type="hidden" name="code" value="<?=$code?>"/>
		<textarea class="bm20" name="msg" id="msg"><?=$sms_content?></textarea>	
		<table class="tblList">
			<thead>
				<tr>
					<th width="4%"><input type="checkbox" name="all_chk" id="all_chk"/></th>
					<? while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){ ?>

					<?if($reg_set_d['type']>1000){
						$reg_type_set_query = "SELECT * FROM regist_type_sub_tbl where type_sid in (".$reg_set_d['type'].")";
						$reg_type_set_result = mysqli_query($conn, $reg_type_set_query);
						while(is_array($reg_type_set_d = mysqli_fetch_array($reg_type_set_result))){
							$type[$reg_set_d['type']][$reg_type_set_d['sid']] = $reg_type_set_d['info'];
						}
					}?>
					<th style="min-width:100px;max-width:500px"><?=$reg_set_d['info']?></th>
					<?}mysqli_data_seek($reg_set_result,0);?>
				</tr>
			</thead>
			<tbody>
			<?while(is_array($d = mysqli_fetch_array($result))){?>
				<tr class="bg" id="<?=$d['sid']?>">
					<td width="2%"><input type='checkbox' name='chk_sid[]' value="<?=$d['sid']?>"/></td>
					<?while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){?>
					<?if($reg_set_d['type']>1000){?>
					<td style="min-width:10%;max-width:40%">
					<?
					$temp = split(",",$d['info'.$reg_set_d['info_orderby']]);
					if(count($temp)=="1" && $setting_col['reg_money_gubun']==$reg_set_d['sid']){?>
						<select onchange="changeVal(this,'info<?=$reg_set_d['info_orderby']?>','<?=$d['sid']?>')" name="info<?=$reg_set_d['info_orderby']?>" id="info<?=$reg_set_d['info_orderby']?>">
							<option value="">select</option>
						<?
							$temp_query2 = "select * from regist_set_tbl a, regist_type_sub_tbl b where a.type=b.type_sid and a.type='".$reg_set_d['type']."' and a.del='N' and b.del='N'";
							$temp_result2 = mysqli_query($conn, $temp_query2);
							while(is_array($temp_d2 = mysqli_fetch_array($temp_result2))){?>
							<option<?=$d['info'.$reg_set_d['info_orderby']]==$temp_d2['sid']?' selected="true"':''?> value="<?=$temp_d2['sid']?>"><?=$temp_d2['info']?></option>
							<?}
						?>
										
						</select>
						<?}else{

							for($kk=0;$kk<count($temp);$kk++){
								if($kk>0){
									echo ", ";
								}
								echo $type[$reg_set_d['type']][$temp[$kk]];
							}
						}
						?>
								
								
					</td>
					<?}else if($reg_set_d['type']==90){
						if($d['info'.$reg_set_d['info_orderby']]){
						$country_result = mysqli_query($conn, "select * from country_tbl where sid=".$d['info'.$reg_set_d['info_orderby']]);
						$country_d = mysqli_fetch_array($country_result);
						}
					?>
					<td style="min-width:10%;max-width:40%"><?=$country_d['name']?></td>
					<?}else{?>
					<td <?if($reg_set_d['type']==100){?>class="tdMemo"<?}?> style="min-width:10%;max-width:40%"><?=$d['info'.$reg_set_d['info_orderby']]?></td>
					<?}?>
					<?}mysqli_data_seek($reg_set_result,0);?>
					</tr>
					<? } ?>
				</tbody>
			</table>
		</form>			
	</div>
</div>	

<?include "./../../footer.php";?>