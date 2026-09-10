<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	if($kind=="add"){

		$query = "insert into e_poster_favor set usid='".$_COOKIE['wmember_sid']."', psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="del"){
		
		$query = "delete from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	
	}
	if($mode=='list'){
		exit;
	}
	//$favor_cnt = $conn->getOne("select count(*) from e_poster_favor as t1 inner join e_poster as t2 on t1.psid=t2.sid where t1.usid='".$_COOKIE['wmember_sid']."'");
?>
<dd class="scrollArea">
	<ul>
		<?
			
			$query = "select * from e_poster_favor as t1 inner join e_poster as t2 on t1.psid=t2.sid where t1.usid='".$_COOKIE['wmember_sid']."'";
			if($video=='Y'){
				$query .= " and t2.category='2'";
			}else{
				$query .= " and t2.category!='2'";
			}
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$fir_img = $conn->getOne("select filename from e_poster_file where psid='".$d['sid']."' order by sort_num asc limit 0,1");
		?>
		<li>
			<a href="view.php?sid=<?=$d['sid']?>&category=<?=$d['category']?>&category_sub=<?=$d['category_sub']?>" class="brief">
				<span class="thumb">
					<?if($fir_img){?>
					<img src="<?=$_Azure['link']?>upload/e_poster/thumb/<?=$fir_img?>" width=108 alt="">
					<?}?>
				</span>
				<span class="code"><?=$d['poster_number']?></span>
				<?=$d['subject']?>
			</a>
			<a href="javascript:favor_chk(<?=$d['sid']?>,'del')" class="favor on">즐겨찾기 설정</a>
		</li>
		<?}?>
	</ul>
</dd>