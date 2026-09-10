<?
	$My_poster = $conn->getOne("select count(sid) from e_poster where presenter_email='".$_COOKIE['wmember_email']."'");

	
?>
<?if($My_poster>0){?>
<div class="myfavo">
	<dl>
		<dt>E-poster Q&A List - 발표자</dt>
		<dd class="scrollArea">
			<ul class="eposterList">
				<?
				$query = "select * from e_poster where presenter_email='".$_COOKIE['wmember_email']."'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					unset($aff_info);
					if($d['presenter_aff']) $aff_info[] = stripslashes($d['presenter_aff']);
					if($d['country'])  $aff_info[] = ($d['country']);
					
					$poster_file = $conn->getOne("select filename from e_poster_file where psid='".$d['sid']."' order by sort_num asc limit 0,1");
					//$on_check = $conn->getOne("select count(*) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
					//$my_like = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
					//$total_like = $conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'");

					$view_chk = $conn->getOne("select count(*) from e_poster_view_tbl where psid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
					$comment_cnt = $conn->getOne("select count(*) from comment_tbl where number='s_".$d['sid']."'");
				?>
				<li>
					<a href="/load/etc/poster_comment.php?sid=<?=$d['sid']?>" class="Load_Base" Wsize='1303'  Hsize='680' Tsize='2%'>
						<span class="num"><?=$d['poster_number']?></span>
						<span class="thumb"></span>
						<span class="tit"><?=stripslashes($d['subject'])?></span>
						<span class="writer"><?=stripslashes($d['presenter'])?> <?if(count($aff_info)>0){?>(<?=implode(", ",$aff_info)?>)<?}?></span>
					</a>
					<a href="/load/etc/poster_comment.php?sid=<?=$d['sid']?>" Wsize='1303'  Hsize='680' Tsize='2%' class="comment Load_Base">Comment (<?=$comment_cnt?>)</a>
					<!-- <a href="#" class="favor on">즐겨찾기 설정</a> -->
				</li>
				<?}?>
			</ul>
		</dd>
	</dl>
</div>
<?}?>

<div class="myfavo">
	<dl>
		<dt>E-poster Q&A List - 사용자</dt>
		<dd class="scrollArea">
			<ul class="eposterList">
				<?
				$query = "select t2.sid,t2.category,t2.category_sub,t2.poster_number,t2.subject,t2.presenter,t2.presenter_aff,t2.email,t1.content,t1.name,t1.number ";
				$query .= "from comment_tbl as t1 inner join e_poster as t2 on replace(t1.number,'s_','')=t2.sid where t1.id='".$_COOKIE['wmember_sid']."' and t2.del='N' group by t2.sid";

				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					unset($aff_info);
					if($d['presenter_aff']) $aff_info[] = stripslashes($d['presenter_aff']);
					if($d['country'])  $aff_info[] = ($d['country']);
					
					$poster_file = $conn->getOne("select filename from e_poster_file where psid='".$d['sid']."' order by sort_num asc limit 0,1");
					//$on_check = $conn->getOne("select count(*) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
					//$my_like = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
					//$total_like = $conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'");

					$view_chk = $conn->getOne("select count(*) from e_poster_view_tbl where psid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
					$comment_cnt = $conn->getOne("select count(*) from comment_tbl where number='s_".$d['sid']."'");
				?>
				<li>
					<a href="/load/etc/poster_comment.php?sid=<?=$d['sid']?>" class="Load_Base" Wsize='1303'  Hsize='680' Tsize='2%'>
						<span class="num"><?=$d['poster_number']?></span>
						<span class="thumb"></span>
						<span class="tit"><?=stripslashes($d['subject'])?></span>
						<span class="writer"><?=stripslashes($d['presenter'])?> <?if(count($aff_info)>0){?>(<?=implode(", ",$aff_info)?>)<?}?></span>
					</a>
					<a href="/load/etc/poster_comment.php?sid=<?=$d['sid']?>" Wsize='1303'  Hsize='680' Tsize='2%' class="comment Load_Base">Comment (<?=$comment_cnt?>)</a>
					<!-- <a href="#" class="favor on">즐겨찾기 설정</a> -->
					
				</li>
				<?}?>
			</ul>
		</dd>
	</dl>
</div>