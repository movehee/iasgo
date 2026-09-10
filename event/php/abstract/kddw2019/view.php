<?php
	include_once "config.php";

	if($view_from == "abstract") {

		/*연동*/
		$query = "SELECT a.* FROM abstract_tbl a WHERE a.sid='".$sid."'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs=$result->fetchRow(DB_FETCHMODE_ASSOC);
		/*연동*/
		
		$abs_no = $abs['ab_num'];

		$aff_array = array();
		if(!empty($abs['department'])) $aff_array['department'] = $abs['department'];
		if(!empty($abs['affi'])) $aff_array['affi'] = $abs['affi'];
		if(!empty($abs['city'])) $aff_array['city'] = $abs['city'];

		if(!empty($abs['ccode'])){
			$query="select * from country_code where cc='".$abs['ccode']."' order by replace(cn,'Korea, Republic','AAAA') asc";
			$result = $local_conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
			$abs_col = $result->fetchRow(DB_FETCHMODE_ASSOC);

			if(!empty($abs['ccode'])) $aff_array['ccode'] = $abs_col['cn'];
		}

	}
	else if($view_from == "session") {

		$info_query = "select a.time, a.abs_no, b.language, r.name as room_name, r.photo from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and a.code='".$code."' and a.sid='".$sid."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);
		
		$abs_no = $info['abs_no'];
		
		/*연동*/
		$query = "SELECT a.* FROM abstract_tbl a WHERE a.ab_num='".$abs_no."'  ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		$abs=$result->fetchRow(DB_FETCHMODE_ASSOC);
		/*연동*/

		$abstract_sid = $abs['sid'];

		$aff_array = array();
		if(!empty($abs['department'])) $aff_array['department'] = $abs['department'];
		if(!empty($abs['affi'])) $aff_array['affi'] = $abs['affi'];
		if(!empty($abs['city'])) $aff_array['city'] = $abs['city'];

		if(!empty($abs['ccode'])){
			$query="select * from country_code where cc='".$abs['ccode']."' order by replace(cn,'Korea, Republic','AAAA') asc";
			$result = $local_conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
			$abs_col = $result->fetchRow(DB_FETCHMODE_ASSOC);

			if(!empty($abs['ccode'])) $aff_array['ccode'] = $abs_col['cn'];
		}

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
	
		<span class="sessionTit"><?=$abs['subject']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$abs['first_name'].' '.(!empty($abs['middle_name'])?$abs['middle_name'].' ':'').$abs['last_name']?></span>
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
				<?=implode(', ', $aff_array)?>
			</dd>


			<dt class="absTit">Authors</dt>
				<?=$abs['first_name'].' '.(!empty($abs['middle_name'])?$abs['middle_name'].' ':'').$abs['last_name']?>, <?=$_cfg['degree'][$abs['degree']]?>

			<dd>
			

			<?if(!empty($abs['abstract_content'])){?>
			<dt class="absTit">Content</dt>
			<dd><?=strip_tags($abs['abstract_content'])?></dd>
			<?}?>

			<?if(!empty($abs['purpose'])){?>
			<dt class="absTit">Background/Aims</dt>
			<dd><?=strip_tags($abs['purpose'])?></dd>
			<?}?>

			<?if(!empty($abs['method'])){?>
			<dt class="absTit">Methods</dt>
			<dd><?=strip_tags($abs['method'])?></dd>
			<?}?>

			<?if(!empty($abs['result'])){?>
			<dt class="absTit">Results</dt>
			<dd><?=strip_tags($abs['result'])?></dd>
			<?}?>

			<?if(!empty($abs['conclusion'])){?>
			<dt class="absTit">Conclusion</dt>
			<dd><?=strip_tags($abs['conclusion'])?></dd>
			<?}?>

			<?if(!empty($abs['keyword'])){?>
			<dt class="absTit">Keywords</dt>
			<dd>
				<?
				$key_array = array_filter(explode("||",$abs['keyword']));
				if($key_array>0){
					echo implode(", ", $key_array);
				}else{
					echo $abs['keyword'];
				}
				?>
			</dd>
			<?}?>

			
			

			
			

		</dl>

	</div>

	<?}?>