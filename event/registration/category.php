<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
	$_SETTING['Reg_Field'] = array(
		"country"=>"국가",
		"reg_kind"=>"구분",
		"id"=>"아이디",
		"name_kr"=>"성명",
		"passwd"=>"비밀번호",
		"login_day1"=>"행사1일",
		"login_day2"=>"행사2일",
		"login_day3"=>"행사3일",
		"login_day4"=>"행사4일",
		"aff_kor"=>"소속",
		"email"=>"이메일",
		"cell"=>"연락처",
		"councilor"=>"평의원",
		"reg_kind"=>"구분",
		"reg_kind"=>"구분",
		"reg_kind"=>"구분",
		"reg_kind"=>"구분",
		"reg_kind"=>"구분",
		"reg_kind"=>"구분"
	);
?>
<div class="contents" style="width:30%;">
	<table class="tblDef">
		<colgroup>
			<col style="width:40px;" />
			<col style="width:" />
			<col style="width: 13%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>항목</th>
				<th>사용</th>
			</tr>
		</thead>
		<tbody>
			<?$n=1;foreach($_SETTING['Reg_Field'] as $tkey=>$tval){?>
			<tr>
				<td><?=$n?></td>
				<td><?=$tval?></td>
				<td><?=$d['gubun2']?></td>
			</tr>
			<?$n++;}?>
		</tbody>
	</table>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 