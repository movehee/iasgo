<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
?>

<div class="contents">
	<div>	
		<div class="btn bp5" style="float:right;">
			<a href="excel.php" class="btnGrey btnGreen2"><i class="fas fa-download"></i>Excel Backup</a>
		</div>
	</div>
	<h2>- 후원사 </h2>
	<table class="tblDef">
		<colgroup>
			<col style="width: 20%;" />
			<!-- <col style="width: 6%;" /> -->
			<col style="width: " />
		</colgroup>
		<thead>
			<tr>
				<th>상품명</th>
				<!-- <th>수량</th> -->
				<th >당첨자</th>
			</tr>
			
		</thead>
		<tbody>
			<?foreach($_Gift['gift_K'] as $tkey=>$tval){?>
			<?//if($tval=='N') continue;?>
			<?
			$gift_cnt = $conn->getOne("select count(*) from gift_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.gift='$tkey' and t1.kind='A'");
			?>
			<tr>
				<td><?=$tval['title']?><br>(<?=$gift_cnt?>명)</td>
				<!-- <td><?=$tval['cnt']?>개</td> -->
				<td colspan=7 style="padding:0px;margin:0px;">
					<div class="scrollArea wtHolder " style="max-height:300px !important;padding:0px;margin:0px;border:0px;">
					<table cellpadding=0 cellspacing=0 width="100%;">
						<tr>
							<th style="width:30px;background:#263238;color:#ffffff;height:30px;">No</th>
							<th style="width:100px;background:#263238;color:#ffffff;border-left:1px solid #fff;">등록번호</th>
							<th style="width:130px;background:#263238;color:#ffffff;border-left:1px solid #fff;">구분</th>
							<th style="width:90px;background:#263238;color:#ffffff;border-left:1px solid #fff;">성명</th>
							<th style="width:90px;background:#263238;color:#ffffff;border-left:1px solid #fff;">면허번호</th>
							<th style="width:200px;background:#263238;color:#ffffff;border-left:1px solid #fff;">소속</th>
							<th style="background:#263238;color:#ffffff;border-left:1px solid #fff;">이메일</th>
							<th style="width:120px;background:#263238;color:#ffffff;border-left:1px solid #fff;">연락처</th>
							<th style="width:100px;background:#263238;color:#ffffff;border-left:1px solid #fff;">당첨일</th>
							<th style="width:50px;background:#263238;color:#ffffff;border-left:1px solid #fff;">관리</th>
						</tr>
						<?
							

							if($gift_cnt>0){
							$gift_query = "select t1.sid as gift_sid,t1.signdate as gift_date,t2.* from gift_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.gift='$tkey'and t1.kind='A'  order by t1.signdate asc";
							$gift_result=$conn->query($gift_query);
							if(DB::isError($gift_result)) die($gift_result->getMessage());
							$n=1;
							while(is_array($g=$gift_result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<tr>
							<td style="height:30px;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>background:#F2F2F2;"><?=$n?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['etc_field2']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$_REG['reg_kind'][$g['reg_kind']]?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><a href="javascript:popup_call('registration/postform','sid=<?=$g['sid']?>')"><?=$g['name_kr']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['license_number']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['aff_kor']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['email']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['cell']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=date("m.d H:i",$g['gift_date'])?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>">
								<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$g['gift_sid']?>','gift')">
							</td>
						</tr>
						<?$n++;}?>
						<?}else{?>
						<tr>
							<td colspan=8 style="height:30px;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>">당첨자가 없습니다.</td>
							
						</tr>
						<?}?>
					</table>
					</div>
				</td>
			</tr>
			<?}?>
			
		</tbody>
	</table>
	<h2>- 전시부스 </h2>
	<table class="tblDef">
		<colgroup>
			<col style="width: 20%;" />
			<!-- <col style="width: 6%;" /> -->
			<col style="width: " />
		</colgroup>
		<thead>
			<tr>
				<th>상품명</th>
				<!-- <th>수량</th> -->
				<th >당첨자</th>
			</tr>
			
		</thead>
		<tbody>
			<?foreach($_Gift['gift_K'] as $tkey=>$tval){?>
			<?
				$gift_cnt = $conn->getOne("select count(*) from gift_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.gift='$tkey' and t1.kind='B'");
			?>
			<tr>
				<td><?=$tval['title']?><br>(<?=$gift_cnt?>명)</td>
				<!-- <td><?=$tval['cnt']?>개</td> -->
				<td colspan=7 style="padding:0px;margin:0px;">
					<div class="scrollArea wtHolder " style="max-height:300px !important;padding:0px;margin:0px;border:0px;">
					<table cellpadding=0 cellspacing=0 width="100%;">
						<tr>
							<th style="width:30px;background:#263238;color:#ffffff;height:30px;">No</th>
							<th style="width:100px;background:#263238;color:#ffffff;border-left:1px solid #fff;">등록번호</th>
							<th style="width:130px;background:#263238;color:#ffffff;border-left:1px solid #fff;">구분</th>
							<th style="width:90px;background:#263238;color:#ffffff;border-left:1px solid #fff;">성명</th>
							<th style="width:90px;background:#263238;color:#ffffff;border-left:1px solid #fff;">면허번호</th>
							<th style="width:200px;background:#263238;color:#ffffff;border-left:1px solid #fff;">소속</th>
							<th style="background:#263238;color:#ffffff;border-left:1px solid #fff;">이메일</th>
							<th style="width:120px;background:#263238;color:#ffffff;border-left:1px solid #fff;">연락처</th>
							<th style="width:100px;background:#263238;color:#ffffff;border-left:1px solid #fff;">당첨일</th>
							<th style="width:50px;background:#263238;color:#ffffff;border-left:1px solid #fff;">관리</th>
						</tr>
						<?
							

							if($gift_cnt>0){
							$gift_query = "select t1.sid as gift_sid,t1.signdate as gift_date,t2.* from gift_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.gift='$tkey' and t1.kind='B' order by t1.signdate asc";
							$gift_result=$conn->query($gift_query);
							if(DB::isError($gift_result)) die($gift_result->getMessage());
							$n=1;
							while(is_array($g=$gift_result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<tr>
							<td style="height:30px;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>background:#F2F2F2;"><?=$n?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['etc_field2']?></td>
							<td style=";border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$_REG['reg_kind'][$g['reg_kind']]?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><a href="javascript:popup_call('registration/postform','sid=<?=$g['sid']?>')"><?=$g['name_kr']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['license_number']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['aff_kor']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['email']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=$g['cell']?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>"><?=date("m.d H:i",$g['gift_date'])?></td>
							<td style="border-left:1px solid #DCDCDC;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>">
								<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$g['gift_sid']?>','gift')">
							</td>
						</tr>
						<?$n++;}?>
						<?}else{?>
						<tr>
							<td colspan=8 style="height:30px;<?if($n!=1){?>border-top:1px solid #DCDCDC;<?}?>">당첨자가 없습니다.</td>
							
						</tr>
						<?}?>
					</table>
					</div>
				</td>
			</tr>
			<?}?>
			
		</tbody>
	</table>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

  
 