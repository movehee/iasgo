<?php
	include_once "config.php";

	//abstract_set_tbl 적용 완료

	if($view_from == "abstract") {
		
		$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
		$setting_result = mysqli_query($conn, $setting_query);
		$setting_col = mysqli_fetch_array($setting_result);

		$query = "select a.* from abstract_tbl a where a.sid ='".$sid."'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs=$result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$abs_no = $abs['abstract_num']; 
		$abstract_sid = $abs['sid'];
		/*
		$info_query = "select a.sid, a.link_session, a.time, b.language, r.name as room_name, r.photo from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and a.code='".$code."' and a.abs_no='".$abs_no."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);

		$org_info_query = "select g.name from session_tbl a, agenda_tbl g where a.tab=g.sid and a.sid='".$info['link_session']."'";
		$org_info_result = mysqli_query($conn, $org_info_query);
		$org_info = mysqli_fetch_array($org_info_result);
		*/

		


	}
	else if($view_from == "session") {

		$query = "select a.* from abstract_tbl a where a.abstract_num ='".$subcol['abs_no']."'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs=$result->fetchRow(DB_FETCHMODE_ASSOC);
		
		$abs_no = $subcol['abs_no']; 
		$abstract_sid = $abs['sid'];

	}

	$affiliations_arr = explode("|",$abs['author_offices']);
	$affiliation_num = sizeof($affiliations_arr)-1;


	$author_query = "select * from abstract_sub_tbl where msid='$abs[sid]' order by cnt";
	$author_result=$local_conn->query($author_query);
	if(DB::isError($author_result)) die($author_result->getMessage());

	while(is_array($a=$author_result->fetchRow(DB_FETCHMODE_ASSOC))) {

		$author_name = $a['name'];
		
		if($affiliation_num > 1) {
			$sup_no = "";
			$author_no = explode("||",$a['affiliation_sid']);
			foreach($author_no as $aval)
			{
				if($aval) $sup_no .= $aval.",";
			}

			$author_name .= "<sup>".substr($sup_no,0,-1)."</sup>";
		}


		$authors_arr[$a['pa']][] = $author_name;
	}


	$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
	$abs_setting_result = mysqli_query($conn, $abs_setting_query);
	$abs_setting_col = mysqli_fetch_array($abs_setting_result);

