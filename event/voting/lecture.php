<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
?>
<script type="text/javascript" src="/webinar/script/drag/js/jquery.tablednd.js"></script>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}
</style>
<?
	if(!$code){
		$code = $conn->getOne("select code from event_tbl where del='N' order by code asc limit 0,1");
	}
	
	if(!$code){
		PutMessageLocation("설정부터 완료해주세요","/voting/");
	}
	$query = "select * from event_tbl where del='N' order by code asc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div class="btn" style="float:left;">
	<?while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){?>	
	<a href="<?=$PHP_SELF?>?code=<?=$d['code']?>" <?if($d['code']==$code){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일",$d['eventdate'])?></a></li>
	<?}?>
	
</div>
<div class="btn" style="float:right;">
	<a href="javascript:popup_call('voting/lecture','code=<?=$code?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>연자등록</a>
</div>
<div style="clear:both;padding-bottom:5px;"></div>

<table class="tblDef ">
		<colgroup>
			<col style="width: 5%;" />
			<col style="width: 10%;" />
			<col style="width: 42%;" />
			<col style="" />
			<col style="width: 10%;" />
			<col style="width: 5%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Room</th>
				<th>연자정보</th>
				<th>보팅갯수</th>
				<th>보팅관리</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
		<?
			$query = "select * from lecture_tbl where code='$code' and del='N' order by sid asc";
			$query .= $sort_sql;
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				$Vcnt = $conn->getOne("select count(*) from voting_tbl where code='$code' and del='N' and lecture='".$d['sid']."'");
		?>
		<tr>
			<th><?=$n?></th>
			<td><?=$d['room']?></td>
			<td><?=$d['name']?></td>
			<td><?=$Vcnt?>개</td>
			<td><span class="btnAdmin small navy"><button type="button" onclick="location.href='voting_question.php?sid=<?=$d['sid']?>&room=<?=$d['room']?>&code=<?=$code?>'">Voting 등록</button></span></td>
			<td>
				<img src="/image/icon/icon_modify.png" onclick="popup_call('voting/lecture','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','voting_lecture')">
			</td>
		</tr>
		<?$n++;}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>