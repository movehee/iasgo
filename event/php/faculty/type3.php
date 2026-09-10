<div class="resultArea wrapper" style="background:#ffffff;padding-top:45px;background-size: 0px;">
	<dl class="resultList">


<?
	$cnt=0;
	$query = "select a.* from faculty_tbl a, faculty_favor_tbl b where a.sid=b.faculty_sid and a.name not in ('','-') and a.code='".$code."' and a.viewYN='Y' and b.deviceid='".$deviceid."' and a.del='N'";
	
	if($search){
		$query .= " and (a.name like '%".$search."%' or a.office  like '%".$search."%' or a.name_en  like '%".$search."%' or a.office_en  like '%".$search."%')";
	}

	if($setting_col['faculty_orderby']=="1"){
		$query .= " order by SUBSTRING_INDEX(a.name,' ',-1) asc";
	}else{
		$query .= " order by a.name asc";
	}

	
	//echo $query;
	$result = mysqli_query($conn, $query);
	
	while(is_array($col = mysqli_fetch_array($result))){
	$cnt++;

	if($cnt==1){?>
		<dt>My Favorite</dt>
	
		<dd>
		<ul class="withFavor">
		<?
	}?>
	<li>


		
		<a href="./../session/list.php?tab=-5&code=<?=$code?>&sid=<?=$col['sid']?>&deviceid=<?=$deviceid?>" class="photo" >
		<table>
		<tr>
		<td>
		<?if($setting_col['faculty_photo']=="1"){
		if($col['photo']){?><span><img style="object-fit:cover;" src="/upload/faculty/<?=$col['photo']?>" ></span>
		<?}else if($setting_col['faculty_def_image']){?>
			<span><img style="object-fit:cover;" src="/upload/faculty/<?=$setting_col['faculty_def_image']?>" alt=""></span>
		<?}else{?>
			<span><img style="object-fit:cover;" src="/image/faculty_thumb.jpg" alt=""></span>
		<?}}?>
		</td>
		<td>
		<span class="facultyInfo">

		<!--
		<?if($setting_col['faculty_txt_type']=="1"){?>
		<?=$col['name']?>
		<?}else if($setting_col['faculty_txt_type']=="2"){?>
		<?=$col['name']." (".$col['office'].")"?>
		<?}else if($setting_col['faculty_txt_type']=="3"){?>
		<?=$col['name']." (".$col['office'].", ".$col['country'].")"?>
		<?}?>
		-->
		<?if($_SERVER['REMOTE_ADDR']=='218.235.94.225'){?>
			
		<?}else{?>
		<?
			$faculty_view_txt = $setting_col['faculty_txt_type_list'];
			$faculty_view_txt = str_replace("{성함(국문)}", $col['name'], $faculty_view_txt);
			$faculty_view_txt = str_replace("{성함(영문)}", $col['name_en'], $faculty_view_txt);
			$faculty_view_txt = str_replace("{소속(국문)}", $col['office'], $faculty_view_txt);
			$faculty_view_txt = str_replace("{소속(영문)}", $col['office_en'], $faculty_view_txt);
			$faculty_view_txt = str_replace("{국가}", $col['country'], $faculty_view_txt);
		?>
		<?=$faculty_view_txt?>
		<?}?>
		</span>
		</td>
		</tr>
		</table>
		</a>
		<?if($setting_col['faculty_favor']=="1"){?>
		<a href="javascript:favor('<?=$cnt?>','<?=$deviceid?>','<?=$col['sid']?>')" class="favor on" id="favor_<?=$cnt?>" title="즐겨찾기 추가됨"><i class="far fa-star"></i></a>
		<?}?>
		</li>

	<?}
if($cnt>0){?>
</ul></dd>



<?
}
	$query = "select * from faculty_tbl where name not in ('','-') and code='".$code."' and viewYN='Y' and del='N'";
	if($search){
		$query .= " and (name like '%".$search."%' or office like '%".$search."%' or office_en like '%".$search."%' or name_en like '%".$search."%')";
	}

	if($setting_col['faculty_orderby']=="1"){
		$query .= " order by SUBSTRING_INDEX(name,' ',-1) asc";
	}else{
		$query .= " order by name asc";
	}

	$result = mysqli_query($conn, $query);
	$group="";
	$group_arr = array();