?>

	<?if($view_from == "abstract") {?>

	<p class="sessionSub_Brief">	





		<span class="sessionCode2">[<?=$abs_no?>]</span>
	
		<span class="sessionTit"><?=$abs['subject']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$abs['p_fname']?> <?=$abs['p_lname']?></span>
	</p>
	
	
	<!-- <?if($org_info){?>
	
	<ul style="padding:7px 10px;" class="sessionUtil sessionInfo2">
		<?
		if($setting_col['abs_favor']){
			$favor_chk = "select sid from abstract_favor_tbl where code='$code' and deviceid='$deviceid' and abstract_sid='$abstract_sid'";
			$favor_chk_result = mysqli_query($conn, $favor_chk);
		?>
		<li style="padding: 0px 3px 0; margin:0; line-height: 30px;">
			<a href="javascript:abs_favor('<?=$abstract_sid?>','<?=$info['sid']?>','<?=$deviceid?>')" id="favor" class="favorTxt <?if($favor_chk_result->num_rows){?>on<?}?>" title="즐겨찾기 추가하기"><i class="fas fa-star"></i></a>
		</li>
		<?}?>
		
	
		<li style="margin:0; padding:0px 3px 0;  line-height: 30px;">
			<?=$org_info['name']?>
		</li>
		
	
		<li style="margin:0; padding:0px 3px 0;  line-height: 30px;"><i class="far fa-clock" title="Time"></i>  <?=$info['time']?></li>
		<li style="margin:0; padding:0px 3px 0;  line-height: 30px;" class=" "><?if($info['photo']){?></a><a href="/upload/room/<?=$info['photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$info['room_name']?><?if($info['photo']){?></a><?}?></li>
	
	</ul>
	<?}?> -->
	
 


	<?}else if($view_from == "session"){?>
	<!--
	<ul>
		<li><i class="far fa-clock" title="Time"></i>  <?=$info['time']?></li>
		<li class="view2"><a href="/upload/room/1569216757koa2019f1.png"><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$info['room_name']?></a></li>

		<?
		$bullet_eng = $setting_col['bullet_txt_eng']?$setting_col['bullet_txt_eng']:"E";
		$bullet_kor = $setting_col['bullet_txt_kor']?$setting_col['bullet_txt_kor']:"K";
		?>

		<?if($info['language'] =="1"){?>
			<span class=" eng"><?=$bullet_eng?></span>
		<?}else if($info['language'] =="2"){?>
			<span class=" kor"><?=$bullet_kor?></span>
		<?}else if($info['language'] =="3"){?>
			<span class=" eng"><?=$bullet_eng?></span>
			<span class=" kor"><?=$bullet_kor?></span>
		<?}else if($info['language'] =="4"){?>
			<span class=" kor"><?=$bullet_kor?></span>
			<span class=" eng"><?=$bullet_eng?></span>
		<?}?>
	</ul>
	-->
	<?}?>


	<?if($abs_no) {?>

	<div class="abstractCon plus<?=$_COOKIE['abs_font']?>" id="abstractCon">

	

		<dl class="fontUtil">
			<dt><a href="#" class="trigger"><span class="font01">A</span> A</a></dt>
			<dd class="toggleCon">
				<ul>
					<li <?if($_COOKIE['abs_font']=="1"){?>class="on" <?}?> id="font1"><a href="javascript:font_size(1)" class="font01">A</a></li>
					<li <?if($_COOKIE['abs_font']=="2"){?>class="on" <?}?> id="font2"><a href="javascript:font_size(2)" class="font02">A</a></li>
					<li <?if($_COOKIE['abs_font']=="3"){?>class="on" <?}?> id="font3"><a href="javascript:font_size(3)" class="font03">A</a></li>
				</ul>
			</dd>
		</dl>

		<dl class="justify <?if($abs_setting_col['abs_align']=="1"){?>txtAlignJ<?}else{?>txtAlignL<?}?>">
			
			<dt class="absTit">Affiliation</dt>
			<dd>
				<?
				$kk = 1;
				foreach($affiliations_arr as $a_key => $a_val){
					if(!$a_val) continue;

					if($affiliation_num > 1) { echo $kk . '. '; }
					echo $a_val."<br />";
					$kk++;
				}
				?>
			</dd>

			<?if($authors_arr['1']){?>
			<dt class="absTit">Presenting Author</dt>
			<dd>
			<?=implode(" , ", $authors_arr['1'])?>
			</dd>
			<?}?>

			<?if($authors_arr['4']){?>
			<dt class="absTit">Presenting & Corresponding Author</dt>
			<dd>
			<?=implode(" , ", $authors_arr['4'])?>
			</dd>
			<?}?>

			<?if($authors_arr['2']){?>
			<dt class="absTit">Corresponding</dt>
			<dd>
			<?=implode(" , ", $authors_arr['2'])?>
			</dd>
			<?}?>

			<?if($authors_arr['3']){?>
			<dt class="absTit">Co-Author</dt>
			<dd>
			<?=implode(" , ", $authors_arr['3'])?>
			</dd>
			<?}?>
			
			<?if(!empty($abs['subject'])){?>
			<dt class="absTit">Title</dt>
			<dd><?=strip_tags($abs['subject'])?></dd>
			<?}?>
			
			<?if(!empty($abs['body_content'])){?>
			<dt class="absTit">Body</dt>
			<dd><?=strip_tags($abs['body_content'])?></dd>
			<?}?>
			
			<?
				$keyword_arr[] = $abs['keyword1'];
				$keyword_arr[] = $abs['keyword3'];
				$keyword_arr[] = $abs['keyword2'];
			?>
			<?if($keyword_arr){?>
			<dt class="absTit">Keywords</dt>
			<dd><?=implode(" , ", $keyword_arr)?></dd>
			<?}?>
			

			
			

		</dl>

	</div>

	<!-- <?if($abs['figure_file']){?>
	<ul class="sessionUtil">
		
		<li><a href="http://katrdic.org/upload/abstract/<?=$abs['figure_file']?>" class="btnAbs"><i class="fas fa-book"></i> <?=$abs_setting_col['abstract_btn_txt']?></a></li>
		
	</ul>
	<?}?> -->
	<?
	if($abs['figure_file']){
		if(@is_array(getimagesize("http://katrdic.org/upload/abstract/".$abs['figure_file']))) {
		
			if($_SERVER['REMOTE_ADDR']=='218.235.94.227') {
				print_R(getimagesize("http://katrdic.org/upload/abstract/".$abs['figure_file']));
			}
	?>
	<div style="margin: 10px;">
		<ul class="thumbnailwrap">
			<li><a href="http://katrdic.org/upload/abstract/<?=$abs['figure_file']?>"><!-- <span class="thumbTit">타이틀</span> --><img  src="http://katrdic.org/upload/abstract/<?=$abs['figure_file']?>"></a>
			</li>
		</ul>
	</div>
	<?}}?>

	<?}?>