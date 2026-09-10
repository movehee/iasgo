<?include "./../header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if($type){
	$query="SELECT * FROM regist_type_tbl where sid='".$type."' and del='N'";
	$result = mysqli_query($conn, $query);

}



$query="SELECT * FROM regist_tbl where code='".$code."' and del='N'";

if(!$dep){
	$dep=0;
}else{
	$regist_type_query="SELECT * FROM regist_type_sub_tbl where type_sid='".$setting_col['regist_money_type'.$dep]."' and del='N'";
	$regist_type_query.=" order by orderby asc";

	$regist_type_result = mysqli_query($conn, $regist_type_query);

}
$dep++;






?>
<div id="container" style="width: 700px;">
	
	
		<div class="contents member">

			<table class="tblList">
				<colgroup>
					<col style="width: 40%;">
					<col style="width: 40%;">
					<col style="width: 20%;">
				</colgroup>
				<tbody>
				<?if($dep>1){?>
				<?while(is_array($regist_type_d = mysqli_fetch_array($regist_type_result))){
					if($dep==2){
						$temp_result = mysqli_query($conn, "select money from regist_money_tbl where code='".$code."' and type0='".$type0."' and type1='".$regist_type_d['sid']."' and type2='".$type2."' and type3='".$type3."'");
					}else if($dep==3){
						$temp_result = mysqli_query($conn, "select money from regist_money_tbl where code='".$code."' and type0='".$type0."' and type1='".$type1."' and type2='".$regist_type_d['sid']."' and type3='".$type3."'");
					}else if($dep==4){
						$temp_result = mysqli_query($conn, "select money from regist_money_tbl where code='".$code."' and type0='".$type0."' and type1='".$type1."' and type2='".$type2."' and type3='".$regist_type_d['sid']."'");
					}
					$temp_row = mysqli_fetch_array($temp_result);
	
				
				?>
			


				<tr class="bg">
					<td><?=$regist_type_d['info']?></td>
					<td><input  onchange="javascript:changeVal(this,'<?=$code?>','<?=$type0?>','<?=$type1?>','<?=$type2?>','<?=$type3?>','<?=$dep?>','<?=$regist_type_d['sid']?>')" type="text" value="<?=$temp_row['money']?>"/></td>
					<td>
					<?if($setting_col['regist_money_type'.$dep]){?>
					<a onclick="javascript:sub_type('<?=$code?>','<?=$type0?>','<?=$type1?>','<?=$type2?>','<?=$type3?>','<?=$dep?>','<?=$regist_type_d['sid']?>')" class="icon ok">SUB</a>
					<?}?>
					</td>
					
				</tr>
				<?}}else{?>
					<tr class="bg">
						<td>사전등록</td>
						<td><input  onchange="javascript:changeVal(this,'<?=$code?>','1','0','0','0','1')" type="text" /></td>
						<td>
						<?if($setting_col['regist_money_type1']){?>
						<a onclick="javascript:sub_type('<?=$code?>','1','0','0','0','<?=$dep?>','1')" class="icon ok">SUB</a>
						<?}?>
						</td>
					</tr>

					<tr class="bg">
						<td>현장등록</td>
						<td><input  onchange="javascript:changeVal(this,'<?=$code?>','2','0','0','0','2')" type="text" /></td>
						<td>
						<?if($setting_col['regist_money_type1']){?>
						<a onclick="javascript:sub_type('<?=$code?>','2','0','0','0','<?=$dep?>','2')" class="icon ok">SUB</a>
						<?}?>
						</td>
					</tr>
					
				<?}?>

				</tbody>

			</table>

		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function sub_type(code, type0, type1, type2, type3, dep, val) {

	if(dep=="1"){
		type0=val;
	}else if(dep=="2"){
		type1=val;
	}else if(dep=="3"){
		type2=val;
	}else if(dep=="4"){
		type3=val;
	}
	location.href="./money.php?code="+code+"&type0="+type0+"&type1="+type1+"&type2="+type2+"&type3="+type3+"&dep="+dep;
}

function changeVal(val, code, type0, type1, type2, type3, dep, val2) {


	if(dep=="1"){
		type0=val2;
	}else if(dep=="2"){
		type1=val2;
	}else if(dep=="3"){
		type2=val2;
	}else if(dep=="4"){
		type3=val2;
	}

	$.ajax({
		type:"POST",
		url:"./money_update.php",
		data:"val="+encodeURIComponent(val.value)+"&code="+code+"&type0="+type0+"&type1="+type1+"&type2="+type2+"&type3="+type3,
		success:function(msg){
			//alert(msg);
		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

</script>

   
<?include "./../footer.php";?>