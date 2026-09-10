
<?
	$query = "select * from faculty_tbl F";
	$query.=" where F.name not in ('','-') and F.code='".$code."' and F.viewYN='Y' and F.del='N'";
	if($search){
		$query .= " and (F.name like '%".$search."%' or F.office like '%".$search."%' or F.office_en like '%".$search."%' or F.name_en like '%".$search."%')";
	}
	$query .= " order by F.name asc";
	$result = mysqli_query($conn, $query);
	
?>

<?if($result->num_rows){

if($setting_col['faculty']){
	$title=$setting_col['faculty'];
}else{
	$title="faculty";
}
?>
<h3 class="dayInfo2"><?=$title?></h3>
<dl class="resultList">
	<dd>
		<ul>
			<?while(is_array($col = mysqli_fetch_array($result))){
				$cnt_f++;
			?>
			<li style="position: relative;padding: 10px 65px 10px 0;">
				<a href="./../session/list.php?tab=-5&code=<?=$code?>&sid=<?=$col['sid']?>&deviceid=<?=$deviceid?>" class="photo">
				<?
				//$faculty_view_txt = $setting_col['faculty_txt_type_list'];

				if($col['foreigner']=='Y') {
					$faculty_view_txt = $setting_col['faculty_txt_type_list_eng'];
				}
				else {
					$faculty_view_txt = $setting_col['faculty_txt_type_list_kor'];
				}

				$faculty_view_txt = str_replace("{성함(국문)}", $col['name'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{성함(영문)}", $col['name_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(국문)}", $col['office'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(영문)}", $col['office_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{국가}", $col['country'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{역할}", $col['role'], $faculty_view_txt);
				?>
				<?=$faculty_view_txt?>
				
				</a>
			<li>
			<?}?>		
		</ul>
	</dd>
</dl>
<?}?>