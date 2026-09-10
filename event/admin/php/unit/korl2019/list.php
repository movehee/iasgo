<?include "header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$result_ss_chk = mysqli_query($conn, "SELECT score_settingYN FROM event_tbl where code='".$code."' ");
$result_ss_chk_row = mysqli_fetch_array($result_ss_chk);
$score_setting_yn = $result_ss_chk_row['score_settingYN'];



$num_per_page2 = 5;
$num_per_page = 50;
if(empty($page)) $page = 0;



$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);
$totalRecord2 = $row['cnt'];



$search_txt = "";


if($reg_money_gubun){
	$search_txt .= " and info".$reg_money_gubun_orderby." = '".$reg_money_gubun."'";
	$search .= "&amp;reg_money_gubun=$reg_money_gubun";
}
if($pay_chk){
	$search_txt .= " and pay_chk = '".$pay_chk."'";
	$search .= "&amp;pay_chk=$pay_chk";
}

if($reg_vip_gubun){

	if($reg_vip_gubun == '-1') {
		$search_txt .= " and ifnull(info".$reg_vip_gubun_orderby.",'')!=''";
	}
	else if($reg_vip_gubun == '-2') {
		$search_txt .= " and ifnull(info".$reg_vip_gubun_orderby.",'')=''";
	}
	else {
		$search_txt .= " and info".$reg_vip_gubun_orderby." = '".$reg_vip_gubun."'";
	}

	$search .= "&amp;reg_vip_gubun=$reg_vip_gubun";
}


if($memoYN=="Y"){
	$search_txt .= " and memo not in ('')";
	$search .= "&amp;memoYN=$memoYN";
}



if($indate){
	
	//$search_txt .= "and pay_date>".$eventdate." and pay_date<".($eventdate+86400);
	$a_result = mysqli_query($conn, "select * from agenda_tbl where del='N' and sid='".$indate."'");
	$a = mysqli_fetch_array($a_result);
	$search_txt .= " and check_in".$a['day'].">'0'";

	$search .= "&amp;indate=$indate";
}

if($keyword){

	$search_txt .= " and (";

	for($i=1;$i<41;$i++){
		if($i>1){
			$search_txt .= " or ";
		}
		$search_txt .= "info".$i." like '%".$keyword."%'";

	}
	$search_txt .= " )";

	$search .= "&amp;keyword=$keyword";
}


$query = "SELECT * FROM login_tbl where code='".$code."' ";
$result = mysqli_query($conn, $query.$search_txt);
$totalRecord = $result->num_rows;


$query.=" order by sid desc LIMIT ".$page*$num_per_page.",".$num_per_page;

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	echo $query;
}


$result = mysqli_query($conn, $query);



$cnt = $totalRecord - $page*$num_per_page;


$break_array = array();

