<?include "./../header.php";?>

<?

//$query = "SELECT a.*,b.abstract_file abs_file, b.speaker session_speaker FROM abstract_tbl a left join session_tbl b on a.abs_no=b.abs_no and ifnull(a.abs_no,'')!='' where a.code='".$code."'  and a.category='".$parent."' order by a.orderby asc";	

$query = "SELECT a.*,b.abstract_file abs_file, b.speaker session_speaker FROM abstract_tbl a left join session_tbl b on a.abs_no=b.abs_no and b.code='".$code."' and ifnull(a.abs_no,'')!='' where a.code='".$code."'  and a.category='".$parent."' order by a.orderby asc";	

//echo $query;
$result = mysqli_query($conn, $query);
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>

<div class="titArea">
	<h2><?=$setting_col['abstract_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>

<?
if($setting_col['abs_top_menu']==1){
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
	while (is_array($col = mysqli_fetch_array($result))) {?>

		<?
		if($setting_col['abs_view_type']=="1"){
			if($col['abs_file']){
				$link_url = "/upload/session/".$col['abs_file'];
			}else if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf")){
				$link_url = "/upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf";
			}else{
				$link_url = "./view.php?code=".$code."&tab=".$tab."&sid=".$col['sid'];
			}
		}else {
			if($col['info1'] || $col['info2'] || $col['info3'] || $col['info4'] || $col['info5'] || $col['info6']){
				$link_url = "./view.php?code=".$code."&tab=".$tab."&sid=".$col['sid'];
			}else if($col['abs_file']){
				$link_url = "/upload/session/".$col['abs_file'];
			}else if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf")){
				$link_url = "/upload/code/".$code."/".str_replace("]","",str_replace("[","",$col['abs_no'])).".pdf";
			}else{
				$link_url = "./view.php?code=".$code."&tab=".$tab."&sid=".$col['sid'];
			}
		}?>
	

		
		<li><a href="<?=$link_url?>">
		<?if($col['abs_no']){?>
			<span style="font-size:11px;"><?if(strpos($col['abs_no'], "]")===false){?>[<?}?><?=$col['abs_no']?><?if(strpos($col['abs_no'], "]")===false){?>]<?}?></span><br>
		<?}?>

		<b><?=$col['title']?></b>

		<?if($col['speaker']){?>
			<br>Speaker : <?=$col['speaker']?> 
		<?}else if($col['session_speaker']){?>
			<br><?=$col['session_speaker']?> 
		<?}?>
		<?if($col['speaker_office']){?>
			(<?=$col['speaker_office']?>)
		<?}?>
		<?if($setting_col['abs_info1'] && $col['info1'] && $setting_col['abs_info1_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info1']?> : --> <?=$col['info1']?>
		<?}?>
		<?if($setting_col['abs_info2'] && $col['info2'] && $setting_col['abs_info2_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info2']?> :  --><?=$col['info2']?>
		<?}?>
		<?if($setting_col['abs_info3'] && $col['info3'] && $setting_col['abs_info3_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info3']?> : --><?=$col['info3']?>
		<?}?>
		<?if($setting_col['abs_info4'] && $col['info4'] && $setting_col['abs_info4_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info4']?> : --><?=$col['info4']?>
		<?}?>
		<?if($setting_col['abs_info5'] && $col['info5'] && $setting_col['abs_info5_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info5']?> : --><?=$col['info5']?>
		<?}?>
		<?if($setting_col['abs_info6'] && $col['info6'] && $setting_col['abs_info6_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info6']?> : --><?=$col['info6']?>
		<?}?>
		<?if($setting_col['abs_info7'] && $col['info7'] && $setting_col['abs_info7_chk']=="Y"){?>
			<br><!-- <?=$setting_col['abs_info7']?> : --><?=$col['info7']?>
		<?}?>


		
		
		</a></li>
	<?}?>
</ul>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
<?include "./../footer.php";?>