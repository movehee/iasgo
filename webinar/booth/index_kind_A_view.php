<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
	$query = "select * from booth where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$category_sql = "select * from booth_grade where del='N' order by sort_num asc";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());

	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		if($e['sort_num']=='1'){
			$default_category = $e['sid'];
		}
		$category_sid[] = $e['sid'];
		$category_title[] = $e['title'];
	}
	$sort_num = $conn->getOne("select sort_num from booth where sid='$sid'");
	$prev_sid = $conn->getOne("select sid from booth where sort_num='".($d['sort_num']-1)."' and del='N' ");
	$next_sid = $conn->getOne("select sid from booth where sort_num='".($d['sort_num']+1)."' and del='N'");

?>
<div class="contents">
	<div class="eboothDetail">

		<ul class="booth">
			<?
				$query = "select * from booth where sort_num>='$sort_num' order by sort_num asc";
				
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());

				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<li>
				<?if($d['linkurl']){?>
					<div class="logo direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt=""></a></div>
					<div class="poster1 direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file1']?>" alt=""></a></div>
					<div class="poster2 direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file3']?>" alt=""></a></div>
					<div class="vod direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file2']?>" alt=""></a></div>
				<?}else{?>
					<div class="logo"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt=""></a></div>
					<div class="poster1"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file1']?>" alt=""></a></div>
					<div class="poster2"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file3']?>" alt=""></a></div>
					<div class="vod"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file2']?>" alt=""></a></div>
				<?}?>
			</li>
			<?}?>
			<?
				$query = "select * from booth where sort_num<'$sort_num' order by sort_num desc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());

				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<li>
				<?if($d['linkurl']){?>
					<div class="logo direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt=""></a></div>
					<div class="poster1 direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file1']?>" alt=""></a></div>
					<div class="poster2 direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file3']?>" alt=""></a></div>
					<div class="vod direct_stamp" key="<?=$d['sid']?>"><a href="<?=$d['linkurl']?>" target="_blank"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file2']?>" alt=""></a></div>
				<?}else{?>
					<div class="logo"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt=""></a></div>
					<div class="poster1"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file1']?>" alt=""></a></div>
					<div class="poster2"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file3']?>" alt=""></a></div>
					<div class="vod"><a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1298'  Hsize='772' Tsize='3%'><img src="<?=$_Azure['link']?>upload/booth/<?=$d['front_file2']?>" alt=""></a></div>
				<?}?>
			</li>
			<?}?>
		</ul>

		<div class="btn">
			<a href="/booth/" class="btnDef btnList">Sponsor List</a>
		</div>
	</div>			
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>