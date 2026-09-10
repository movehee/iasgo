<?
$query = "select * from faculty_tbl where name not in ('','-') and code='".$code."' and viewYN='Y' and del='N'";

$query .= " order by sid asc";
$result = mysqli_query($conn, $query);
?>
<div class="contents">

	<ul class="facultyList">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li><a href="./../session/list.php?tab=-5&code=<?=$code?>&sid=<?=$col['sid']?>&deviceid=<?=$deviceid?>">
			<span class="photo">
		<?
		if($col['photo']){?><span><img src="/upload/faculty/<?=$col['photo']?>" ></span>
		<?}else if($setting_col['faculty_def_image']){?>
			<span><img src="/upload/faculty/<?=$setting_col['faculty_def_image']?>" alt=""></span>
		<?}?></span>
			<dl>
			<?

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
			</dl>
		</a>
		
		
		</li>
	<?}?>
	
	</ul>

</div>

