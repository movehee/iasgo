<style>	
	div.wrapper {transform: scale( 0.7 );transform-origin: 0% 0%;}
</style>
<?
$tap_array = array();
$tap_query = "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc";
$tap_result = mysqli_query($conn, $tap_query);
while(is_array($d = mysqli_fetch_array($tap_result))){
	$tap_array[$d['sid']] = $d['name'];
}


$category_query="SELECT * FROM session_category_tbl WHERE code='".$code."' and del='N' order by orderby asc";
$category_result = mysqli_query($conn, $category_query);
while(is_array($cd = mysqli_fetch_array($category_result))){
	$category_array[$cd['sid']] = $cd['info'];
}
?>
<style>
	a.no-uline:hover   { text-decoration:underline }

	table.tblDef *{font-size:12px;}
	table.tblDef td{
		padding: 28px 5px;
		word-break: break-word;
		text-align: center;
		position: relative;
		vertical-align:top;
	}
</style>
<?
//if($_SERVER['REMOTE_ADDR']=="218.235.94.222"||$_SERVER['REMOTE_ADDR']=="220.71.10.209"||$_SERVER['REMOTE_ADDR']=="218.235.94.225") {
	?>


<div class="wrapper">
	<?
	$ti=1;
	$check_room_tt['92'] = array('11','12');
	$check_room_tt['93'] = array('11','12','13');
	
	//foreach($tap_array as $tap_key=>$tap_val){
		$tap_key = $tab;

		$checked_left_border='10';
		$check_room = array('10','11','13');

		if(count($check_room_tt[$tap_key])>0){
			$check_room = $check_room_tt[$tap_key];
			$checked_left_border=min($check_room_tt[$tap_key]);
		}


		$time_arr = $room_arr = array();
		$room_query = "SELECT * FROM session_room_tbl WHERE code='".$code."' and tab='".$tap_key."' and del='N' order by orderby asc";
		$room_result=mysqli_query($conn, $room_query);		
		while(is_array($rd = mysqli_fetch_array($room_result))){
			if($rd['viewYN']!='Y') continue;
			$room_arr[$rd['sid']]['name'] = $rd['name'];
			$room_arr[$rd['sid']]['order'] = $rd['orderby'];
		}

		$time_query = "SELECT * FROM session_time_tbl WHERE code='".$code."' and del='N' and tab='".$tap_key."' order by orderby asc";
		$time_result=mysqli_query($conn, $time_query);		
		while(is_array($td = mysqli_fetch_array($time_result))){
			if($td['showYN']!='Y') continue;
			$time_arr[$td['sid']] = $td['time'];
		}
		?>
		<h3 class="subTit_bar" style="width: 1600px; "><span><?=$tap_val?></span></h3>
		<!--
		<?if($ti==1){?>
			<ul class="program">
				<li class="spe">Special<br />Lecture</li>
				<li class="abs"><img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral.png" alt="English Session">Abstract<br />Presentation</li>
				<li class="eng"><img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng.png" alt="English Session">English<br />Session</li>
				<li class="es"><img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es.png" alt="English Session">Essence<br />Session</li>
			</ul>
		<?}?>
		-->
		<table class="tblDef" style="width:1600px;">
			<colgroup>
				<col style="width:9%;" />
				<?
				foreach($room_arr as $rkey=>$rval){
					if(in_array($rval['order'], $check_room)){
						?>
						<col style="width:<?=(91/count($room_arr))/2?>%;" />
						<col style="width:<?=(91/count($room_arr))/2?>%;" />
						<?
					}else{
						?>
						<col style="width:<?=91/count($room_arr)?>%;" />
						<?
					}
				}
				?>
			</colgroup>
			<thead>
				<tr>
					<th style="height:50px;" rowspan="2"></th>
					<?
					foreach($room_arr as $rkey=>$rval){
						if(in_array($rval['order'], $check_room)){
							?><th colspan="2"><?=$rval['name']?></th><?
						}else{									
							?><th rowspan="2"><?=$rval['name']?></th><?
						}
					}
					?>
				</tr>
				<tr>
					<?
					foreach($room_arr as $rkey=>$rval){
						if(in_array($rval['order'], $check_room)){
							if($rval['order']==$checked_left_border){
								?>
								<th class="bdLeft">Abstract/Case Zone 1</th>
								<th>Abstract/Case Zone 2</th>
								<?
							}else{
								?>
								<th>Abstract/Case Zone 3</th>
								<th>Abstract/Case Zone 4</th>
								<?
							}
						}
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?
				$posrt_span_time = array('435','441','447');
				$caseANDmoder_time = array('436','442','448');

				$case_sid_arr = array();
				$case_sid_arr['92'] = array('1'=>'5041','2'=>'5050','3'=>'5051','4'=>'5052');
				$case_sid_arr['93'] = array('1'=>'5076','2'=>'5077','3'=>'5078','4'=>'5079');
				$case_sid_arr['94'] = array('1'=>'','2'=>'5106','3'=>'5107','4'=>'5108');

				foreach($time_arr as $tkey=>$tval){
					$height_arr = explode('-',$tval);
					$time1_str = strtotime(date('Y-m-d')." ".$height_arr[0]);
					$time2_str = strtotime(date('Y-m-d')." ".$height_arr[1]);

					##높이값을 계산하기위해 모든 시간을 오늘날자 기준으로 계산함.
					$height = 0;
					$new_time_result = ($time2_str - $time1_str) / 3600;
					$new_height = round($new_time_result,1)*60;
					$height = round($new_height,-1);
					

					if(in_array($tkey,$caseANDmoder_time)){
						?>
						<tr>
							<th style="height:<?=$height==40?'60':$height?>px;" rowspan="4">
								<?=$tval?>
							</th>
							<td colspan="<?=$tap_key=='93'?'10':'9'?>" rowspan="4" style="padding:3px;"></td>
							<td colspan="4" style="padding:3px;">Case presentation</td>
						</tr>
						
						<tr>
							<?
								$case_arr1 = array();
								if(!empty($case_sid_arr[$tap_key]['1'])){
									#$case_query1 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND theme LIKE '%Case 1%'";
									$case_query1 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND sid='".$case_sid_arr[$tap_key]['1']."'";

									$case_result1=mysqli_query($conn, $case_query1);
									$case_arr1 = mysqli_fetch_array($case_result1);
								}



								$bgcolor="#ffffff";
								$fontcolor="#000";
						
								$new_cate_arr = array();
								if(!empty($case_arr1['etc_info'])){
									$new_cate_arr = explode('|', $case_arr1['etc_info']);
								}

								if(in_array('1', $new_cate_arr)){
									$bgcolor="#ccecff";
									$fontcolor="#1f73e5";
								}
							?>
							<td style="border-left: 1px solid #c9c9c9">
								<a class="no-uline" href="./glance_sub.php?glance=<?=$case_arr1['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
									<?
									echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
									if(in_array('8', $new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
									}

									if($case_arr1['language'] == '1'){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
									}

									if(in_array('2',$new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
									}
									echo '</span>';

									$theme_name = $theme_name_arr2 = "";
									$theme_name_arr = $theme_name_arr3 = array();

									$theme_name_arr = explode(" ", $case_arr1['theme']);
									$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
									$theme_name_arr3 = explode("-", $theme_name_arr2);
																
									if(count($theme_name_arr3)==2){
										for($i=0;$i< count($theme_name_arr)-1;$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}

										$theme_name .= "<br><b>".$theme_name_arr2."</b>";
									} else {
										for($i=0;$i< count($theme_name_arr);$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}
									}

									?>
									<span style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;"><?=$theme_name?></span>
								</a>
							</td>
							<?
								$case_arr2 = array();
								
								if(!empty($case_sid_arr[$tap_key]['2'])){
									#$case_query2 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND theme LIKE '%Case 2%'";
									$case_query2 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND sid='".$case_sid_arr[$tap_key]['2']."'";

									$case_result2=mysqli_query($conn, $case_query2);
									$case_arr2 = mysqli_fetch_array($case_result2);
								}

								$bgcolor="#ffffff";
								$fontcolor="#000";
						
								$new_cate_arr = array();
								if(!empty($case_arr2['etc_info'])){
									$new_cate_arr = explode('|', $case_arr2['etc_info']);
								}

								if(in_array('1', $new_cate_arr)){
									$bgcolor="#ccecff";
									$fontcolor="#1f73e5";
								}
							?>
							<td>
								<a class="no-uline" href="./glance_sub.php?glance=<?=$case_arr2['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
									<?
									echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
									if(in_array('8', $new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
									}

									if($case_arr2['language'] == '1'){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
									}

									if(in_array('2',$new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
									}
									echo '</span>';

									$theme_name = $theme_name_arr2 = "";
									$theme_name_arr = $theme_name_arr3 = array();

									$theme_name_arr = explode(" ", $case_arr2['theme']);
									$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
									$theme_name_arr3 = explode("-", $theme_name_arr2);
																
									if(count($theme_name_arr3)==2){
										for($i=0;$i< count($theme_name_arr)-1;$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}

										$theme_name .= "<br><b>".$theme_name_arr2."</b>";
									} else {
										for($i=0;$i< count($theme_name_arr);$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}
									}

									?>
									<span style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;"><?=$theme_name?></span>
								</a>
							</td>
							<?
								$case_arr3 = array();

								if(!empty($case_sid_arr[$tap_key]['3'])){
									#$case_query3 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND theme LIKE '%Case 3%'";
									$case_query3 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND sid='".$case_sid_arr[$tap_key]['3']."'";
									$case_result3=mysqli_query($conn, $case_query3);
									$case_arr3 = mysqli_fetch_array($case_result3);
								}

								$bgcolor="#ffffff";
								$fontcolor="#000";
						
								$new_cate_arr = array();
								if(!empty($case_arr3['etc_info'])){
									$new_cate_arr = explode('|', $case_arr3['etc_info']);
								}

								if(in_array('1', $new_cate_arr)){
									$bgcolor="#ccecff";
									$fontcolor="#1f73e5";
								}
							?>
							<td>
								<a class="no-uline" href="./glance_sub.php?glance=<?=$case_arr3['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
									<?
									echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
									if(in_array('8', $new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
									}

									if($case_arr3['language'] == '1'){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
									}

									if(in_array('2',$new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
									}
									echo '</span>';

									$theme_name = $theme_name_arr2 = "";
									$theme_name_arr = $theme_name_arr3 = array();

									$theme_name_arr = explode(" ", $case_arr3['theme']);
									$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
									$theme_name_arr3 = explode("-", $theme_name_arr2);
																
									if(count($theme_name_arr3)==2){
										for($i=0;$i< count($theme_name_arr)-1;$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}

										$theme_name .= "<br><b>".$theme_name_arr2."</b>";
									} else {
										for($i=0;$i< count($theme_name_arr);$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}
									}

									?>
									<span style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;"><?=$theme_name?></span>
								</a>
							</td>
							<?
								$case_arr4 = array();

								if(!empty($case_sid_arr[$tap_key]['4'])){
									#$case_query4 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND theme LIKE '%Case 4%'";
									$case_query4 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND viewYN='Y' AND sid='".$case_sid_arr[$tap_key]['4']."'";
									$case_result4=mysqli_query($conn, $case_query4);
									$case_arr4 = mysqli_fetch_array($case_result4);
								}

								$bgcolor="#ffffff";
								$fontcolor="#000";
						
								$new_cate_arr = array();
								if(!empty($case_arr4['etc_info'])){
									$new_cate_arr = explode('|', $case_arr4['etc_info']);
								}

								if(in_array('1', $new_cate_arr)){
									$bgcolor="#ccecff";
									$fontcolor="#1f73e5";
								}
							?>
							<td>
								<a class="no-uline" href="./glance_sub.php?glance=<?=$case_arr4['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
									<?
									echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
									if(in_array('8', $new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
									}

									if($case_arr4['language'] == '1'){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
									}

									if(in_array('2',$new_cate_arr)){
										echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
									}
									echo '</span>';

									$theme_name = $theme_name_arr2 = "";
									$theme_name_arr = $theme_name_arr3 = array();

									$theme_name_arr = explode(" ", $case_arr4['theme']);
									$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
									$theme_name_arr3 = explode("-", $theme_name_arr2);
																
									if(count($theme_name_arr3)==2){
										for($i=0;$i< count($theme_name_arr)-1;$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}

										$theme_name .= "<br><b>".$theme_name_arr2."</b>";
									} else {
										for($i=0;$i< count($theme_name_arr);$i++){
											$theme_name .= $theme_name_arr[$i]." ";
										}
									}

									?>
									<span><?=$theme_name?></span>
								</a>
							</td>
						</tr> 
						<tr>
							<td colspan="4" style="padding:3px; border-left: 1px solid #c9c9c9">Moderated Poster presentation</td>
						</tr>

						<?
					}
					?>
					<tr>
						<?
						if(!in_array($tkey,$caseANDmoder_time)){
							?>
							<th style="height:<?=$height==40?'60':$height?>px;">
								<?=$tval?>
							</th>
							<?
						}
						$poster_i = 1;
						foreach($room_arr as $rkey=>$rval){

							if(in_array($rval['order'], $check_room)){
								if(in_array($tkey,$posrt_span_time)){
									##포스터 세션일때
									if($poster_i==1){
										$cel_arr1 = array();
										$sub_query1 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND sid='4254' AND viewYN='Y' limit 0, 1";
										$sub_result1=mysqli_query($conn, $sub_query1);
										$cel_arr1 = mysqli_fetch_array($sub_result1);

										$bgcolor="#ffffff";
										$fontcolor="#000";
								
										$new_cate_arr = array();
										if(!empty($cel_arr1['etc_info'])){
											$new_cate_arr = explode('|', $cel_arr1['etc_info']);
										}

										if(in_array('1', $new_cate_arr)){
											$bgcolor="#ccecff";
											$fontcolor="#1f73e5";
										}
										?>
										<td class="ac" style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;" colspan="4">
											<a class="no-uline" href="./glance_sub.php?glance=<?=$cel_arr1['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
												<?
												echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
												if(in_array('8', $new_cate_arr)){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
												}

												if($cel_arr1['language'] == '1'){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
												}

												if(in_array('2',$new_cate_arr)){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
												}
												echo '</span>';

												$theme_name = $theme_name_arr2 = "";
												$theme_name_arr = $theme_name_arr3 = array();

												$theme_name_arr = explode(" ", $cel_arr1['theme']);
												$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
												$theme_name_arr3 = explode("-", $theme_name_arr2);
																			
												if(count($theme_name_arr3)==2){
													for($i=0;$i< count($theme_name_arr)-1;$i++){
														$theme_name .= $theme_name_arr[$i]." ";
													}

													$theme_name .= "<br><b>".$theme_name_arr2."</b>";
												} else {
													for($i=0;$i< count($theme_name_arr);$i++){
														$theme_name .= $theme_name_arr[$i]." ";
													}
												}

												?>
												<span><?=$theme_name?></span>
											</a>
										</td>
										<?
									}
									$poster_i++;
								}else{
									$cel_arr1 = array();
									$sub_query1 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND room='".$rkey."' AND viewYN='Y' limit 0, 1";
									$sub_result1=mysqli_query($conn, $sub_query1);
									$cel_arr1 = mysqli_fetch_array($sub_result1);

									$cel_arr2 = array();
									$sub_query2 = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND room='".$rkey."' AND viewYN='Y' limit 1, 1";
									$sub_result2=mysqli_query($conn, $sub_query2);
									$cel_arr2 = mysqli_fetch_array($sub_result2);

									$bgcolor="#ffffff";
									$fontcolor="#000";
							
									$new_cate_arr = array();
									if(!empty($cel_arr1['etc_info'])){
										$new_cate_arr = explode('|', $cel_arr1['etc_info']);
									}

									if(in_array('1', $new_cate_arr)){
										$bgcolor="#ccecff";
										$fontcolor="#1f73e5";
									}
									?>
									<td class="ac" style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;  border-left: 1px solid #c9c9c9;<?=in_array($tkey,$caseANDmoder_time)?' padding:5px 2px;':''?>">
										<a class="no-uline" href="./glance_sub.php?glance=<?=$cel_arr1['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
											<?
											echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
											if(in_array('8', $new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
											}

											if($cel_arr1['language'] == '1'){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
											}

											if(in_array('2',$new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
											}
											echo '</span>';

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr1['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}

											?>
											<span><?=$theme_name?></span>
										</a>
									</td>
									<?
									$bgcolor="#ffffff";
									$fontcolor="#000";

									$new_cate_arr = array();
									if(!empty($cel_arr2['etc_info'])){
										$new_cate_arr = explode('|', $cel_arr2['etc_info']);
									}

									if(in_array('1', $new_cate_arr)){
										$bgcolor="#ccecff";
										$fontcolor="#1f73e5";
									}
									?>
									<td style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;<?=in_array($tkey,$caseANDmoder_time)?' padding:5px 2px;':''?>">
										<a class="no-uline" href="./glance_sub.php?glance=<?=$cel_arr2['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
											<?
											$new_cate_arr = array();
											if(!empty($cel_arr2['etc_info'])){
												$new_cate_arr = explode('|', $cel_arr2['etc_info']);
											}

											echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
											if(in_array('8', $new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
											}

											if($cel_arr2['language'] == '1'){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
											}

											if(in_array('2',$new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
											}
											echo '</span>';

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr2['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}
											?>
											<span><?=$theme_name?></span>
										</a>
									</td>
									<?
								}
							}else{
								$cel_arr = array();
								$sub_query = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND TYPE='1' AND tab='".$tap_key."' AND time='".$tkey."' AND room='".$rkey."' AND viewYN='Y' limit 0, 1";
								$sub_result=mysqli_query($conn, $sub_query);
								$cel_arr = mysqli_fetch_array($sub_result);


								$sub_result=mysqli_query($conn, $sub_query);
								$cel_arr = mysqli_fetch_array($sub_result);

								$bgcolor="#ffffff";
								$fontcolor="#000";

								$new_cate_arr = array();
								if(!empty($cel_arr['etc_info'])){
									$new_cate_arr = explode('|', $cel_arr['etc_info']);
								}

								if(in_array('1', $new_cate_arr)){
									$bgcolor="#ccecff";
									$fontcolor="#1f73e5";
								}
								
								if(!in_array($tkey,$caseANDmoder_time)){
									?>
									<td class="ac" style="background-color:<?=$bgcolor?>;color:<?=$fontcolor?>;">
										<a class="no-uline" href="./glance_sub.php?glance=<?=$cel_arr['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
											<?
											$new_cate_arr = array();
											if(!empty($cel_arr['etc_info'])){
												$new_cate_arr = explode('|', $cel_arr['etc_info']);
											}

											echo '<span class="bullet" style="position:absolute;left:5px;top:5px;">';
											if(in_array('8', $new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es"> &nbsp;';
											}

											if($cel_arr['language'] == '1'){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
											}

											if(in_array('2',$new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
											}
											echo '</span>';

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}
											?>
											<span><?=$theme_name?></span>
										</a>
										<?
										if($tap_key=='94'&&$tkey=='447'&&$rkey=='304'){
											$cel_arr = array();
											$sub_query = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND sid='4336' AND viewYN='Y' limit 0, 1";
											$sub_result=mysqli_query($conn, $sub_query);
											$cel_arr = mysqli_fetch_array($sub_result);

											$bgcolor="#ffffff";
											$fontcolor="#000";

											$new_cate_arr = array();
											if(!empty($cel_arr['etc_info'])){
												$new_cate_arr = explode('|', $cel_arr['etc_info']);
											}

											if(in_array('1', $new_cate_arr)){
												$bgcolor="#ccecff";
												$fontcolor="#1f73e5";
											}

											
											echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
											if(in_array('8', $new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
											}

											if($cel_arr['language'] == '1'){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
											}

											if(in_array('2',$new_cate_arr)){
												echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
											}
											echo '</span>';

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}


											?>
											<span style="position: absolute; left: -1px; top: 90px; background-color: #fff; width: 100%; border: 1px solid #c9c9c9; z-index:99;   background-color: white; height: 130px;">
												<a href="./glance_sub.php?glance=<?=$cel_arr['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
													<span style="display:block; padding-top:50px;"><?=$theme_name?></span>
												</a>
											</span>
											<?
										}else if($tap_key=='92'&&$tkey=='435'&&$rkey=='287'){
											$cel_arr = array();
											$sub_query = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND sid='3498' AND viewYN='Y' limit 0, 1";											$sub_result=mysqli_query($conn, $sub_query);
											$cel_arr = mysqli_fetch_array($sub_result);

											$bgcolor="#ffffff";
											$fontcolor="#000";

											$new_cate_arr = array();
											if(!empty($cel_arr['etc_info'])){
												$new_cate_arr = explode('|', $cel_arr['etc_info']);
											}

											if(in_array('1', $new_cate_arr)){
												$bgcolor="#ccecff";
												$fontcolor="#1f73e5";
											}

											

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}
											?>
											<span style="position: absolute; left: -1px; top: -1px; background-color: #fff; width: 100%; border: 1px solid #c9c9c9; z-index:99;   background-color: white; height: 110px;">
												<?
												echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
												if(in_array('8', $new_cate_arr)){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/icon/proBl_es_s.png" alt="Es">';
												}

												if($cel_arr['language'] == '1'){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
												}

												if(in_array('2',$new_cate_arr)){
													echo '<img src="https://www.ksc2019.or.kr:4456/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
												}
												echo '</span>';
												?>
												<a href="./glance_sub.php?glance=<?=$cel_arr['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
													<span style="display:block; padding-top:40px;"><?=$theme_name?></span>
												</a>
											</span>
											<?
										}else if($tap_key=='93'&&$tkey=='440'&&$rkey=='533'){
											$cel_arr = array();
											$sub_query = "SELECT * FROM session_tbl WHERE CODE='".$code."' AND sid='8996' AND viewYN='Y' limit 0, 1";
											$sub_result=mysqli_query($conn, $sub_query);
											$cel_arr = mysqli_fetch_array($sub_result);


											$bgcolor="#ffffff";
											$fontcolor="#000";

											$new_cate_arr = array();
											if(!empty($cel_arr['etc_info'])){
												$new_cate_arr = explode('|', $cel_arr['etc_info']);
											}

											if(in_array('1', $new_cate_arr)){
												$bgcolor="#ccecff";
												$fontcolor="#1f73e5";
											}

											

											$theme_name = $theme_name_arr2 = "";
											$theme_name_arr = $theme_name_arr3 = array();

											$theme_name_arr = explode(" ", $cel_arr['theme']);
											$theme_name_arr2 = $theme_name_arr[count($theme_name_arr)-1];
											$theme_name_arr3 = explode("-", $theme_name_arr2);
																		
											if(count($theme_name_arr3)==2){
												for($i=0;$i< count($theme_name_arr)-1;$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}

												$theme_name .= "<br><b>".$theme_name_arr2."</b>";
											} else {
												for($i=0;$i< count($theme_name_arr);$i++){
													$theme_name .= $theme_name_arr[$i]." ";
												}
											}
											?>
											<span style="position: absolute; left: -1px; top: -25px; background-color: #fff; width: 100%; border: 1px solid #c9c9c9; z-index:99;   background-color: white; height: 170px;">
												<?
												echo '<span class="bullet" style="position:absolute;left:5px;top:5px;"> &nbsp;';
												if(in_array('8', $new_cate_arr)){
													echo '<img src="/image/icon/proBl_es_s.png" alt="Es">';
												}

												if($cel_arr['language'] == '1'){
													echo '<img src="/image/sub/proBl_eng_s.png" alt="English Session"> &nbsp;';
												}

												if(in_array('2',$new_cate_arr)){
													echo '<img src="/image/sub/proBl_oral_s.png" alt="Oral Presentation"> &nbsp;';
												}
												echo '</span>';
												?>
												<a href="./glance_sub.php?glance=<?=$cel_arr['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>">
													<span style="display:block; padding-top:40px;"><?=$theme_name?></span>
												</a>
											</span>
											<?
										}
										?>


									</td>
									<?
								}
							}
						}
						?>
					</tr>
				<?}?>
			</tbody>
		</table>
		<?
		/*
		if($tap_key=='92'){##18일 아래
			?>
			<p style="width: 1600px; margin-left: -200px; font-size:13px;" class="tm10">
				1) JCS: Japanese Circulation Society<Br />
				2) VNHA: Vietnam National Heart Association<Br />
				3) IHA: Indonesia Heart Association<Br />
				4) KCDC: Korea Centers for Disease Control & Prevention
			</p>
			<?
		}else if($tap_key=='93'){##19일 아래
			?>
			<p style="width: 1600px; margin-left: -200px; font-size:13px;" class="tm10">
				1) TSOC: Taiwan Society of Circulation<Br />
				2) BESCO: Biomedical Engineering Society for Circulation<Br />
				3) JCS: Japanese Circulation Society
			</p>
			<?
		}else if($tap_key=='94'){##20일 아래
			?>
			<!--<p style="width: 1600px; margin-left: -200px; font-size:13px;">
				* TSOC: Taiwan Society of Circulation<Br />
				** BESCO: Biomedical Engineering Society for Circulation
			</p>-->
			<?
		}
		*/
		$ti++;
	/*}*/
?>
</div>