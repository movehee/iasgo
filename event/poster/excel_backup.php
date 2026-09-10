<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=booth_stamp_All.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select * from e_poster where del='N'";
	$query .= " order by sid asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<thead>
		<tr>
			<th>No</th>
			<th>Category</th>
			<th>Category Sub</th>
			<th>Poster No.</th>
			<th>Subject</th>

			<th>Author</th>
			<th>공저자</th>
			<th>소속</th>
			<th>Like</th>
			<th>Favor</th>
			<th>별점</th>
			<th>VIEW</th>
		</tr>
	</thead>
	<?	
		$bnum=1;
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

			$file_cnt = $conn->getOne("select* from e_poster_file where psid='".$d['sid']."'");
			$comment_cnt = $conn->getOne("select count(*) from e_poster_comment where psid='".$d['sid']."'");
			$star_score = $conn->getOne("select sum(score) from e_poster_star_tbl where psid='".$d['sid']."'");
			$vchk = $conn->getOne("select count(*) from e_poster_view_tbl where  psid='".$d['sid']."'");
	?>
	<tr>
		<th><?=$n?></th>
		<td><?=$conn->getOne("select title from e_poster_category where sid='".$d['category']."' and depth='1' and del='N'")?></td>
		<td><?=$conn->getOne("select title from e_poster_category where sid='".$d['category_sub']."' and depth='2' and del='N'")?></td>
		<td><?=$d['poster_number']?></td>
		<td class="al"><?=nl2br($d['subject'])?></td>
		<td><?=stripslashes($d['author'])?></td>
		<td><?=stripslashes($d['co_author'])?></td>
		<td><?=stripslashes($d['position'])?></td>
		<td><?=$conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'")?></td>
		<td><?=$conn->getOne("select count(*) from e_poster_favor where psid='".$d['sid']."'")?></td>
		<td><?=$star_score?></td>
		<td>
		<?if($vchk>0){?><?=$vchk?><?}?>
		</td>
	</tr>
	<?
	$n++;
		}
	?>
</table>