<?php
	include_once "config.php";

	//abstract_set_tbl 적용 완료

	if($view_from == "abstract") {

		$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
		$setting_result = mysqli_query($conn, $setting_query);
		$setting_col = mysqli_fetch_array($setting_result);

		/*연동*/
		$query = "SELECT a.*,u.first_name,u.last_name,u.kor_name FROM abstract_tbl a LEFT JOIN user_binfo u ON a.user_sid=u.sid WHERE a.sid IS NOT NULL and a.sid='$sid'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs = $result->fetchRow(DB_FETCHMODE_ASSOC);
		/*연동*/

		$abs_no = $abs['abs_no'];
		$abstract_sid = $abs['sid'];

		$info_query = "select a.sid, a.link_session, a.time, b.language, r.name as room_name, r.photo from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and a.code='".$code."' and a.abs_no='".$abs_no."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);

		$org_info_query = "select g.name from session_tbl a, agenda_tbl g where a.tab=g.sid and a.sid='".$info['link_session']."'";
		$org_info_result = mysqli_query($conn, $org_info_query);
		$org_info = mysqli_fetch_array($org_info_result);

	}
	else if($view_from == "session") {

		$info_query = "select a.time, a.abs_no, b.language, r.name as room_name, r.photo from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and a.code='".$code."' and a.sid='".$sid."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);
		
		$abs_no = $info['abs_no'];

		$query = "SELECT a.*,u.first_name,u.last_name,u.kor_name FROM abstract_tbl a LEFT JOIN user_binfo u ON a.user_sid=u.sid WHERE a.sid IS NOT NULL and a.abs_no='".$abs_no."'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs=$result->fetchRow(DB_FETCHMODE_ASSOC);

		$abstract_sid = $abs['sid'];

	}


	$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
	$abs_setting_result = mysqli_query($conn, $abs_setting_query);
	$abs_setting_col = mysqli_fetch_array($abs_setting_result);

?>

	<?if($view_from == "abstract") {?>

	<p class="sessionSub_Brief">	


	<?
		$bullet_eng = $setting_col['bullet_txt_eng']?$setting_col['bullet_txt_eng']:"E";
		$bullet_kor = $setting_col['bullet_txt_kor']?$setting_col['bullet_txt_kor']:"K";
		?>

		<?if($info['language'] =="1"){?>
			<span style="display: inline-block; position: relative; color: #fff;   padding: 1px 5px;  background-color: #0748bf;" class="eng"><?=$bullet_eng?></span>
		<?}else if($info['language'] =="2"){?> 
			<span style="display: inline-block; position: relative; color: #fff;   padding: 1px 5px;  background-color: #e91e63;" class="kor"><?=$bullet_kor?></span>
		<?}else if($info['language'] =="3"){?>
			<span style="display: inline-block; position: relative; color: #fff;   padding: 1px 5px;  background-color: #0748bf;"><?=$bullet_eng?></span>
			<span style="display: inline-block; position: relative; color: #fff;   padding: 1px 5px;  background-color: #e91e63;" class="kor"><?=$bullet_kor?></span>
		<?}else if($info['language'] =="4"){?>
			<span style="display: inline-block; position: relative;  color: #fff;  padding: 1px 5px;  background-color: #e91e63;" class="kor"><?=$bullet_kor?></span>
			<span style="display: inline-block; position: relative;  color: #fff;  padding: 1px 5px;  background-color: #0748bf; "class="eng"><?=$bullet_eng?></span>
		<?}?>


		<span class="sessionCode2">[<?=$abs_no?>]</span>
	
		<span class="sessionTit"><?=!empty($abs['title_eng'])?$abs['title_eng']:$abs['title_kor']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$pname?></span>
	</p>

	
	
	<?if($org_info){?>

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
	<?}?>
	
 


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
				<?for($j=1;$j<=$abs['affiliation_cnt']*1;$j++){$k=$j-1;
					$affiliation_query = "select * from abstract_affiliation where asb_num='".$abs['sid']."' and orders='".$j."'";
					$affiliation_result = $local_conn->query($affiliation_query);
					if(DB::isError($affiliation_result)) {
						die($affiliation_result->getMessage().'abstract_affiliation');
					}

					$affiliation_col = $affiliation_result->fetchRow(DB_FETCHMODE_ASSOC);		//  $row 배열에 입력시킨다.
					?>
					<?=$j>1?', ':''?><span><?=$affiliation_col['orders']?>. <?=$affiliation_col['affiliation']?> { <?=$abs_config['department_type'][$affiliation_col['department']].(!empty($affiliation_col['department_others'])?' ('.$affiliation_col['department_others'].')':'')?> }</span>
				<?}?>
			</dd>


			<dt class="absTit">Authors</dt>
			

			<dd>
			<?
			##발표자 책임저자 등록
			$pname="";
			$cname="";
			for($j=1;$j<=$abs['author_cnt']*1;$j++){$k=$j-1;
				$author_query = "select * from abstract_author where asb_num='".$abs['sid']."' and orders='".$j."'";
				$author_result = $local_conn->query($author_query);
				if(DB::isError($author_result)) {
					die($author_result->getMessage().'author_query');
				}

				$author_col = $author_result->fetchRow(DB_FETCHMODE_ASSOC);		//  $row 배열에 입력시킨다.
				?>
				<?=$j>1?', ':''?><?=$author_col['first_name'].' '.$author_col['last_name']?><sup><?=$author_col['affilation']?></sup>
				<?
				$author_type = explode(',',$author_col['type']);
				if(in_array('1',$author_type)){
					$pname=$author_col['first_name'].' '.$author_col['last_name'];
					//echo '<sup>*</sup>';
				}

				if(in_array('2',$author_type)){
					$cname=$author_col['first_name'].' '.$author_col['last_name'];
					//echo '<sup>†</sup>';
				}
				?>
			<?}?>
			</dd>



			<dt class="absTit">Presenter</dt>
			<dd><?=$pname?></dd>

			<dt class="absTit">Corresponding Author</dt>
			<dd><?=$cname?></dd>
			
			<?if(!empty($abs['introduction'])){?>
			<dt class="absTit">Introduction</dt>
			<dd><?=strip_tags($abs['introduction'])?></dd>
			<?}?>
			
			<?if(!empty($abs['materials'])){?>
			<dt class="absTit">Materials and Methods</dt>
			<dd><?=strip_tags($abs['materials'])?></dd>
			<?}?>
			
			<?if(!empty($abs['results'])){?>
			<dt class="absTit">Results</dt>
			<dd><?=strip_tags($abs['results'])?></dd>
			<?}?>
			
			<?if(!empty($abs['conclusion'])){?>
			<dt class="absTit">Conclusion</dt>
			<dd><?=strip_tags($abs['conclusion'])?></dd>
			<?}?>
			
			<?if(!empty($abs['case_text'])){?>
			<dt class="absTit">Case</dt>
			<dd><?=strip_tags($abs['case_text'])?></dd>
			<?}?>
			
			<?if(!empty($abs['contents'])){?>
			<dt class="absTit">Technical Note</dt>
			<dd><?=strip_tags($abs['contents'])?></dd>
			<?}?>
			
			<?if(!empty($abs['acknowledgment'])){?>
			<dt class="absTit">Acknowledgment</dt>
			<dd><?=strip_tags($abs['acknowledgment'])?></dd>
			<?}?>
			
			<?if(!empty($abs['keywords'])){?>
			<dt class="absTit">Keywords</dt>
			<dd><?=strip_tags($abs['keywords'])?></dd>
			<?}?>

			
			

		</dl>

	</div>

	<?}?>