?>
	<?while(is_array($col = mysqli_fetch_array($result))){
	$cnt++;

	$cnt_result = mysqli_query($conn, "select count(*) cnt from faculty_favor_tbl WHERE faculty_sid='".$col['sid']."' and deviceid='".$deviceid."'");
	//echo "select count(*) cnt from faculty_favor_tbl WHERE faculty_sid='".$col['sid']."' and deviceid='".$deviceid."'";
	$cnt_row = mysqli_fetch_array($cnt_result);
	$fav = $cnt_row['cnt'];

		if($setting_col['faculty_orderby']=="1"){


			$temp = split(" ",$col['name']);
			//echo $temp[sizeof($temp)-1];
			//iconv("UTF-8", "EUC-KR", $temp[sizeof($temp)-1])
			if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $col['name'])){
				
				if($group != cho_hangul($temp[sizeof($temp)-1]))
				{
					$group = cho_hangul($temp[sizeof($temp)-1]);
					?>
					<?if($cnt>1){?>
					</ul>
					<?}?>
					</dd>
					<dt id="group<?=$group?>"><?=$group?></dt>
					<?array_push($group_arr, $group);?>
					<dd>
					<ul class="withFavor">
					<?
				}
			}else{
			if($group != substr($temp[sizeof($temp)-1], 0, 1))
			{
				
				$group = substr($temp[sizeof($temp)-1], 0, 1);
				?>
				<?if($cnt>1){?>
				</ul>
				<?}?>
				</dd>
				<dt id="group<?=$group?>"><?=$group?></dt>
				<?array_push($group_arr, $group);?>
				<dd>
				<ul class="withFavor">
				<?
			}}?>
		<?}else{
			if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $col['name'])){
				if($group != cho_hangul($col['name']))
				{
					$group = cho_hangul($col['name']);
					?>
					<?if($cnt>1){?>
					</ul>
					<?}?>
					</dd>
					<dt id="group<?=$group?>"><?=$group?></dt>
					<?array_push($group_arr, $group);?>
					<dd>
					<ul class="withFavor">
					<?
				}
			}else{
			if($group != substr($col['name'], 0, 1))
			{
				
				$group = substr($col['name'], 0, 1);
				?>
				<?if($cnt>1){?>
				</ul>
				<?}?>
				</dd>
				<dt id="group<?=$group?>"><?=$group?></dt>
				<?array_push($group_arr, $group);?>
				<dd>
				<ul class="withFavor">
				<?
			}}?>

		<?}?>
		
		<li>

		

		
		
		<a href="./../session/list.php?tab=-5&code=<?=$code?>&sid=<?=$col['sid']?>&deviceid=<?=$deviceid?>" class="photo">
		<table>
		<tr>
		<td>
		<?if($setting_col['faculty_photo']=="1"){
		if($col['photo']){?><span><img style="object-fit:cover;" src="/upload/faculty/<?=$col['photo']?>" ></span>
		<?}else if($setting_col['faculty_def_image']){?>
			<span><img style="object-fit:cover;" src="/upload/faculty/<?=$setting_col['faculty_def_image']?>" alt=""></span>
		<?}else{?>
			<span><img style="object-fit:cover;" src="/image/faculty_thumb.jpg" alt=""></span>
		<?}}?>
		</td>
		<td>
			<span class="facultyInfo"> <!--app faculty 에서 이름,소속,국가 일때(길면) 짤리는것 facultyInfo class추가-->			
			<dl>
			<?
				$faculty_view_txt = $setting_col['faculty_txt_type_list'];
				$faculty_view_txt = str_replace("{성함(국문)}", $col['name'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{성함(영문)}", $col['name_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(국문)}", $col['office'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(영문)}", $col['office_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{국가}", $col['country'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{역할}", $col['role'], $faculty_view_txt);
			?>
			<?=$faculty_view_txt?>
			</dl>
		
		</td>
		</tr>
		</table>

		</span>
		</a>
		<?if($setting_col['faculty_favor']=="1"){?>
		<a href="javascript:favor('<?=$cnt?>','<?=$deviceid?>','<?=$col['sid']?>')" class="favor <?if($fav){ echo "on";}?>" id="favor_<?=$cnt?>" title="즐겨찾기 추가됨"><i class="far fa-star"></i></a>
		<?}?>
		</li>

	<?}?>

	
	</ul>
</dd>
</dl>
<!--
	<ul class="filter">
	<?
	foreach ($group_arr as $value) {?>
		<li><a href="#group<?=$value?>"><?=$value?></a></li>
	<?}?>
	</ul>
-->
</div>


<?if($cnt==0){?>
<div class="resultArea <?if($search){?> noBg<?}?>">

</div>
<?}?>
<script type="text/javascript">




function favor(sid,deviceid,faculty_sid){
	//alert("faculty_sid="+faculty_sid+"&deviceid="+deviceid);
	$.ajax({
		type:"POST",
		url:"./favor.php",
		data:"faculty_sid="+faculty_sid+"&deviceid="+deviceid,
		success:function(msg){
			
			if(msg == 'Y'){
				$('#favor_'+sid).addClass("on");
			}else{
				$('#favor_'+sid).removeClass("on");
			}
			location.reload();
			//alert(msg);
		}
	});
	
}
</script>
