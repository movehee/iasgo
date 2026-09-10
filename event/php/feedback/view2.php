<?include "./../header.php";?>

<?


$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

if(!$id) {
	$id= $deviceid;
}
$query="SELECT * FROM feedback_tbl where code='".$code."' and  del='N'";

$query.=" order by orderby asc";
$result = mysqli_query($conn, $query);

$d = null;



$j=1;
$q=1;
?>

<!-- Feedback -->
<!-- <?if($type != "mobile"){?> -->
<?if($event_col['gubun']=="WEB"){?>
<p class="toptit">FEEDBACK<!-- <img src="/image/t_feedback.png"> --></p>
<?}?>
<?}?>
<!-- <p class="toptit"><img src="/image/t_suggestion.png"></p>
 -->
<div class="wrapper">


	<div>
	<?if($title){?>
	<div class="titArea">
		
		<h2><?=$title?></h2>
		<p class="fixedBtn">
			<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		</p>
		
		


	</div>
	<?}?>


	</div>




	<div class="feedbackArea">
	<form name="researchF" id="researchF" method="post" action="./post.php">
	<input type="hidden" name="code" id="code" value="<?=$code?>">
	<input type="hidden" name="deviceid" id="deviceid" value="<?=$id?>">
	<input type="hidden" name="name" value="<?=$name?>">
	<input type="hidden" name="all_chk" id="all_chk" value="<?=$setting_col['feedback_all_chk']?>">
	
	<!--

	<input type="hidden" name="hospital" value="<?=$hospital?>">
	-->
	<legend>FEEDBACK</legend>
	<fieldset style="border:1px solid <?=$css_col['feedback_bg']?>">
		
		<?while(is_array($col = mysqli_fetch_array($result))){?>

			<?if($col['type']=="0"){?>
				<h2 class="subTitBg"><span><b><?=$col['val1']?></b></span><?=$col['val2']?></h2>
			<?}?>


			<?if($col['type']=="1"){?>
				<h2 class="subTitBg" style="padding: 10px 15px 10px 15px;"><?=$col['val1']?></h2>
			<?}?>
			
			<?if($col['type']=="2"){?>
				<dl class='feedbackItem'>
					<dt class="subTit2"><?=$col['val1']?></dt>
				</dl>
			<?}?>

			<?if($col['type']=="3"){?>
				<dl class='feedbackItem'>
					<dt class="subTit"><b>ㆍ</b><?=$col['val1']?></dt>
				</dl>
			<?}?>


			<?if($col['type']=="11"){?>
				<dl class='feedbackItem'>
					<dd class="multi">
					<?for($i=1;$i<=$col['cnt'];$i++){?>
						
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?>
						
						<?
							$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and answer".$j."='".$i."'");
							$temp_row = mysqli_fetch_array($temp_result);
							
						?>
						<span class="feedback_result">(<?=$temp_row['cnt']?>명)</span>
						</label>
					<?}?>
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<?$j++;?>
					</dd>
				</dl>
			<?}?>

			<?if($col['type']=="12"){?>
				<ul class='feedbackItem'>

					<?for($i=1;$i<=$col['cnt'];$i++){?>
						<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
						
						<?
							$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and answer".$j."='".$i."'");
							$temp_row = mysqli_fetch_array($temp_result);
							
						?>
						<span class="feedback_result">(<?=$temp_row['cnt']?>명)</span>
					<?}?>
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<?$j++;?>

				</ul>
			<?}?>

			<?if($col['type']=="13"){?>
				<ul class='feedbackItem'>

					<?for($i=1;$i<=$col['cnt'];$i++){?>
						<li onclick="chk_qu2(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['max']?>)">
						<span class="changeBg inputR 
						
						<?
						$split =explode(',',$d['answer'.$j]);
						for($ll = 0 ; $ll < count($split) ; $ll++){
							if($split[$ll]==$i){
								echo " on";
							}
						}?>"
						id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
						
						<?
							//$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and concat(answer".$j.",',') like '%".$i.",%'");
							$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and FIND_IN_SET('".$i."', answer".$j.")");
							$temp_row = mysqli_fetch_array($temp_result);
							
						?>
						<span class="feedback_result">(<?=$temp_row['cnt']?>명)</span>
					<?}?>
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<?$j++;?>

				</ul>
			<?}?>


			<?if($col['type']=="21"){?>
				<dl class='feedbackItem'>
				<dd>
					<select name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">

					<?for($i=1;$i<=$col['cnt'];$i++){?>

						<option <?if ($d['answer'.$j]==$i){?> selected<?}?> value="<?=$i?>"><?=$col['sub'.$i]?></option>

					<?}?>
					<?$j++;?>
					</select>
				</dd>
				</dl>
			<?}?>

			<?if($col['type']=="31"){?>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

							<?for($i=1;$i<=5;$i++){?>

							<li><a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" onclick="chk_qu(<?=$j?>,<?=$i?>,'5')"><?=$i?></a>
							<br>
							<?
								$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and answer".$j."='".$i."'");
								$temp_row = mysqli_fetch_array($temp_result);
								
							?>
							<span class="feedback_result">(<?=$temp_row['cnt']?>명)</span>
							</li>
							<?}?>
							<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">

							<?$j++;?>
						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			<?}?>

			<?if($col['type']=="32"){?>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

						<?for($i=1;$i<=$col['cnt'];$i++){?>

							<li style="width:<?=100/$col['cnt']?>%">
							
							<a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)"><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i>
							</a>

							<label style="margin-top:5px" for=""><?=$col['sub'.$i]?>
							<br>
							<?
								$temp_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and answer".$j."='".$i."'");
								$temp_row = mysqli_fetch_array($temp_result);
								
							?>
							<span class="feedback_result">(<?=$temp_row['cnt']?>명)</span>
							</label>
							</li>


<!--
							<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>

-->

						<?}?>
						<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
						<?$j++;?>
						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			<?}?>

			<?if($col['type']=="41"){?>
			<?
				$temp_result = mysqli_query($conn, "SELECT memo".$q." FROM feedback_result_tbl where code='".$code."' and memo".$q."!=''");
				$temp_cnt=0;
				while(is_array($temp_col = mysqli_fetch_array($temp_result))){
					$temp_cnt++;
					?>
					<br><?=$temp_cnt?>. 

					<?=$temp_col['memo'.$q]?><br>

				<?}
			?>
				<?$q++;?>
				
			<?}?>
			<?if($col['type']=="99"){?>
			</fieldset>
				<img src="/upload/feedback/<?=$col['image']?>" style="margin-top:-2px;">
				<fieldset style="border:1px solid <?=$css_col['feedback_bg']?>;">
			<?}?>

			<?if($col['type']=="999"){?>
				<?=$col['val1']?>
			<?}?>
		<?}?>
	</fieldset>

	</form>
	</div>
</div>


<?include "./../footer2.php";?>