<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,950);
	});
</script>
<div class="popupCon" id="" style="width:1200px;padding:20px;background:#ffffff;">
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 7%;">
			<col style="width: ;">
			<col style="width: 15%;">
			<col style="width: 25%;">
			<col style="width: 12%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Day</th>
				<th>Channel</th>
				<th>입장 세션시간</th>
				<th>입장 세션</th>
				<th>퇴장 세션시간</th>
				<th>퇴장 세션</th>
				<th>Check In</th>
				<th>Check Out</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
				$query = "select t1.* from checkin_detail_tbl_history as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.usid='$sid'";
				echo $query;
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				$n=1;
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$n?></td>
				<td class="ac" >
				<?
				echo $d['day'];
				?>
				</td>
				<td class="ac" >Room <?=$d['room']?></td>
				<td class="ac" >
				<?
					if($d['session_time']){
						$ex_time = explode("~",$d['session_time']);
						echo substr($ex_time[0],10,6) . " ~ ";
						echo substr($ex_time[1],10,6);
					}
				?>
				</td>
				<td class="ac">
				<?
					if($d['session_title']){
						echo $d['session_title'];
					}else{
						echo "Break";
					}
				?>
				</td>
				<td>
				<?
					if($d['session_time_out']){
						$ex_time_out = explode("~",$d['session_time_out']);
						echo substr($ex_time_out[0],10,6) . " ~ ";
						echo substr($ex_time_out[1],10,6);
					}
				?>
				</td>
				<td class="ac"><?=$d['session_title_out']?></td>
				<td class="ac" ><?if($d['check_in']>0){?><?=date("H:i",$d['check_in'])?><?}?></td>
				<td class="ac" ><?if($d['check_out']>0){?><?=date("H:i",$d['check_out'])?><?}?></td>
				
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
