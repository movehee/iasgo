<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Stamp Event");
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,950);
	});
</script>
<style>
div.selectFile {overflow:hidden;padding-right:10px;padding-left:10px;}
div.selectFile p {float:left;}
div.selectFile p input[type=text] {height: 23px;padding:2px 10px 3px;}
div.selectFile p.withIcon {position: relative;width:66px;height:30px;background-color:#393939;color: #fff;text-align: center;}
div.selectFile p.withIcon i {position: absolute;left: 50%;top: 50%;font-size: 1em;margin: -0.5em 0 0 -0.5em;color:#ffffff;}
div.selectFile p.withIcon input {position: absolute;left: 0;top: 0;width:100%;height:100%;padding: 0;border: 0 none;}
#product {
	counter-reset: rowNumber;
}
.numberic:after {
	counter-increment: rowNumber;
	content: counter(rowNumber);
}

</style>

<script>
function add_conference(sid,kind){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });
	$.get( "/popup/booth/add.php?kind="+kind+"&sid="+sid, function( data ) {
		$("#product").append( data );
	});
	
}

</script>
<?
	$query = "select * from booth where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$booth_query = "select * from booth_grade where sid='$d[booth_sid]'";
	$booth_result = $conn->query($booth_query);
	if(DB::isError($booth_result)) {
	  die($booth_result->getMessage());
	}
	$booth_result->fetchInto(&$booth,DB_FETCHMODE_ASSOC);
	$booth_result->free();

	
	if($booth['b_type']=='A'){

		$filename_arr = array("booth_file","booth_ground_file","logo_file","front_file1","front_file2","front_file3","front_file4");
		$img_sample_arr = array("booth_sample.png","booth_ground.png","logo_sample.png","poster_left_sample.png","vod_sample.png","poster_right_sample.png","banner_sample.png");

	}else if($booth['b_type']=='B'){
		$filename_arr = array("booth_file");
		$img_sample_arr = array("booth_sample2.png");	
	}else if($booth['b_type']=='C'){
		$filename_arr = array("booth_file");
		$img_sample_arr = array("booth_sample4.png");
	}
	

	$booth_title = "[".$booth['title']."] ".$d['title']." - " .$_Booth['type'][$booth['b_type']];

	
?>
<script>
	$(function(){
		$('#load_text').html("<?=$booth_title?>");
	});
</script>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#ffffff;">
	<div class="ar bp5">
		<span class="rBtnAdmin medium green"><button type="button" onclick="location.href='stamp_excel.php?sid=<?=$sid?>'">Excel</button></span>
	</div>
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: ;">
			<col style="width: 25%;">
			<col style="width: 15%;">
			<col style="width: 20%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>아이디</th>
				<th>이름</th>
				<th>면허번호</th>
				<th>참여일</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
				$query = "select t1.*,t2.id,t2.name_kr,t2.name_eng,t2.license_number,t2.email from booth_stamp as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$sid' and t2.member_level!='M' order by t1.signdate desc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$n?></td>
				<td class="ac" ><?=$d['id']?></td>
				<td class="ac" ><?=$d['name_eng']?></td>
				<td class="ac" ><?=$d['license_number']?></td>
				<td class="ac" ><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
			</tr>
			<?$n++;}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
