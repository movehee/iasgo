<?
	$query = "select *,if(ifnull(aff_eng,'')!='',aff_eng,aff_kor) as aff from registration_tbl where sid='".$_COOKIE['wmember_sid']."'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<div class="info">
	<table class="tblDef al">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>ID (E-mail)</th>
				<td><a href="mailto:<?=$d['email']?>" class="conLink"><?=$d['email']?></a></td>
			</tr>
			<tr>
				<th>Name</th>
				<td><?=$d['name_kr']?></td>
			</tr>
			<tr>
				<th>Institution/Oranization</th>
				<td><?=$d['aff']?></td>
			</tr>
		</tbody>		
	</table>
</div>