?>
<div id="container" style="width: 1000px;">
	
		<h2 class="tooltipPoint" title="">등록 관리</h2>
		
		<div class="btnArea" style="width:100%;">
			<!-- <span class="btn" style="float:right; margin-right:10px;">
				<a onclick="javascript:money_set('<?=$code?>')"  class="btnDef tooltipPoint" title="현장,사전등록 금액 입력값 셋팅(self registration용 금액선택할때 사용)"><i class="fas fa-cog"></i>Money</a>
				<a onclick="javascript:add2('<?=$code?>')"  class="btnDef tooltipPoint" title="self registration용 화면/현장등록 self desk운영 시 해당 화면 전체보기로 띄워놓고 사용"><i class="fas fa-plus-circle"></i>사용자 등록</a>
				
				<select class="excel_proc" e-link="excel.php?code=<?=$code?>" style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">엑셀</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>
			
			
				<a onclick="javascript:print2('<?=$code?>')" class="btnDef tooltipPoint" title="전체 출력 / 체크박스 선택 후 프린트 누르면 선택된 것만 출력/개별 출력은 등록자 우측 프린트 아이콘누르면 개별 출력가능/print.php 생성 후 소스 에서 행사별 위치 맞춰야함"><i class="fas fa-print"></i>프린트</a>
				<a onclick="javascript:statistics('<?=$code?>')" class="btnDef tooltipPoint" title="사전, 현장 금액통계/입금상태 완료만 통계로 잡힘"><i class="far fa-chart-bar"></i>금액통계</a>
				<a onclick="javascript:set('<?=$code?>')" class="btnDef tooltipPoint" title="등록항목관리에서 항목 셋팅 후 전체 설정 셋팅해야함"><i class="fas fa-cog"></i>Setting</a>
				<a  onclick="javascript:set2('<?=$code?>')" class="btnDef tooltipPoint" title="등록 폼 설정/사전등록데이터 있을 경우 동일하게 맞추는게좋음"><i class="fas fa-cog"></i>등록항목관리</a>
				<a  onclick="javascript:add('<?=$code?>')" class="btnDef tooltipPoint" title="관리자 등록(기존 사용하는 임의등록과 동일)"><i class="fas fa-plus-circle"></i>관리자등록</a>
			</span>
			 -->		</div>
		<div class="contents member">

		 	<p class="btn tooltipPoint" title=""  style="float:left;margin-right:20px"><a href="./list.php?code=<?=$code?>" class="btnDef">등록 관리</a></p>

			<p class="btn tooltipPoint" title="지난 행사 목록" style="float:left;margin-right:20px"><a href="./list2.php?code=<?=$code?>" class="btnGrey">포토이벤트</a></p>


			<div class="registTotal" style="float:right;">등록자 수 : <span class="registNum"><?=$totalRecord?></span>명</div> 
			<table class="tblList">
				<thead>
					<tr>
						<th width="4%">No</th>
						<th width="12%">이름</th>
						<th width="10%">구분</th>
						<th width="10%">면허번호</th>
						<th width="14%">연락처</th>
						<th>소속</th>
						<th width="8%">설문참여</th>
						<th width="8%">부스이벤트</th>
						<th width="8%">부스이벤트당첨</th>
						
						
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){
					$m_deviceid = $d['deviceID'];

					if($d['type'] == '1') $member_type="사전등록";
					else if($d['type'] == '2') $member_type="회원가입";
					else $member_type = "";
				?>
					<tr class="bg" id="<?=$d['sid']?>">

						<td><?=$cnt?></td>
						<td><?=$d['name']?></td>
						<td><?=$member_type?></td>

						<td><?=$d['license_number']?></td>
						<td><?=$d['mobile']?></td>
						<td><?=$d['office']?></td>
						<td>
						<?
							$f_query = "SELECT sid FROM feedback_result_tbl where code='".$code."' and deviceid='$m_deviceid' ";
							$f_result = mysqli_query($conn, $f_query);
							if($f_result->num_rows) echo "Y";
							else echo "N";
						?>
						</td>
						<td>
						<?
							$b_query = "SELECT a.sid FROM booth_event_tbl a, booth_tbl b where a.booth_sid=b.sid and a.code='".$code."' and b.code='".$code."' and a.user_sid='$d[sid]' ";
//						echo $b_query."<br>";
							$b_result = mysqli_query($conn, $b_query);
							echo $b_result->num_rows;
						?>
						</td>

						<td>
						
						<?
							$g_query = "SELECT sid FROM booth_event_gift_tbl where code='".$code."' and user_sid='$d[sid]' ";
							$g_result = mysqli_query($conn, $g_query);
							if($g_result->num_rows) echo "Y";
							else echo "N";
						?>
						</td>
						
					</tr>
				<?
					$cnt--;
						}?>
					
				</tbody>
			</table>

			<ul class="pager">

			<?
				$s = floor($page / $num_per_page2);
				$s = $s * $num_per_page2;
				$max = ceil($totalRecord / $num_per_page);
				if($max>$s+$num_per_page2){
					$e = $s+$num_per_page2;
				}else{
					$e = $max;
				}
			?>


			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=0<?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-double-left"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page-$num_per_page2>0){ echo $page-3;}else{echo "0";}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-left"></i></a></li>
			<?

				for($i = $s; $i < $e ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?><?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>

			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page+$num_per_page2>$max-1){echo $max-1;}else{echo $page+$num_per_page2;}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-right"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$max-1?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-double-right"></i></a></li>
			</ul>
		</div>
		<!-- //contents -->
			
		
    <p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
    </div> <!-- //container -->
	


   
<?include "./footer.php";?>