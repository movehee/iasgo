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





$search_txt = "";



$search .= "&amp;code=$code&amp;order=$order";





$query = "SELECT * FROM photo_tbl a left join login_tbl b on a.deviceid=b.deviceID where a.del='N' and a.code='".$code."' and a.tab='-1'";
echo $query."<br>";
$result = mysqli_query($conn, $query.$search_txt);
$totalRecord = $result->num_rows;


$query = "select * from ( SELECT a.title, a.sid p_sid, b.*,(select count(f.sid) from photo_favor_tbl f where photo_sid=a.sid) like_num FROM photo_tbl a left join login_tbl b on a.deviceid=b.deviceID where a.del='N' and a.code='".$code."' and a.tab='-1') A ";


if(!$order) $order = "like";

if($order == "like") {
	$query .=" order by like_num desc ";
}
else {
	$query .=" order by p_sid desc ";
}

$query .=" LIMIT ".$page*$num_per_page.",".$num_per_page;

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	echo $query;
}


$result = mysqli_query($conn, $query);



$cnt = $totalRecord - $page*$num_per_page;


$break_array = array();

?>
<div id="container" style="width: 1000px;">
	
		<h2 class="tooltipPoint" title="">포토이벤트</h2>
		
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

		 	<p class="btn tooltipPoint" title=""  style="float:left;margin-right:20px"><a href="./list.php?code=<?=$code?>" class="btnGrey">등록 관리</a></p>

			<p class="btn tooltipPoint" title="지난 행사 목록" style="float:left;margin-right:20px"><a href="./list2.php?code=<?=$code?>" class="btnDef">포토이벤트</a></p>
			
			<form id="search_form">
			<input type="hidden" name="code" value="<?=$code?>">
				<select class="excel_proc" name="order" style=" font-size:13px; width: 140px;  height: 40px; " onchange="$('#search_form').submit();">
					<option value="like" <?if($order=="like"){?>selected<?}?> >좋아요순</option>
					<option value="reg" <?if($order=="reg"){?>selected<?}?> >등록순</option>
				</select>
			</form>

			<div class="registTotal" style="float:right;">등록자 수 : <span class="registNum"><?=$totalRecord?></span>명</div> 
			<table class="tblList">
				<thead>
					<tr>
						<th width="4%">No</th>
						<th width="">제목</th>
						<th width="10%">이름</th>
						<th width="10%">구분</th>
						<th width="10%">면허번호</th>
						<th width="14%">연락처</th>
						<th width="20%">소속</th>
						<th width="8%">좋아요</th>
						
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
						<td><?=$d['title']?></td>
						<td><?=$d['name']?></td>
						<td><?=$member_type?></td>

						<td><?=$d['license_number']?></td>
						<td><?=$d['mobile']?></td>
						<td><?=$d['office']?></td>
						<td><?=$d['like_num']?></td>
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