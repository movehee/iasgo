<?include "./../header.php";?>

<style>
.tblList{ }
.tblList tr th{width: 25%; padding-left:20px; text-align: left;}
.tblList tr td{ border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; }
.tblList tr td:last-child{ border-right: none; }
.tblList tr th:last-child{ border-right: none; }
.tblList tr th td, span{color:#ff0000; font-weight:bold;}
</style>


<?

$query="SELECT info,count(*) cnt FROM log_tbl where code='".$code."' group by info order by count(*) desc";




$result = mysqli_query($conn, $query);

?>

 

<div id="container">
	
	<h2>로그</h2>
	<div class="contents member">

		<p class="btn" style="top: -44px; right: 150px; position: absolute;"><a href="./excel2.php" class="btnDef tooltipPoint" title="엑셀다운로드"><i class="far fa-file-excel"></i>통계보기</a></p>

		<p class="btn" style="top: -44px; right: 0px; position: absolute;"><a href="./excel.php" class="btnDef tooltipPoint" title="엑셀다운로드"><i class="far fa-file-excel"></i>결과엑셀다운</a></p>
		
		

		<table class="tblList">
			
			<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
				 
				
						<tr>
							<th><?=$d['info']?><span>(<?=$d['cnt']?>)</span></th>
						</tr>						 
					<?
						$sub_query = "SELECT info2, count(*) cnt FROM log_tbl where code='".$code."' and info='".$d['info']."' and info2 not in ('') group by info2 order by count(*) desc";
						$sub_result = mysqli_query($conn, $sub_query);

						while(is_array($sub_d = mysqli_fetch_array($sub_result))){?>
						<tr>	
							<td style="    text-align: left; padding-left: 50px;"><?=$sub_d['info2']?> <span>(<?=$sub_d['cnt']?>)</span></td>					
							<?
							$sub2_query = "SELECT info3, count(*) cnt FROM log_tbl where code='".$code."' and info='".$d['info']."' and info2='".$sub_d['info2']."' and info3 not in ('') group by info3 order by count(*) desc";
							 
							$sub2_result = mysqli_query($conn, $sub2_query);
							while(is_array($sub2_d = mysqli_fetch_array($sub2_result))){?>
						 </tr>
						 <tr>
							<td style="text-align: left; padding-left:100px;"><?=$sub2_d['info3']?> (<?=$sub2_d['cnt']?>)</td>	
						</tr>
							<?}?>


					<?}
				?>
				<?}?>
			</tbody>
		</table>
	
	</div>
	<!-- //contents -->
		
	

</div> <!-- //container -->


   
<?include "./../footer.php";?>