<?php
	include_once "config.php";

	//abstract_set_tbl 적용 완료

	if($view_from == "abstract") {

		$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
		$setting_result = mysqli_query($conn, $setting_query);
		$setting_col = mysqli_fetch_array($setting_result);

		/*연동*/
		$query =  "
		select * from (
			select 'A' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category from korl_abstract_tbl_type_i a, section_info b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25'
			union
			select 'B' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category from korl_abstract_tbl_type_i_sub a, section_info2 b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25' 
		) a where receipt_num='".$receipt_num."' and pt_order_info='".$pt_order_info."'
		";

		//echo $query;
		$abs_result = mysqli_query($local_conn, $query);
		$abs = mysqli_fetch_assoc($abs_result);
		/*연동*/

		$abs_no = $abs['receipt_num'];
		$abstract_sid = $abs['sid'].$abs['type'];

		$info_query = "select a.link_session, a.time, b.language, r.name as room_name, r.photo from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and a.code='".$code."' and a.abs_no='".$abs_no."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);

		$org_info_query = "select g.name from session_tbl a, agenda_tbl g where a.tab=g.sid and a.sid='".$info['link_session']."'";
		$org_info_result = mysqli_query($conn, $org_info_query);
		$org_info = mysqli_fetch_array($org_info_result);

	}
	else if($view_from == "session") {
		
		/*연동*/
		$query =  "
		select * from (
			select 'A' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category from korl_abstract_tbl_type_i a, section_info b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25'
			union
			select 'B' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category from korl_abstract_tbl_type_i_sub a, section_info2 b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25' 
		) a where receipt_num='".$subcol['abs_no']."' and pt_order_info='".$subcol['abs_sid']."'

		";
		/*연동*/
		//echo $query;
		$abs_result = mysqli_query($local_conn, $query);
		$abs = mysqli_fetch_assoc($abs_result);

		$abstract_sid = $abs['sid'].$abs['type'];
		$abs_no = $abs['receipt_num'];

	}


	$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
	$abs_setting_result = mysqli_query($conn, $abs_setting_query);
	$abs_setting_col = mysqli_fetch_array($abs_setting_result);

?>

	<?if($view_from == "abstract") {?>

	<p class="sessionSub_Brief">	
		<?if($abs['type']=='A'){?>
		<span class="sessionCode2"><?=$abs['pt_order_info']?> </span>
		<?}?>
	
		<span class="sessionTit"><?=$abs['subject']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$pname?></span>
	</p>

	<!--
	<ul class="sessionUtil sessionInfo2">
		
		<?
		if($setting_col['abs_favor']){
			$favor_chk = "select sid from abstract_favor_tbl where code='$code' and deviceid='$deviceid' and abstract_sid='$abstract_sid'";
			$favor_chk_result = mysqli_query($conn, $favor_chk);
		?>
		<li>
			<a href="javascript:abs_favor('<?=$abstract_sid?>','<?=$deviceid?>')" id="favor" class="favorTxt <?if($favor_chk_result->num_rows){?>on<?}?>" title="즐겨찾기 추가하기"><i class="fas fa-star"></i></a>
		</li>
		<?}?>
		
	<?if($org_info){?>
		<li>
			<?=$org_info['name']?>
		</li>
		

		<li><i class="far fa-clock" title="Time"></i>  <?=$info['time']?></li>
		<li class=""><?if($info['photo']){?></a><a href="/upload/room/<?=$info['photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$info['room_name']?><?if($info['photo']){?></a><?}?></li>

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
	<?}?>
	</ul>
	-->



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
	
		<?if($abs['type'] == 'A'){?>

			<dt class="absTit">Affiliation</dt>
			<dd><?=$abs['position']?></dd>

			<dt class="absTit">Authors</dt>
			<dd><?=$abs['author']?></dd>

			<dt class="absTit">Presenter</dt>
			<dd><?=$abs['announcer']?></dd>

			<dt class="absTit">Corresponding Author</dt>
			<dd><?=$abs['exchange_author']?></dd>

	
			<?if($abs['gubun'] == '1'){ //윈저 ?>
				<?if(!empty($abs['purpose'])){?>
				<dt class="absTit">Purpose</dt>
				<dd><?=strip_tags($abs['purpose'])?></dd>
				<?}?>

				<?if(!empty($abs['method'])){?>
				<dt class="absTit">Method</dt>
				<dd><?=strip_tags($abs['method'])?></dd>
				<?}?>

				<?if(!empty($abs['effect'])){?>
				<dt class="absTit">Result</dt>
				<dd><?=strip_tags($abs['effect'])?></dd>
				<?}?>

				<?if(!empty($abs['conclusion'])){?>
				<dt class="absTit">Conclusion</dt>
				<dd><?=strip_tags($abs['conclusion'])?></dd>
				<?}?>

				

			<?}else if($abs['gubun'] == '2'){ //증례보고 ?>

				<?if(!empty($abs['effect'])){?>
				<dt class="absTit">Contents</dt>
				<dd><?=strip_tags($abs['effect'])?></dd>
				<?}?>		

			<?}?>
			
		<?}else if($abs['type'] == 'B'){?>

			<dt class="absTit">Affiliation</dt>
			<dd><?=$abs['position']?></dd>

			<dt class="absTit">Authors</dt>
			<dd><?=$abs['author']?></dd>

			<?if(!empty($abs['effect'])){?>
			<dt class="absTit">Contents</dt>
			<dd><?=strip_tags($abs['effect'])?></dd>
			<?}?>	
		<?}?>
			
			

			
			

		</dl>

	</div>

	<?}?>