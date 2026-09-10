<?
##### 환경파일 include
include "config.php";


require_once($_header_file);
if(!isAdminLogined()){
	putMessageBack("관리자 전용 페이지 입니다.");
}
	require_once './conf/class.Page.php';
	require_once './conf/class.Block.php';

	$search_query = "";

	if($search_key) $search_query .= " and ${search_key} like '%${search_value}%'";

	$search_url ="&search_key=${search_key}&search_value=${search_value}";

	####### 전체 게시물의 수
	$query="SELECT count(c_index) FROM tp_addgrcode WHERE c_index is not null ${search_query} ";
	$totalRecord=$conn->getOne($query);
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());


	####### 페이징 처리
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();

	$query = "SELECT * FROM tp_addgrcode WHERE c_index is not null ${search_query} order by c_index desc";
	
	//echo $query."<br/>";
	
	$query.= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$excel_query = "SELECT * FROM tp_addgrcode WHERE c_index is not null ${search_query} order by c_index desc";

	# 가상번호 입력
	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);

	# 블럭단위 계산
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock)
	   $lastPageInBlock = $totalPage;
?>
<br/>
<script type="text/javascript">
	$(function(){
		$('.insert_group').click(function(){
			window.open("insert_group.php","insert_pop","width=500, height=150");
		});
		
		$('#search_submit').click(function(){
			$('#searchForm').submit();
		});
		
	});

	function modify_pop(c_index){
		window.open("insert_group.php?c_index="+c_index,"insert_pop","width=500, height=150");
	}
	function del_chk(c_index, count){
/*
		if(count > 0){
			alert("등록 인원이 있는 그룹은 삭제하실 수 없습니다.");
		}else{
*/
			if(confirm("해당 그룹을 삭제하시겠습니까?")){
				location.href="group_delete.php?c_index="+c_index+"&page=<?=$page?><?=$search_url?>";
				return true;
			}
/* 		} */
	}

	function view_pop(sid){
		window.open("view.php?sid="+sid,"view_pop","width=800, height=300, scrollbars=yes");
	}
</script>

<div class="searchArea">
	<form method="get" action="<?=$PHP_SELF?>" id="searchForm" name="searchForm">
	<div class="tblWrap">
		<table class="tblSearch" summary="메일그룹 검색 상세내역" cellspacing="0" cellpadding="0">
			<caption>메일그룹 검색</caption>
			<colgroup>
				<col style="width:20%;" />
				<col style="width:80%;" />
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="search_key">주소록명</label></th>
					<td><input type="hidden" name="search_key" id="search_key" value="c_grname">	
						<input class="block" title="상세 검색어 입력" type="text" name="search_value" id="search_value" style="width:80%;" value="<?=$search_value?>">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="btnArea btn">
		<input class="btnDef" type="submit" value="검색" />
		<input class="btnGrey" type="button" value="검색 초기화" onclick="location.href='<?=$PHP_SELF?>'" />
	</div>	
	
	</form>
</div>

<div class="resultArea">
	<div class="defTbl admin tm30">
		<table class="tblResult" summary="메일그룹 목록 상세내역" cellspacing="0" cellpadding="0">
			<caption>메일그룹 목록</caption>
			<colgroup>
				<col style="width:8%;" />
				<col />
				<col style="width:10%;" />
				<col style="width:8%;" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">주소록명</th>
					<th scope="col">인원</th>
					<th scope="col">관리</th>
				</tr>
			</thead>
			<tbody>
				<form method="post" action="mem_card.php" name="mem_frm" id="mem_frm">
				<? while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))):?>
				<tr>
					<td class="de_td3"><?=$virtualRecordNo?></td>
					<td class="de_td3" ><a href="group_detail_list.php?c_index=<?=$d['c_index']?>"><?=$d['c_grname']?></a></td>
					<td class="de_td3">
						<?
							$query = "select count(c_index) from tp_addgrinfo where c_code='${d['c_index']}'";
							$count = $conn->getOne($query);
							echo $count;
						?>
					</td>
					<td class="de_td3">
						<a href="#" title="팝업 - 새 창 열림" onclick="modify_pop('<?=$d['c_index']?>'); "><img src="/image/admin/modify.gif" alt="수정" /></a>&nbsp;
						<a href="#" title="팝업 - 새 창 열림" onclick="del_chk('<?=$d['c_index']?>','<?=$count?>')"><img src="/image/admin/delete.gif" alt="삭제" /></a>
					</td>
				</tr>
				<? $virtualRecordNo--;endwhile?>
				</form>
			</tbody>
		</table>
	</div>
	
	<div class="ar tp10">
		<span class="btnAdmin medium navy"><button type="button" onclick="window.open('insert_group.php','insert_pop','width=500, height=150'); return false;">그룹추가</button></span>
	</div>	
	
	<?include $DOCUMENT_ROOT."admin/include.page.php"?>	
	
</div>
<? require_once($_footer_file);?>