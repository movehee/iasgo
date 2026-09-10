<?include "./../header.php";?>

<?
$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
$abs_setting_result = mysqli_query($conn, $abs_setting_query);
$abs_setting_col = mysqli_fetch_array($abs_setting_result);


$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>

<div class="titArea">
	<h2><?=$abs_setting_col['abstract_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>

<?
if($abs_setting_col['abs_sync']=='Y') {
	include "./$code/list.php";
}
else 
{
	if($abs_setting_col['abs_top_menu']==1){
		$top_query = "SELECT * FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0' order by orderby asc";	
		$top_result = mysqli_query($conn, $top_query);
		$top_cnt=1;
		
		$top_all_query = "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0'";	
		$top_all_result = mysqli_query($conn, $top_all_query);
		$top_all_col = mysqli_fetch_array($top_all_result);

	?>
	<ul class="tabMenu">
	<?while(is_array($top_col = mysqli_fetch_array($top_result))){
		$cnt_result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and parent='".$top_col['sid']."'");
		$cnt_row = mysqli_fetch_array($cnt_result);
	?>
		<li class="menu<?if($tab==$top_cnt){echo " on";}?>" style="width:<?=100/$top_all_col['cnt']?>%"><a href="<?if($cnt_row['cnt']==0){?>./list.php<?}else{?>./category.php<?}?>?tab=<?=$top_cnt?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&parent=<?=$top_col['sid']?>"><?=$top_col['info']?></a></li>
	<?
	$top_cnt++;
	}?>
	</ul>
	<?}?>



	</div>
	<ul class="subjectList">
		<?
		if($code == "ksc2019") {
			$query = "select * from 
			(
			   select * from abstract_tbl where code='$code' and ifnull(abs_no,'')!='' and category='$parent'

			) a 
			left join 
			(
			  select s1.orderby, s1.abstract_file, s1.speaker session_speaker, SUBSTRING_INDEX(s1.abs_no, '||', -1) as abs_no, s1.time, s2.sid as session_sid, g.name as date_name, r.view_type, r.name as room_info from session_tbl s1, session_tbl s2, agenda_tbl g, session_room_tbl r   
			  where s1.link_session=s2.sid and s2.tab=g.sid and s2.room=r.sid and s1.type='2' and s1.code='$code' 

			) b

			on a.abs_no=b.abs_no 
			order by a.orderby asc";	
		}
		else {

		if($abs_setting_col['abs_top_menu']==2 && $cat) { //knpa2019f 참조
			$query = "SELECT a.*,b.abstract_file abs_file, b.speaker session_speaker, b.time FROM abstract_tbl a left join session_tbl b on a.abs_no=b.abs_no and b.code='".$code."' and ifnull(a.abs_no,'')!='' where a.code='".$code."'  and (a.info13='".$cat."' or a.info14='".$cat."' or a.info15='".$cat."') order by a.orderby asc";
		}
		else {

			$query = "SELECT a.*,b.abstract_file abs_file, b.speaker session_speaker, b.time FROM abstract_tbl a left join session_tbl b on a.abs_no=b.abs_no and b.code='".$code."' and ifnull(a.abs_no,'')!='' where a.code='".$code."'  and a.category='".$parent."' order by a.orderby asc";	
		}

		}

		//echo $query;
		$result = mysqli_query($conn, $query);
		while (is_array($col = mysqli_fetch_array($result))) {?>

			<?
			if($abs_setting_col['abs_view_type']=="1"){
				if($col['abs_file']){
					$link_url = "/upload/session/".$col['abs_file'];
				}else if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf")){
					$link_url = "/upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf";
				}else{
					$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
				}
			}else if($abs_setting_col['abs_view_type']=="2"){
				$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
			}else {
				if($col['info1'] || $col['info2'] || $col['info3'] || $col['info4'] || $col['info5'] || $col['info6']){
					$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
				}else if($col['abs_file']){
					$link_url = "/upload/session/".$col['abs_file'];
				}else if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf")){
					$link_url = "/upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf";
				}else{
					$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
				}
			}?>
		

			
			<li><a href="<?=$link_url?>">
			<span class="sessionCode" style="margin-bottom:3px; display:block;">
	
			<?if($setting_col['abs_sid']=="Y" && $col['abs_sid']){?>
				<?=$col['abs_sid']?>
			<?}?>

			<?if($setting_col['abs_no']=="Y" && $col['abs_no']){?>
				<?if(strpos($col['abs_no'], "]")===false){?>[<?}?><?=$col['abs_no']?><?if(strpos($col['abs_no'], "]")===false){?>]<?}?>
			<?}?>
			</span>
			


			<span class="absTitle"><?=$col['title']?></span> 
			<span class="speaker"><?if($col['speaker']){?> </span>
			<span style="font-size: 14px;">Speaker : </span><span class="absSpeaker"> <?=$col['speaker']?></span>

			<?}else if($col['session_speaker']){?>
			 <?=$col['session_speaker']?> 
			<?}?>
			<span class="absOffice" style="word-wrap: break-word;"><?if($col['speaker_office']){?>
				(<?=$col['speaker_office']?>)
			<?}?></span>
			<?if($abs_setting_col['abs_info1'] && $col['info1'] && $abs_setting_col['abs_info1_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info1']?> : --> <?=$col['info1']?>
			<?}?>
			<?if($abs_setting_col['abs_info2'] && $col['info2'] && $abs_setting_col['abs_info2_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info2']?> :  --><?=$col['info2']?>
			<?}?>
			<?if($abs_setting_col['abs_info3'] && $col['info3'] && $abs_setting_col['abs_info3_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info3']?> : --><?=$col['info3']?>
			<?}?>
			<?if($abs_setting_col['abs_info4'] && $col['info4'] && $abs_setting_col['abs_info4_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info4']?> : --><?=$col['info4']?>
			<?}?>
			<?if($abs_setting_col['abs_info5'] && $col['info5'] && $abs_setting_col['abs_info5_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info5']?> : --><?=$col['info5']?>
			<?}?>
			<?if($abs_setting_col['abs_info6'] && $col['info6'] && $abs_setting_col['abs_info6_chk']=="Y"){?>
				<br><!-- <?=$abs_setting_col['abs_info6']?> : --><?=$col['info6']?>
			<?}?>
			<?if($abs_setting_col['abs_info7'] && $col['info7'] && $abs_setting_col['abs_info7_chk']=="Y"){?>
				<br><?=$col['info7']?>
			<?}?>
			<?if($abs_setting_col['abs_info8'] && $col['info8'] && $abs_setting_col['abs_info8_chk']=="Y"){?>
				<br><?=$col['info8']?>
			<?}?>
			<?if($abs_setting_col['abs_info9'] && $col['info9'] && $abs_setting_col['abs_info9_chk']=="Y"){?>
				<br><?=$col['info9']?>
			<?}?>
			<?if($abs_setting_col['abs_info10'] && $col['info10'] && $abs_setting_col['abs_info10_chk']=="Y"){?>
				<br><?=$col['info10']?>
			<?}?>
			<?if($abs_setting_col['abs_info11'] && $col['info11'] && $abs_setting_col['abs_info11_chk']=="Y"){?>
				<br><?=$col['info11']?>
			<?}?>
			<?if($abs_setting_col['abs_info12'] && $col['info12'] && $abs_setting_col['abs_info12_chk']=="Y"){?>
				<br><?=$col['info12']?>
			<?}?>
			<?if($abs_setting_col['abs_info13'] && $col['info13'] && $abs_setting_col['abs_info13_chk']=="Y"){?>
				<br><?=$col['info13']?>
			<?}?>
			<?if($abs_setting_col['abs_info14'] && $col['info14'] && $abs_setting_col['abs_info14_chk']=="Y"){?>
				<br><?=$col['info14']?>
			<?}?>
			<?if($abs_setting_col['abs_info15'] && $col['info15'] && $abs_setting_col['abs_info15_chk']=="Y"){?>
				<br><?=$col['info15']?>
			<?}?>
			<?if($abs_setting_col['abs_info16'] && $col['info16'] && $abs_setting_col['abs_info16_chk']=="Y"){?>
				<br><?=$col['info16']?>
			<?}?>

				<?if($code == "ksc2019"){
				
				$room_info = $col['room_info'];

				if(in_array($col['session_sid'], $ex_room1)) { $room_info = "Abstract/Case Zone 1 (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room2)) { $room_info = "Abstract/Case Zone 2 (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room3)) { $room_info = "Abstract/Case Zone 3 (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room4)) { $room_info = "Abstract/Case Zone 4 (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room_a)) { $room_info = "Moderated Poster Zone A (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room_b)) { $room_info = "Moderated Poster Zone B (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room_c)) { $room_info = "Moderated Poster Zone C (".$room_info.")"; }
				else if(in_array($col['session_sid'], $ex_room_d)) { $room_info = "Moderated Poster Zone D (".$room_info.")"; }

				?>

				<div class="sessionInfo" style="padding-top:10px;">
					<?=$col['date_name']?>&nbsp;
					<i class="far fa-clock" title="Time"></i> <?=$col['time']?>&nbsp;
					<i class="fas fa-map-marker-alt" title="Venue"></i> <?=$room_info?>				
				</div>
				<?}?>
			</a>
		</li>
		<?}?>
	</ul>

<?}?>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
<?include "./../footer.php";?>