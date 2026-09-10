<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<?
if($kind=="broc"){
	$query = "insert into booth_brochures set booth_sid='$sid', sort_num='1'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$nsid = mysql_insert_id();

	$Fname = "cover_file_".$nsid;
	$Fname2 = "broc_file_".$nsid;
?>
	<tr>
		<td style="padding:0px !important;"><span class="numberic"></span></td>
		<td class="al"><input type="text" style="width:92%;" class="Ch_con" kind="broc" field="broc_title" key="<?=$nsid?>"></td>
		<td style="padding:0px !important;">
			<div class="selectFile" id="<?=$Fname?>_Area" >
				<p><input name="" id="<?=$Fname?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
				<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname?>" id="<?=$Fname?>" onchange="document.getElementById('<?=$Fname?>_txt').value=this.value;file_upload_ajax(<?=$nsid?>,'<?=$Fname?>','broc')" type="file" ></p>
			</div>
			<div id="<?=$Fname?>_list" ></div>
		</td>
		<td style="padding:0px !important;">
			<div class="selectFile" id="<?=$Fname2?>_Area" >
				<p><input name="" id="<?=$Fname2?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
				<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname2?>" id="<?=$Fname2?>" onchange="document.getElementById('<?=$Fname2?>_txt').value=this.value;file_upload_ajax(<?=$nsid?>,'<?=$Fname2?>','broc')" type="file" ></p>
			</div>
			<div id="<?=$Fname2?>_list" ></div>
		</td>
		<td>
			<input type="checkbox" style="width:22px;height:22px;margin:0px;padding:0px;" key="<?=$nsid?>" kind="broc_stamp" class="check_value">
		</td>
		<td style="padding:0px !important;cursor:default;">
			<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$nsid?>','broc')">
		</td>
	</tr>
<?}?>


<?
if($kind=="movie"){
	$query = "insert into booth_movie set booth_sid='$sid', sort_num='1'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$nsid = mysql_insert_id();

	$Fname = "movie_file_".$nsid;
?>
	<tr>
		<td style="padding:0px !important;"><span class="numberic"></span></td>
		<td class="al"><input type="text" style="width:92%;" class="Ch_con" kind="movie" field="movie_title" key="<?=$nsid?>"></td>
		<td class="al">
			<textarea class="Ch_con" kind="movie" field="movie_content" key="<?=$nsid?>"></textarea>
		</td>
		<td style="padding:0px !important;">
			<div class="selectFile" id="<?=$Fname?>_Area" >
				<p><input name="" id="<?=$Fname?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
				<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname?>" id="<?=$Fname?>" onchange="document.getElementById('<?=$Fname?>_txt').value=this.value;file_upload_ajax(<?=$nsid?>,'<?=$Fname?>','movie')" type="file" ></p>
			</div>
			<div id="<?=$Fname?>_list" ></div>
		</td>
		<td style="padding:0px !important;cursor:default;">
			<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$nsid?>','movie')">
		</td>
	</tr>
<?}?>


<?
if($kind=="survey"){
	$max_num = $conn->getOne("select max(sort_num) from survey_tbl where booth_sid='$sid'");
	if(!$max_num){
		$sort_num = 1;
	}else{
		$sort_num = $max_num+1;
	}
	$query = "insert into survey_tbl set booth_sid='$sid', sort_num='$sort_num'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$nsid = mysql_insert_id();

	$Fname = "movie_file_".$nsid;
?>
	<!-- <tr>
		<td style="padding:0px !important;"><span class="numberic"></span></td>
		<td class="al"><input type="text" style="width:92%;" class="Ch_con" kind="movie" field="movie_title" key="<?=$nsid?>"></td>
		<td class="al">
			<textarea class="Ch_con" kind="movie" field="movie_content" key="<?=$nsid?>"></textarea>
		</td>
		<td style="padding:0px !important;">
			<div class="selectFile" id="<?=$Fname?>_Area" >
				<p><input name="" id="<?=$Fname?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
				<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname?>" id="<?=$Fname?>" onchange="document.getElementById('<?=$Fname?>_txt').value=this.value;file_upload_ajax(<?=$nsid?>,'<?=$Fname?>','movie')" type="file" ></p>
			</div>
			<div id="<?=$Fname?>_list" ></div>
		</td>
		<td style="padding:0px !important;cursor:default;">
			<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$nsid?>','movie')">
		</td>
	</tr> -->

	<tr>
		<td style="padding:0px !important;"><span class="numberic"></span></td>
		<td>
			<select class="Ch_con survey_type" kind="survey" field="type" key="<?=$nsid?>">
				<option value="">선택</option>
				<option value="1" <?if($d['type']=='1'){?>selected<?}?> >점수(별)형</option>
				<option value="2" <?if($d['type']=='2'){?>selected<?}?> >선택형</option>
				<option value="3" <?if($d['type']=='3'){?>selected<?}?> >주관식</option>
			<select>
		</td>
		<td class="al"><input type="text" style="width:92%;" value="<?=$d['survey_title']?>" class="Ch_con" kind="survey" field="survey_title" key="<?=$nsid?>"></td>
	
		<td style="padding:0px !important;">
			<p class="answer_set hand" <?if($d['type']!='2'){?>style="display:none;"<?}?> key="<?=$nsid?>"><i class="fas fa-search"></i>
		</td>
		<td style="padding:0px !important;cursor:default;">
			<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$nsid?>','survey')">
		</td>
	</tr>
<?}?>