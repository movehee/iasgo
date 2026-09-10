<?
	$faculty_chk = $conn->getOne("select count(*) from faculty_tbl where ifnull(faculty_none,'')='' and usid='".$_COOKIE['wmember_sid']."'");
?>
<?if($faculty_chk>0){?>
<h3 class="subTit">Session Q&A (Faculty)</h3>
<table class="tblDef">
	<colgroup>
		<col style="width: *%;">
		<col style="width: 12%;">
		<col style="width: 12%;">
		<col style="width: 20%;">
		<col style="width: 12%;">
	</colgroup>
	<thead>
		<tr>
			<th>Question</th>
			<th>Name(Affiliation)</th>
			<th>Phone</th>
			<th>E-mail</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?
			$query = "select t1.*,t3.id from question_tbl as t1 inner join faculty_tbl as t2 on t1.fsid=t2.sid inner join registration_tbl as t3 on t2.usid=t3.sid ";
			$query .= " where t3.sid='".$_COOKIE['wmember_sid']."' order by t1.signdate desc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><a href="/load/mypage/session_qna.php?sid=<?=$d['sid']?>" class="qnaTit Load_Base" Wsize='1203'  Hsize='785' Tsize='5%'><?=$d['question']?></a></td>
			<td><?=$d['name']?><?if($d['office']){?>(<?=$d['office']?>)<?}?></td>
			<td><?=$d['cell']?></td>
			<td><?=$d['email']?></td>
			<td><?=date("Y.m.d H:i",$d['signdate'])?></td>
		</tr>
		<?}?>
	</tbody>
</table>
<?}?>

<h3 class="subTit">Session Q&A (일반)</h3>
<table class="tblDef">
	<colgroup>	
		<col style="width: 7%;">
		<col style="width: 20%;">
		<col style="width: 17%;">
		<col style="width: *%;">
		<col style="width: 10%;">
	</colgroup>
	<thead>
		<tr>
			<th>Picture</th>
			<th>Name</th>
			<th>E-mail</th>
			<th>Question</th>
			
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?
			$query = "select t1.question,t1.signdate,t1.answer,t2.* from question_tbl as t1 inner join faculty_tbl as t2 on t1.fsid=t2.sid ";
			$query .= " where t1.usid='".$_COOKIE['wmember_sid']."' and t1.del='N' order by t1.sid desc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				if($d['faculty_photo']){
					$photo_src = $_CONFIG['Admin_link']."upload/faculty/".$d['faculty_photo'];
				}else{
					$photo_src = "/asset/layout/session_thumb.png";
				}
		?>
		<tr>
			<td><img src="<?=$photo_src?>" style="width:70px;"></td>
			
			<td><?=$d['faculty_name']?><?if($d['faculty_aff']){?><br />(<?=$d['faculty_aff']?>)<?}?></td>
			<td><?=$d['faculty_email']?></td>
			<td class="al">
				<?=$d['question']?>
				<?if($d['answer']){?>
					<div style="border:1px solid #006FA9;background:#EEF9FF">
						<table>
							<tr>
								<td valign="top" style="width:40px;text-align:center;padding-top:5px;font-size:22px;"><i class="fa fa-rss" ></i></td>
								<td valign="top"><?=$d['answer']?></td>
							</tr>
						</table>
						
					</div>
				<?}?>
			</td>
			<td><?=date("m.d H:i",$d['signdate'])?></td>
		</tr>
		<?}?>
	</tbody>
</table>